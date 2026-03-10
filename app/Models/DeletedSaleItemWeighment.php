<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletedSaleItemWeighment extends Model
{
    use HasFactory;
    protected $fillable=[
        'deleted_sale_item_id',
        'primary_id',
        'primary_qty',
        'primaryCheck',
        'secondary_id',
        'secondary_qty',
        'secondaryCheck',
    ];
}
