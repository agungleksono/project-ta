<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create(['id' => 1, 'username' => 'admin_1', 'password' => 'admin_1', 'status' => 1]);
        User::create(['id' => 2, 'username' => 'customer_1', 'password' => 'customer_1', 'status' => 2]);
        User::create(['id' => 3, 'username' => 'trainer_1', 'password' => 'trainer_1', 'status' => 3]);
    }
}
