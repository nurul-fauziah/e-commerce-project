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
        'variant_name', // Misal: RAM, Storage
        'variant_value', // Misal: 16GB, 512GB
        'st_product_id',
    ];
}
