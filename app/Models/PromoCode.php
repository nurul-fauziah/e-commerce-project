<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PromoCode extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'st_promo_codes';

    protected $fillable = [
        'code',
        'discount_amount',
    ];

    public function productTransactions(): HasMany
    {
        return $this->hasMany(ProductTransaction::class, 'st_promo_code_id');
    }
}
