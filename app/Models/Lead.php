<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
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
        'enquiery'
    ];
}
