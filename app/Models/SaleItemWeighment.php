<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItemWeighment extends Model
{
    use HasFactory;
    protected $fillable=[
        'sale_item_id',
        'primary_id',
        'primary_qty',
        'primaryCheck',
        'secondary_id',
        'secondary_qty',
        'secondaryCheck',
    ];
    
}
