<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    use HasFactory;
    protected $fillable=[
        'customer_id',
        'transport',
        'status',
        'details',
        'sale_return_no'
    ];

    public function saleReturnItems(){
        return $this->hasMany(SaleReturnItem::class,'sale_return_id');
    }

    public function customerData(){
        return $this->belongsTo(Customer::class,'customer_id');
    }

   
    
}
