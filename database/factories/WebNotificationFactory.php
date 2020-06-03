<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\WebNotification;
use Faker\Generator as Faker;

$factory->define(WebNotification::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
