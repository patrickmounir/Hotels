<?php

use Faker\Generator as Faker;

$factory->define(App\Hotel::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
    ];
});
