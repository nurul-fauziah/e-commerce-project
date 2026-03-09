<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'st_booking_trx_id',
        'city',
        'post_code',
        'address',
        'quantity',
        'sub_total_amount',
        'grand_total_amount',
        'discount_amount',
        'is_paid',
        'st_product_id',
        'variant_details', // Nyimpen info varian yang dibeli
        'st_promo_code_id',
        'proof',
    ];

    public static function generateUniqueCode(){
        $prefix = 'STRX-';
        do {
            $randomString = $prefix . mt_rand(1000, 9999);
        } while (self::where('st_booking_trx_id', $randomString)->exists());

        return $randomString;
    }

    public function product(): BelongsTo{
        return $this->belongsTo(Product::class, 'st_product_id');
    }

    public function promoCode(): BelongsTo{
        return $this->belongsTo(PromoCode::class, 'st_promo_code_id');
    }
}
