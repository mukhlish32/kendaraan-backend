<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'mukhlish',
            'email' => 'mukhlish.syarif@gmail.com',
            'password' => bcrypt('admin'), // password
        ]);
    }
}
