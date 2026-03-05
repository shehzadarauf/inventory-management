<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{
    public function addProductSize(Request $request){
        $productSize=ProductSize::create($request->all());
        return Api::setResponse('size',$productSize);
    }

    
    public function deleteProductSize(Request $request){
        $productSize=ProductSize::find($request->size_id);
        $productSize->delete();
        return Api::setMessage('Product Size Deleted');
    }

    public function allProductSizes(Request $request){
        $allSizes=ProductSize::where('product_id',$request->product_id)->get();
        // orderBy('name', 'ASC')
        
        return Api::setResponse('sizes',$allSizes);
    }
}
