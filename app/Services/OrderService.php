<?php

namespace App\Services;

use App\Models\ProductTransaction;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\PromoCodeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class OrderService
{
    protected $orderRepository;
    protected $productRepository;
    protected $promoCodeRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ProductRepositoryInterface $productRepository,
        PromoCodeRepositoryInterface $promoCodeRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->promoCodeRepository = $promoCodeRepository;
    }

    public function beginOrder(array $data)
    {
        $orderData = [
            'variant_details' => $data['variant_details'] ?? null,
            'product_id' => $data['product_id'],
            'variant_id' => $data['variant_id'] ?? null,
            'quantity' => 1, // Default quantity
        ];

        $this->orderRepository->saveToSession($orderData);
    }

    public function getOrderDetails()
    {
        $orderData = $this->orderRepository->getOrderFromSession();
        $product = null;

        if (isset($orderData['product_id'])) {
            $product = $this->productRepository->find($orderData['product_id']);

            $quantity = $orderData['quantity'] ?? 1;
            $subTotalAmount = $product->price * $quantity;
            $taxRate = 0.11;
            $totalTax = $subTotalAmount * $taxRate;
            $grandTotalAmount = $subTotalAmount + $totalTax;

            $orderData['sub_total_amount'] = $subTotalAmount;
            $orderData['total_tax'] = $totalTax;
            $orderData['grand_total_amount'] = $grandTotalAmount;
        }

        return compact('orderData', 'product');
    }

    public function updateCustomerData(array $data)
    {
        $this->orderRepository->updateSessionData($data);
    }

    /**
     * Memindahkan data dari Session ke Database
     */

    public function finalizeOrder()
    {
        $details = $this->getOrderDetails();
        $orderData = $details['orderData'];
        $productTransactionId = null;

        if (!isset($orderData['product_id'])) {
            \Log::error('Finalize Order Error: Product ID missing in session');
            return null;
        }

        try {
            DB::transaction(function () use (&$productTransactionId, $orderData) {
                $data = [
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => $orderData['phone'] ?? '',
                    'city' => $orderData['city'] ?? '',
                    'post_code' => $orderData['post_code'] ?? '',
                    'address' => $orderData['address'] ?? '',

                    'booking_trx_id' => ProductTransaction::generateUniqueCode(),
                    'quantity' => $orderData['quantity'] ?? 1,
                    'sub_total_amount' => $orderData['sub_total_amount'] ?? 0,
                    'grand_total_amount' => $orderData['grand_total_amount'] ?? 0,
                    'discount_amount' => $orderData['discount_amount'] ?? 0,

                    // SINKRONISASI DENGAN DOKUMEN PR (Poin 2.5)
                    'status' => 'pending',
                    'is_paid' => false,

                    'variant_details' => $orderData['variant_details'] ?? null,
                    'st_product_id' => $orderData['product_id'],
                    'st_promo_code_id' => $orderData['promo_code_id'] ?? null,
                    'user_id' => Auth::id(),
                ];

                $newTransaction = $this->orderRepository->createTransaction($data);
                $productTransactionId = $newTransaction->id;
            });

            return $productTransactionId;
        } catch (\Exception $e) {
            \Log::error('Finalize Order Error: ' . $e->getMessage());
            return null;
        }
    }

    public function getSnapToken($transactionId) {
        $transaction = ProductTransaction::with('product')->findOrFail($transactionId);

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->booking_trx_id,
                'gross_amount' => (int)$transaction->grand_total_amount,
            ],
            'customer_details' => [
                'first_name' => $transaction->name,
                'email' => $transaction->email,
                'phone' => $transaction->phone,
            ],
            'item_details' => [
                [
                    // PERBAIKAN: Gunakan st_product_id sesuai Model lo
                    'id' => $transaction->st_product_id,
                    'price' => (int)($transaction->grand_total_amount / $transaction->quantity),
                    'quantity' => $transaction->quantity,
                    'name' => $transaction->product->name,
                ]
            ]
        ];

        return Snap::getSnapToken($params);
    }
}
