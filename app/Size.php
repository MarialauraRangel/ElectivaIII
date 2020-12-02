<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
	use SoftDeletes;

    protected $fillable = ['name', 'slug'];

    public function products() {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }
}
