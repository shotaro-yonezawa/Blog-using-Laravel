<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'company_id' => $faker->numberBetween($min = 1, $max = 10), 
        'product_name' => $faker->word,
        'price' => $faker->numberBetween($min = 80, $max = 180),
        'stock' => $faker->numberBetween($min = 0, $max = 500),
        'comment' => $faker->realText
    ];
});
