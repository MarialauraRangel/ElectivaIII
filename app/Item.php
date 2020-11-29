<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['price', 'qty', 'subtotal', 'product_id', 'size_id', 'color_id', 'order_id'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function size() {
        return $this->belongsTo(Size::class);
    }

    public function color() {
        return $this->belongsTo(Color::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
