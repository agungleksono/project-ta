<?php

namespace Database\Seeders;

use App\Models\Administrator;
use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    public function run()
    {
        Administrator::create(['id' => 1, 'name' => 'admin_1', 'address' => 'Semarang', 'phone' => '0853247342', 'user_id' => 1]);
    }
}
