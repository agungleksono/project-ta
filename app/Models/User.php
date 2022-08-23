<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'api_token',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'user_id', 'id');
    }

    public function trainer()
    {
        return $this->hasOne(Trainer::class, 'user_id', 'id');
    }

    public function administrator()
    {
        return $this->hasOne(Administrator::class, 'user_id', 'id');
    }

    public function getCustomerAttribute()
    {
        $customer = $this->hasOne(Customer::class, 'user_id', 'id')->getResults();
        return [
            'name' => $customer->name,
            'address' => $customer->address,
            'phone' => $customer->phone,
            'photo' => $customer->photo,
        ];
    }

    public function getTrainerAttribute()
    {
        $trainer = $this->hasOne(Trainer::class, 'user_id', 'id')->getResults();
        return [
            'name' => $trainer->name,
            'address' => $trainer->address,
            'phone' => $trainer->phone,
            'photo' => $trainer->photo,
            'cv' => $trainer->cv,
        ];
    }

    public function getAdministratorAttribute()
    {
        $administrator = $this->hasOne(Administrator::class, 'user_id', 'id')->getResults();
        return [
            'name' => $administrator->name,
            'address' => $administrator->address,
            'phone' => $administrator->phone,
        ];
    }
}
