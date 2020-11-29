<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ['name', 'slug', 'color'];

    public function products() {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }
}
