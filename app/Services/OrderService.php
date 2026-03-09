<?php

namespace App\Services;

use App\Models\ProductTransaction;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\PromoCodeRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    protected $orderRepository;
    protected $productRepository;
    protected $categoryRepository;
    protected $promoCodeRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        PromoCodeRepositoryInterface $promoCodeRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->promoCodeRepository = $promoCodeRepository;
    }

    public function beginOrder(array $data)
    {
        $orderData = [
            // Ganti istilah 'size' jadi 'variant' biar lebih cocok buat elektronik
            'variant_details' => $data['variant_details'] ?? $data['product-size'], 
            'product_id' => $data['product_id'],
            'variant_id' => $data['variant_id'] ?? $data['size_id'],
        ];

        $this->orderRepository->saveToSession($orderData);
    }

    public function getOrderDetails()
    {
        $orderData = $this->orderRepository->getOrderFromSession();
        $product = $this->productRepository->find($orderData['product_id']);

        $quantity = $orderData['quantity'] ?? 1;
        $subTotalAmount = $product->price * $quantity;

        $taxRate = 0.11; // 11% PPN
        $totalTax = $subTotalAmount * $taxRate;

        $grandTotalAmount = $subTotalAmount + $totalTax;

        $orderData['sub_total_amount'] = $subTotalAmount;
        $orderData['total_tax'] = $totalTax;
        $orderData['grand_total_amount'] = $grandTotalAmount;

        return compact('orderData', 'product');
    }

    public function applyPromoCode(string $code, int $subTotalAmount)
    {
        $promo = $this->promoCodeRepository->findByCode($code);

        // REVISI: Cek jika promo ADA (bukan tidak ada)
        if ($promo) {
            $discount = $promo->discount_amount;
            $grandTotalAmount = $subTotalAmount - $discount;
            $promoCodeId = $promo->id;
            
            return [
                'discount' => $discount, 
                'grand_total_amount' => $grandTotalAmount,
                'promoCodeId' => $promoCodeId
            ];
        }

        return ['error' => 'Kode promo tidak valid atau sudah kadaluwarsa'];
    }

    public function saveBookingTransaction(array $data)
    {
        $this->orderRepository->saveToSession($data);
    }

    public function updateCustomerData(array $data)
    {
        $this->orderRepository->updateSessionData($data);
    }

    public function paymentConfirm(array $validated)
    {
        $orderData = $this->orderRepository->getOrderFromSession();
        $productTransactionId = null;

        try {
            DB::transaction(function () use ($validated, &$productTransactionId, $orderData) {
                if (isset($validated['proof'])){
                    $proofPath = $validated['proof']->store('proofs', 'public');
                    $validated['proof'] = $proofPath;
                }

                $validated['name'] = $orderData['name'];
                $validated['email'] = $orderData['email'];
                $validated['phone'] = $orderData['phone'];
                $validated['address'] = $orderData['address'];
                $validated['post_code'] = $orderData['post_code'];
                $validated['city'] = $orderData['city'];
                $validated['quantity'] = $orderData['quantity'];
                $validated['sub_total_amount'] = $orderData['sub_total_amount'];
                $validated['grand_total_amount'] = $orderData['grand_total_amount'];
                $validated['discount_amount'] = $orderData['discount_amount'] ?? 0;
                $validated['promo_code_id'] = $orderData['promo_code_id'] ?? null;
                $validated['product_id'] = $orderData['product_id'];
                $validated['variant_details'] = $orderData['variant_details'] ?? null;
                $validated['is_paid'] = false;
                
                // REVISI: Sesuaikan nama method dengan yang ada di Model ProductTransaction
                $validated['booking_trx_id'] = ProductTransaction::generateUniqueCode();

                $newTransaction = $this->orderRepository->createTransaction($validated);
                $productTransactionId = $newTransaction->id;
            });

        } catch (\Exception $e) {
            Log::error('Error in payment confirmation: ' . $e->getMessage());
            return null;
        }

        return $productTransactionId;
    }
}