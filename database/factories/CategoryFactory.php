<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Category::class, function (Faker $faker) {
    return [
        'name'=>$faker -> sentence(mt_rand(2,4)),
        'type'=>1,
    ];
});
