<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function getProduct(Request $request)
    {
        $product = Product::find($request->id);
        $product->sizes;
        $product->lengths;
        return response()->json($product);
    }

    public function getProductsByCategory(Request $request)
    {
        $products = Category::find($request->id)->products;
        return response()->json($products);
    }
    public function prodcutInventories(Request $request){
        $product = Product::find($request->id);
        $category = Category::find($product->category_id);
        $product->category_name = $category->name;
        $product->inventory;
        $product->sizes;
        $product->lengths;
        return response()->json($product);
    }

    public function inventoryByDate(Request $request)
    {
        $inventories = InventoryTransaction::where('created_by', Auth::user()->id)->whereDate('updated_at', $request->date)->get()->unique('product_id');
        $productData = [];
        foreach ($inventories as $key => $inventory) {
            $product = $inventory->productData;
            // $product->sizes;
            $product->lengths;
            $sizes=[];
            $product->inventories = InventoryTransaction::where('created_by', Auth::user()->id)->whereDate('updated_at', $request->date)->where('product_id', $product->id)->get();
            // foreach ($product->inventories->unique('size_id') as $key => $inventoryItem) {
            //     $size=ProductSize::find($inventoryItem->size_id);
            //     $sizes[]=$size;
            // }
            $product->sizes;
            $productData[] = $product;
        }
       return response()->json($productData);
    }
}
