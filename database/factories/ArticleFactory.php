<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker -> sentence(mt_rand(3,10)),
        'content' => $faker -> sentence(),
    ];
});
