<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductSubcategory;
use Faker\Generator as Faker;

$factory->define(ProductSubcategory::class, function (Faker $faker) {
	static $num=1;
    return [
        'product_id' => $num++,
        'subcategory_id' => 1
    ];
});
