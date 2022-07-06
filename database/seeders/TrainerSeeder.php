<?php

namespace Database\Seeders;

use App\Models\Trainer;
use Illuminate\Database\Seeder;

class TrainerSeeder extends Seeder
{
    public function run()
    {
        Trainer::create(['id' => 1, 'name' => 'trainer_1', 'address' => 'Semarang', 'phone' => '0823534632', 'user_id' => 3]);
    }
}
