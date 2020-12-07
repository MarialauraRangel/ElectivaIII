<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
	use SoftDeletes;

    protected $fillable = ['code', 'slug', 'discount', 'use', 'limit'];

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
