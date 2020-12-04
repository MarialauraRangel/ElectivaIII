<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'code', 'description', 'qty', 'price', 'discount', 'min', 'max', 'state'];

    public function subcategories() {
        return $this->belongsToMany(Subcategory::class)->withTimestamps();
    }

    public function images() {
        return $this->hasMany(Image::class);
    }

    public function colors() {
        return $this->belongsToMany(Color::class)->withTimestamps();
    }

    public function sizes() {
        return $this->belongsToMany(Size::class)->withTimestamps();
    }
}
