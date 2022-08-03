<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }

    public function vacancy()
    {
        return $this->hasMany(Vacancy::class, 'admin_id', 'id');
    }
}
