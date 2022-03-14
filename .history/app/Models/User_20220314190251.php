<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Laravel\Passport\HasApiTokens;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, ModelTrait;

    protected $fillable = ['id', 'firstname','lastname','email ','phone', 'is_admin',];

    protected $hidden = [ 'password',  'remember_token',];

    protected $casts = ['email_verified_at' => 'datetime', ];


    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function usersearchs()
    {
        return $this->hasMany(UserSearch::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make(($value));
    }
}
