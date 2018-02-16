<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Article::class, function (Faker $faker) {
    $user_id = \App\Models\User::pluck('id')->random();
    $category_id = \App\Models\Category::pluck('id')->random();
    return [
        'title' => $faker -> sentence(mt_rand(3,5)),
        'content' => $faker -> sentence,
        'category_id'=> $category_id,
        'user_id'=> $user_id,
    ];
});
