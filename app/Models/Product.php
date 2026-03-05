<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'category_id'
    ];

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function sizes(){
        return $this->hasMany(ProductSize::class);
    }

    public function lengths(){
        return $this->hasMany(ProductLength::class);
    }
    public function weighments(){
        return $this->hasMany(WeighmentUnit::class);
    }

    public function inventory(){
        return $this->hasMany(Inventory::class,'product_id');
    }
}
