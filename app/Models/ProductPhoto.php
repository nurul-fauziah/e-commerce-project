<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPhoto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'st_product_photos';

    protected $fillable = [
        'photo',
        'st_product_id',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'st_product_id');
    }
}
