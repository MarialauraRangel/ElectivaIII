<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
	use SoftDeletes;
	
    protected $fillable = ['name', 'slug', 'category_id'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function products() {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }
}
