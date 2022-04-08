<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Kouja\ProjectAssistant\Traits\ModelTrait;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, ModelTrait;

    protected $fillable = ['id', 'firstname','lastname','email','phone', 'is_admin','password'];

    protected $hidden = [ 'remember_token',];

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
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function userstores()
    {
        return $this->hasMany(UserStore::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make(($value));
    }


    public function userProfile(){
        return  $this->select('id','firstname','lastname','email','phone','created_at as date of join')
             ->where('id',auth()->user()->id)
             ->get();
    }
    public function editUserProfile($request){
        return $this->where('id',auth()->user()->id)->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
    }

    public function editPassword($request){
        return $this->where('id',auth()->user()->id)->update([
            'password' => Hash::make($request->newPassword),
        ]);
    }

}

