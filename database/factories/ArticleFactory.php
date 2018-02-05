<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    $user_id = \App\User::pluck('id')->random();
    $category_id = \App\Category::pluck('id')->random();
    return [
        'title' => $faker -> sentence(mt_rand(3,5)),
        'content' => $faker -> sentence,
        'category_id'=> $category_id,
        'user_id'=> $user_id,
    ];
});
