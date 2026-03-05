<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable=[
        'customer_id',
        'transport',
        'status',
        'details',
        'sale_no',
        'vehicle_no',
        'picture',
        'weighted'
    ];

    public function saleItems(){
        return $this->hasMany(SaleItem::class,'sale_id');
    }
    public function customerData(){
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function setPictureAttribute($value){
        $this->attributes['picture']=ImageHelper::saveImage($value,'uploads');
    }

    public function getPictureAttribute($value){
        return asset($value);
    }
   
}
