<?php

namespace Database\Seeders;

use App\Models\Training;
use Illuminate\Database\Seeder;

class TrainingSeeder extends Seeder
{
    public function run()
    {
        Training::create([
            'id' => 1,
            'training_name' => 'Ahli K3 Umum',
            'training_desc' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime iste cumque vitae. Labore dolore aperiam sunt facere amet quis rerum nemo sapiente laborum voluptatum? Distinctio.',
            'training_price' => 1500000,
            'training_start' => '2022-07-15',
            'training_end' => '2022-07-19',
            'trainer_id' => 1
        ]);
        Training::create([
            'id' => 2,
            'training_name' => 'K3 Migas BNSP',
            'training_desc' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime iste cumque vitae. Labore dolore aperiam sunt facere amet quis rerum nemo sapiente laborum voluptatum? Distinctio.',
            'training_price' => 2300000,
            'training_start' => '2022-07-15',
            'training_end' => '2022-07-19',
            'trainer_id' => 1
        ]);
    }
}
