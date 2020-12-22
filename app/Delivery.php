<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = ['street', 'house', 'address', 'location_id', 'order_id'];

    public function location() {
	  	return $this->belongsTo(Location::class);
	}

	public function order() {
	  	return $this->belongsTo(Order::class);
	}
}
