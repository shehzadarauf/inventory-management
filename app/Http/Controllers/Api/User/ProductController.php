<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\WeighmentUnit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function addProduct(Request $request){
        $product=Product::create($request->all());
        return Api::setResponse('product',$product);
    }
    
    public function updateProduct(Request $request){
        $previousProduct=Product::find($request->product_id);
        $previousProduct->update($request->all());
        $product=Product::find($request->product_id);
        return Api::setResponse('product',$product);
    }
    
    public function deleteProduct(Request $request){
        $result = SaleItem::where("product_id", $request->product_id)->exists();
        
        if($result){
        return Api::setError('Product can not be deleted as it contains Sales');
        } else{
             $product=Product::find($request->product_id);
        $product->delete();
        return Api::setMessage('Product Deleted');
        }
        
       
    }

    public function allProducts(Request $request){
        $products=Product::all();
        $productss=[];
        foreach ($products as $key => $product) {
            $category=Category::find($product->category_id);
            $product->category_name=$category->name;
            $productss[]=$product;
            
        }
        return Api::setResponse('products',$productss);
    }

    public function getCategotryProducts(Request $request){
        $categories=Category::all();
        foreach ($categories as $key => $category) {
            $category->products;
        }
        return Api::setResponse('categories',$categories);
    }

    public function getSizeLength(Request $request){
        $product=Product::find($request->product_id);
        $category=Category::find($product->category_id);
        $product->category_name=$category->name;
        $product->sizes;
        $product->lengths;
        return Api::setResponse('productData',$product);
    } 
    public function getSizeLengthWeighment(Request $request){
        $product=Product::find($request->product_id);
        $category=Category::find($product->category_id);
        $product->category_name=$category->name;
        $product->sizes;
        $product->lengths;
        $product->primaryUnits=WeighmentUnit::where('product_id',$product->id)->where('type','primary')->get();
        $product->secondaryUnits=WeighmentUnit::where('product_id',$product->id)->where('type','secondary')->get();
        return Api::setResponse('productData',$product);
    }
}
