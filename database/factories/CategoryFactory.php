<?php

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name'          =>  $faker->name,
        
        'parent_id'     =>  1,
        'menu'          =>  1,
    ];
});