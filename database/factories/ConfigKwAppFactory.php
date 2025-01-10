<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ConfigKwApp;
use Faker\Generator as Faker;

$factory->define(ConfigKwApp::class, function (Faker $faker) {

    return [
        'country' => $faker->word,
        'name' => $faker->word
    ];
});
