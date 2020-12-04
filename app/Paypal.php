<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paypal extends Model
{
    protected $fillable = ['paypal_payer_id', 'paypal_payment_id', 'payment_id'];

    public function payment() {
        return $this->belongsTo(Payment::class);
    }
}
