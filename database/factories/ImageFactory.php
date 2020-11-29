<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    static $num=1;
    return [
        'product_id' => $num++,
        'image' => 'imagen.jpg'
    ];
});
