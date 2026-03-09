<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'st_products';

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'about',
        'price',
        'stock',
        'is_popular',
        'st_category_id',
        'st_brand_id',
    ];

    public function setNameAttribute($value){
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function brand(): BelongsTo{
        return $this->belongsTo(Brand::class, 'st_brand_id');
    }

    public function category(): BelongsTo{
        return $this->belongsTo(Category::class, 'st_category_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class, 'st_product_id');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class, 'st_product_id');
    }
}
