<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    const UNAVAILABLE_PROMOCODE = 0;
    const AVAILABLE_PROMOCODE = 1;

    protected $fillable = [
        'gift_code',
        'discount',
        'validity',
        'activation_date',
        'expiry_date',
        'usage_limit',
        'status',
        'description'
    ];

    public function isAvailable()
    {
        return $this->status == PromoCode::AVAILABLE_PROMOCODE; // status = 1;
    }
}
