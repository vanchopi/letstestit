<?php

$factory->define(App\Test::class, function (Faker\Generator $faker) {
    return [
        "category_id" => factory('App\Category')->create(),
        "title" => $faker->name,
    ];
});
