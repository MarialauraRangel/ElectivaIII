<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ColorProduct;
use Faker\Generator as Faker;

$factory->define(ColorProduct::class, function (Faker $faker) {
    static $num=1;
    return [
        'product_id' => $num++,
        'color_id' => 1
    ];
});
