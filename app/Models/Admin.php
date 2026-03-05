<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $fillable=[
        'name',
        'email',
        'password',
        'type',
        'api_token'
    ];

    public function setPasswordAttribute($value){
        $this->attributes['password'] = Hash::make($value);
    }

    public static function loginRules()
    {
        return [
            'email'=>'email|required',
            'password' => 'required',
            
        ];
    }

    public function withToken(){
        return $this->makeVisible(['api_token']);
    }

}
