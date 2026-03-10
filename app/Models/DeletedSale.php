<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ImageHelper;

class DeletedSale extends Model
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
        'weighted',
        'created_by',
        'deleted_by'
    ];
    
    public function saleItems(){

        return $this->hasMany(DeletedSaleItem::class,'deleted_sale_id');
    }
    public function customerData(){
        
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function deletedByUserData(){
        return $this->belongsTo(User::class,'deleted_by');
    }

    // public function setPictureAttribute($value){
    //     $this->attributes['picture']=ImageHelper::saveImage($value,'uploads');
    // }

    public function getPictureAttribute($value){
        return asset($value);
    }
}
