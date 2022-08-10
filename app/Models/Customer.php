<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function trainingRecord()
    {
        return $this->hasMany(TrainingRecord::class, 'customer_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }

    public function assignment()
    {
        return $this->hasMany(Assignment::class, 'customer_id', 'id');
    }

    public function customerDocument()
    {
        return $this->belongsTo(CustomerDocument::class, 'customer_id', 'id');
    }
}
