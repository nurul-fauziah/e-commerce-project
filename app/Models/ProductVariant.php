<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'st_product_variants';

    protected $fillable = [
        'st_product_id',
        'sku',          // Tambahkan SKU (Stock Keeping Unit)
        'price',        // Harga khusus varian ini (misal 512GB lebih mahal dari 256GB)
        'stock',        // Stok khusus varian ini
        'attributes',   // Kolom sakti kita (JSON)
    ];

    protected $casts = [
        'attributes' => 'array',
    ];
}
