<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'phone',
        'api_token',
        'firebase_token',
        'isLogin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function registerRules()
    {
        return [
            'name'=>'max:255|required',
            'email'=>'email|required|unique:users',
            'password' => 'min:4|required',
        ];
    }

    public static function loginRules()
    {
        return [
            'email'=>'email|required',
            'password' => 'required',
            
        ];
    }

    public function setPasswordAttribute($value){
        if(!empty($value))
         $this->attributes['password'] = Hash::make($value);
    }

    
    public function withToken(){
        return $this->makeVisible(['api_token']);
    }
}
