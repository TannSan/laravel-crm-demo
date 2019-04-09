<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Populate the users table with test data
     *
     * php artisan db:seed --class=UsersTableSeeder --force
     *
     * @return void
     */
    public function run()
    {
        // Create static admin user
        if (!App\User::where('email', 'admin@admin.com')->exists()) {
            factory(App\User::class)->create(['name' => 'Administrator', 'email' => 'admin@admin.com']);
        }
    }
}
