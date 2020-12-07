<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['slug', 'subtotal', 'discount', 'total', 'fee', 'balance', 'phone', 'address', 'state', 'user_id', 'coupon_id', 'payment_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function coupon() {
        return $this->belongsTo(Coupon::class);
    }

    public function payment() {
        return $this->belongsTo(Payment::class);
    }

    public function items() {
        return $this->hasMany(Item::class);
    }
}
