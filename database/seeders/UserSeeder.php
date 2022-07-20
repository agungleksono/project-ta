<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create(['id' => 1, 'username' => 'admin_1', 'email' => 'admin1@gmail.com', 'password' => 'admin_1', 'status' => 1]);
        User::create(['id' => 2, 'username' => 'customer_1', 'email' => 'customer1@gmail.com', 'password' => 'customer_1', 'status' => 2]);
        User::create(['id' => 3, 'username' => 'trainer_1', 'email' => 'trainer1@gmail.com', 'password' => 'trainer_1', 'status' => 3]);
    }
}
