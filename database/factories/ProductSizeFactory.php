<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductSize;
use Faker\Generator as Faker;

$factory->define(ProductSize::class, function (Faker $faker) {
    static $num=1;
    return [
        'product_id' => $num++,
        'size_id' => 1
    ];
});
