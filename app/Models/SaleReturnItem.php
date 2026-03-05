<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturnItem extends Model
{
    use HasFactory;
    protected $fillable=[
        'sale_return_id',
        'product_id',
        'size_id',
        'length_id',
        'qty',
        'created_by',
    ];

    public function productData(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
