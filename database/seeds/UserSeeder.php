<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@elearning.com',
            'password' => bcrypt('abcd1234'),
            'user_type' => User::$ADMIN_USER
        ]);
    }
}
