<?php

use Faker\Generator as Faker;

// $factory->define(Model::class, function (Faker $faker) {
//     return [
//         //
//     ];
// });

$factory->define(App\Company::class, function (Faker $faker) {
    return [
        'title' => $faker->company,
        'user_id' => auth()->user()->id
    ];
});
