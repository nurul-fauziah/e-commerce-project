<?php

namespace App\Services;

use App\Models\ProductTransaction;
use App\Models\TransactionDetail;
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

    public function beginCheckout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return false;

        $subTotalAmount = 0;
        foreach ($cart as $item) {
            $subTotalAmount += $item['subtotal'];
        }

        $taxRate = 0.11; // PPN 11%
        $totalTax = $subTotalAmount * $taxRate;
        $grandTotalAmount = $subTotalAmount + $totalTax;

        $checkoutData = [
            'cart_items' => $cart,
            'sub_total_amount' => $subTotalAmount,
            'total_tax' => $totalTax,
            'grand_total_amount' => $grandTotalAmount,
            'discount_amount' => 0,
        ];

        $this->orderRepository->saveToSession($checkoutData);
        return true;
    }

    public function getOrderDetails()
    {
        $orderData = $this->orderRepository->getOrderFromSession();
        return compact('orderData');
    }

    public function updateCustomerData(array $data)
    {
        $this->orderRepository->updateSessionData($data);
    }

    public function finalizeOrder()
    {
        $details = $this->getOrderDetails();
        $orderData = $details['orderData'];
        $productTransactionId = null;

        if (empty($orderData['cart_items'])) return null;

        try {
            DB::transaction(function () use (&$productTransactionId, $orderData) {
                // 1. Simpan Header Transaksi
                $transaction = ProductTransaction::create([
                    'user_id'            => Auth::id(),
                    'name'               => Auth::user()->name,
                    'email'              => Auth::user()->email,
                    'phone'              => $orderData['phone'] ?? '',
                    'city'               => $orderData['city'] ?? '',
                    'post_code'          => $orderData['post_code'] ?? '',
                    'address'            => $orderData['address'] ?? '',
                    'booking_trx_id'     => ProductTransaction::generateUniqueCode(),
                    'sub_total_amount'   => $orderData['sub_total_amount'],
                    'grand_total_amount' => $orderData['grand_total_amount'],
                    'discount_amount'    => $orderData['discount_amount'] ?? 0,
                    'status'             => 'pending',
                    'is_paid'            => false,
                ]);

                // 2. Simpan Detail Transaksi
                foreach ($orderData['cart_items'] as $item) {
                    TransactionDetail::create([
                        'st_product_transaction_id' => $transaction->id,
                        'st_product_id'             => $item['product_id'],
                        'variant_details'           => $item['variant_details'],
                        'quantity'                  => $item['quantity'],
                        'price'                     => $item['price'],
                        'subtotal'                  => $item['subtotal'],
                    ]);
                }

                $productTransactionId = $transaction->id;
                session()->forget('cart');
            });

            return $productTransactionId;
        } catch (\Exception $e) {
            Log::error('Finalize Order Error: ' . $e->getMessage());
            return null;
        }
    }

    public function getSnapToken($transactionId) {
        $transaction = ProductTransaction::with('transactionDetails.product')->findOrFail($transactionId);

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false); // Fallback to false if not set
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $midtransItems = [];
        foreach ($transaction->transactionDetails as $detail) {
            $midtransItems[] = [
                'id'       => $detail->st_product_id,
                // PERBAIKAN: Harus bulat (integer)
                'price'    => (int) round($detail->price),
                'quantity' => $detail->quantity,
                'name'     => substr($detail->product->name . ' (' . $detail->variant_details . ')', 0, 50),
            ];
        }

        // Tambahkan PPN sebagai item
        $taxAmount = (int) round($transaction->sub_total_amount * 0.11);
        if ($taxAmount > 0) {
            $midtransItems[] = [
                'id'       => 'TAX-PPN',
                'price'    => $taxAmount,
                'quantity' => 1,
                'name'     => 'PPN (11%)',
            ];
        }

        // Hitung ulang total gross_amount berdasarkan total item (Wajib di Midtrans)
        $calculatedGrossAmount = 0;
        foreach ($midtransItems as $item) {
            $calculatedGrossAmount += ($item['price'] * $item['quantity']);
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $transaction->booking_trx_id,
                // PERBAIKAN: Gunakan total yang dihitung ulang
                'gross_amount' => $calculatedGrossAmount,
            ],
            'customer_details' => [
                'first_name' => $transaction->name,
                'email'      => $transaction->email,
                'phone'      => $transaction->phone,
            ],
            'enabled_payments' => ['qris', 'gopay', 'shopeepay', 'bank_transfer'],
            'item_details'     => $midtransItems,
        ];

        return Snap::getSnapToken($params);
    }
}
