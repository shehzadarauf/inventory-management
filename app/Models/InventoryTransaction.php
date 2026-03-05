<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;
    protected $fillable=[
        'inventory_id',
        'product_id',
        'size_id',
        'length_id',
        'qty',
        'created_by',
        'updated_by',
        'time'
    ];

    public function productData(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
