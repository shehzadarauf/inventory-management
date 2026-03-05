<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\ProductLength;
use Illuminate\Http\Request;

class ProductLengthController extends Controller
{
    public function addProductLength(Request $request){
        $productLength=ProductLength::create($request->all());
        return Api::setResponse('length',$productLength);
    }

    
    public function deleteProductLength(Request $request){
        $productLength=ProductLength::find($request->length_id);
        $productLength->delete();
        return Api::setMessage('Product Length Deleted');
    }

    public function allProductLengths(Request $request){
        $allLengths=ProductLength::where('product_id',$request->product_id)->get();
        return Api::setResponse('lengths',$allLengths);
    }
}
