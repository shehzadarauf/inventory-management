<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeighmentUnit extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'product_id',
        'type',
        'isDefault'
    ];
}
