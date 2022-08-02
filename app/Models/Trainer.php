<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    public function training()
    {
        return $this->hasMany(Training::class, 'trainer_id', 'id');
    }

    public function trainingRecord()
    {
        return $this->hasMany(TrainingRecord::class, 'trainer_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }
}
