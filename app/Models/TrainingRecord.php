<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingRecord extends Model
{
    use HasFactory;

    protected $fillable = ['trainer_id', 'customer_id', 'training_id'];
    protected $hidden = ['created_at', 'updated_at'];
    // protected $appends = ['training'];

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id', 'id');
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    // public function getTrainingAttribute()
    // {
    //     $training = $this->belongsTo(Training::class, 'training_id', 'id')->getResults();
    //     return [
    //         'id' => $training->id,
    //         'training_name' => $training->training_name,
    //     ];
    // }
}
