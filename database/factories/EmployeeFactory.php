<?php

use App\Company;
use App\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'company_id' => Company::count() ? Company::inRandomOrder()->first()->id : null,
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->e164PhoneNumber,
    ];
});
