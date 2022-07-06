<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        Customer::create(['id' => 1, 'name' => 'customer_1', 'address' => 'Semarang', 'phone' => '0892324523', 'user_id' => 2]);
    }
}
