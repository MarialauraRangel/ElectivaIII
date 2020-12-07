<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['slug', 'subject', 'subtotal', 'discount', 'total', 'fee', 'balance', 'method', 'currency', 'state', 'user_id', 'coupon_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function coupon() {
        return $this->belongsTo(Coupon::class);
    }

    public function transfer() {
        return $this->hasOne(Transfer::class);
    }

    public function paypal() {
        return $this->hasOne(Paypal::class);
    }

    public function order() {
        return $this->hasOne(Order::class);
    }
}
