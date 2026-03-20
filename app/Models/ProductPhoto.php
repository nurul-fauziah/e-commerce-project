<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPhoto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'st_product_photos';

    protected $fillable = [
        'photo',
        'st_product_id',
    ];
}
