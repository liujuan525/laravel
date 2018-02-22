<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {
    $sentence = $faker->sentence();

    // 随机取一个月以内的时间
    $updated_at = $faker->dateTimeThisMonth();
    // 传参为生成最大时间不超过，创建时间永远比更改时间要早
    $created_at = $faker->dateTimeThisMonth($updated_at);

    $user_id = \App\Models\User::pluck('id')->random();

    $category_id = \App\Models\Category::pluck('id')->random();

    return [
        'title' => $sentence,
        'body' => $faker->text(),
        'user_id' => $user_id,
        'category_id' => $category_id,
        'excerpt' => $sentence,
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
