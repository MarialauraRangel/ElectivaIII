<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = ['reference', 'payment_id'];

    public function payment() {
        return $this->belongsTo(Payment::class);
    }
}
