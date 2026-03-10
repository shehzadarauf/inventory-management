<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletedSaleItem extends Model
{
    use HasFactory;
    protected $fillable=[
        'deleted_sale_id',
        'product_id',
        'size_id',
        'length_id',
        'punit_id',
        'sunit_id',
        'qty',
        'weight',
        'price',
        'created_by',
        'deleted_by'
    ];
    
     public function productData(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function sizeData(){
        return $this->belongsTo(ProductSize::class,'size_id');
    }
}
