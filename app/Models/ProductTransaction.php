<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User; // Pastikan model User di-import

class ProductTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'st_product_transactions';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'booking_trx_id',
        'city',
        'post_code',
        'address',
        'sub_total_amount',
        'grand_total_amount',
        'discount_amount',
        'status',
        'is_paid',
        'st_promo_code_id',
        'proof',
        'user_id',
    ];

    public static function generateUniqueCode(){
        $prefix = 'STRX-';
        do {
            $randomString = $prefix . mt_rand(1000, 9999);
        } while (self::where('booking_trx_id', $randomString)->exists());

        return $randomString;
    }

    public function promoCode(): BelongsTo
    {
        return $this->belongsTo(PromoCode::class, 'st_promo_code_id');
    }

    // Relasi One-to-Many ke Transaction Details
    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'st_product_transaction_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
