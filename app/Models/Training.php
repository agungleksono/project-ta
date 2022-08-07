<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $table = 'trainings';
    protected $guarded = ['id'];
    protected $appends = ['trainer'];
    protected $hidden = ['created_at', 'updated_at'];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id', 'id');
    }

    public function trainingRecord()
    {
        return $this->hasMany(TrainingRecord::class, 'training_id', 'id');
    }

    public function getTrainerAttribute()
    {
        $trainer = $this->belongsTo(Trainer::class, 'trainer_id', 'id')->getResults();
        return [
            'id' => $trainer->id,
            'name' => $trainer->name,
        ];
    }
}
