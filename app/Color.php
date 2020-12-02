<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
	use SoftDeletes;

    protected $fillable = ['name', 'slug', 'color'];

    public function products() {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }
}
