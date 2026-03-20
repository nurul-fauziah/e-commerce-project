<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'st_transaction_details';

    protected $fillable = [
        'st_product_transaction_id',
        'st_product_id',
        'variant_details',
        'quantity',
        'price',
        'subtotal',
    ];

    // Relasi balik ke Transaksi Utama (Header)
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(ProductTransaction::class, 'st_product_transaction_id');
    }

    // Relasi ke Produk (Hardware)
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'st_product_id');
    }
}
