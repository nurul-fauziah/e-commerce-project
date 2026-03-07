<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

use App\Models\Brand;
use App\Models\Category;
use App\Models\ShoePhotos;
use App\Models\ShoeSize;

class Shoe extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'about',
        'price',
        'stock',
        'is_popular',
        'category_id',
        'brand_id',
    ];

    public function setNameAttribute($value){
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function brand(): BelongsTo{
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function category(): BelongsTo{
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function photos()
    {
        return $this->hasMany(ShoePhotos::class, 'shoe_id');
    }

    public function sizes()
    {
        return $this->hasMany(ShoeSize::class, 'shoe_id');
    }
}
