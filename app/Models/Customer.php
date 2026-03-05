<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Customer extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'name',
        'company_name',
        'email',
        'phone',
        'gst_no',
        'address',
        'type'
    ];


    public static function registerRules($type)
    {
        if($type=='nontax_payer'){
            return [
                'phone'=>'min:10|required',
            ];
        }else{
            return [
                'phone'=>'min:10|required',
                'gst_no'=>'min:15|max:15|required',
            ];
        }
       
    }

    protected $hidden = [
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

   

}
