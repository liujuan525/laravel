<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'name'=>$faker -> sentence(mt_rand(2,4)),
        'type'=>1,
    ];
});
