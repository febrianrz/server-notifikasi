<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Notification;
use Faker\Generator as Faker;

$factory->define(Notification::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
