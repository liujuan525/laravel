<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Reply::class, function (Faker $faker) {
    // 随机取一个月以内的时间
    $time = $faker->dateTimeThisMonth();

    $topic_id = \App\Models\Topic::pluck('id')->random();
    $user_id = \App\Models\User::pluck('id')->random();

    return [
        'topic_id' => $topic_id,
        'user_id' => $user_id,
        'content' => $faker->sentence(),
        'created_at' => $time,
        'updated_at' => $time,
    ];
});
