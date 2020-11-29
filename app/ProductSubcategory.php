<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSubcategory extends Model
{
    protected $table = 'product_subcategory';

    protected $fillable = ['product_id', 'subcategory_id'];
}
