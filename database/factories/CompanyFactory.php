<?php

use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'email' => mt_rand(1, 100) > 20 ? $faker->unique()->safeEmail : null,
        'website' => mt_rand(1, 100) > 20 ? 'https://www.' . $faker->unique()->domainName : null,
    ];
});
