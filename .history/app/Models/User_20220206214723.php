<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Laravel\Passport\HasApiTokens;


//Ranim
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, ModelTrait;

    protected $fillable = [
        'id',
        'username',
        'phone',
        'lat',
        'lang',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make(($value));

    }

    public function rates()
    {
        return $this->hasMany(Rate::class, 'user_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function allInfo()
    {
        $users = $this->getData(['is_admin' => 0], ['orders.book']);
        return collect($users)->each(function ($user) {
            $user['book_count'] = collect($user['orders'])->sum('quantity');
            $user['total_price'] = collect($user['orders'])->sum(function ($order) {
                return $order['quantity'] * $order['book']['price'];
            });
        });
    }
}
