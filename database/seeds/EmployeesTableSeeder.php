<?php

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Populate the employees table with test data
     *
     * php artisan db:seed --class=EmployeesTableSeeder --force
     *
     * @return void
     */
    public function run()
    {
        factory(App\Employee::class, mt_rand(5000, 5100))->create();
    }
}
