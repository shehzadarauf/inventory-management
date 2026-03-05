<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function addCategory(Request $request){
        $category=Category::create($request->all());
        return Api::setResponse('category',$category);
    }

    public function updateCategory(Request $request){
        $previouscategory=Category::find($request->category_id);
        $previouscategory->update($request->all());
        $category=Category::find($request->category_id);
        return Api::setResponse('category',$category);
    }
    public function deleteCategory(Request $request){
        $category_products = Product::Where('category_id',$request->category_id)->get();
        $productExists = false;
         
        for($i=0; $i<count($category_products); $i++){
            $product = $category_products[$i];
            $product_id = $product['id'];
            $productExists = SaleItem::Where('product_id',$product_id)->exists();
            if($productExists){
                break;
            }
        }
        
      if($productExists){
             return Api::setError('Category can not be deleted as it contains Sales Order');
        } else{
             
        $category=Category::find($request->category_id);
        $category->delete();
        return Api::setMessage('Category Deleted');
        }
        
       
    }

    public function allCategories(Request $request){
        $categories=Category::all();
        return Api::setResponse('categories',$categories);
    }
}
