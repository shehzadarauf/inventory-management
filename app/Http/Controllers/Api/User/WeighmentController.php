<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductSize;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SaleItemWeighment;
use App\Models\WeighmentUnit;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class WeighmentController extends Controller
{
    public function store(Request $request){
        $sale=Sale::find($request->sale_id);
        
        if($sale!=null){
            $sale->update([
                'weighted'=>true
            ]+$request->all());
        }
        $someArray = json_decode($request->data, true);       
        for ($i=0; $i <count($someArray) ; $i++) {
            SaleItemWeighment::create([
                'sale_item_id'=>$someArray[$i]['sale_item_id'],
                'primary_id'=>$someArray[$i]['primary_id']??null,
                'primary_qty'=>$someArray[$i]['primary_qty']??null,
                'secondary_id'=>$someArray[$i]['secondary_id']??null,
                'secondary_qty'=>$someArray[$i]['secondary_qty']??null,
                'primaryCheck'=>$someArray[$i]['primaryCheck']??null,
                'secondaryCheck'=>$someArray[$i]['secondaryCheck']??null
            ]);
        }
        
        return Api::setMessage('Weighment added successfully');
    }

    public function viewWeighment(Request $request){
        $sale=Sale::find($request->sale_id);
        $productData=[];
            $saleItems=$sale->saleItems->unique('product_id');

            foreach ($saleItems as $key => $saleitem) {
                $product=$saleitem->productData;
               
                // $product->sizes;
                $product->lengths;
                $category=Category::find($product->category_id);
                $product->category_name=$category->name;
                $sizes=[];
               $sunit=WeighmentUnit::find($saleitem->sunit_id);
               $punit=WeighmentUnit::find($saleitem->punit_id);
              
                $product->sale_items=SaleItem::where('product_id',$product->id)->where('sale_id',$sale->id)->get();
                foreach ($product->sale_items as $key => $saleItem) { 
                    $size=ProductSize::find($saleItem->size_id);
                    $saleItem->pweighments=SaleItemWeighment::where('primary_id','!=',null)->where('sale_item_id',$saleItem->id)->get(['id','sale_item_id','primary_id','primary_qty','primaryCheck']);
                    $saleItem->sweighments=SaleItemWeighment::where('secondary_id','!=',null)->where('sale_item_id',$saleItem->id)->get(['id','sale_item_id','secondary_id','secondary_qty','secondaryCheck']);
                    $sizes[]=$size;

                }
                $product->sizes=$sizes;
               
                $product->punit=$punit;
                $product->sunit=$sunit;
                // $product->pweighment=$pweighment;`
                // $product->sweighment=$sweighment;
                $productData[]=$product;
            }
        return Api::setResponse('productData',$productData);
    }

    public function updateWeighment(Request $request){
        $sale=Sale::find($request->sale_id);
        if($sale!=null){
            $sale->update([
                'weighted'=>true
            ]+$request->all());
        }
        $someArray = json_decode($request->data, true);       
        for ($i=0; $i <count($someArray) ; $i++) {
            $weighmentPreviousData=SaleItemWeighment::where('id',$someArray[$i]['id']??'0')->first();
            if($weighmentPreviousData!=null){
                if(isset($someArray[$i]['isDeleted'])){
                    $weighmentPreviousData->delete();
                }else{
                    $sale_item_data=SaleItem::find($someArray[$i]['sale_item_id']);
                    $sale_item_data->updated_at=$sale_item_data->created_at;
                    $sale_item_data->update();
                    $weighmentPreviousData->update([
                    $weighmentPreviousData->sale_item_id=$someArray[$i]['sale_item_id'],
                    $weighmentPreviousData->primary_id=$someArray[$i]['primary_id']??null,
                    $weighmentPreviousData->primary_qty=$someArray[$i]['primary_qty']??null,
                    $weighmentPreviousData->secondary_id=$someArray[$i]['secondary_id']??null,
                    $weighmentPreviousData->secondary_qty=$someArray[$i]['secondary_qty']??null,
                    $weighmentPreviousData->primaryCheck=$someArray[$i]['primaryCheck']??null,
                    $weighmentPreviousData->secondaryCheck=$someArray[$i]['secondaryCheck']??null
                  ]);
                }
               
            }else{
                SaleItemWeighment::create([
                    'sale_item_id'=>$someArray[$i]['sale_item_id'],
                    'primary_id'=>$someArray[$i]['primary_id']??null,
                    'primary_qty'=>$someArray[$i]['primary_qty']??null,
                    'secondary_id'=>$someArray[$i]['secondary_id']??null,
                    'secondary_qty'=>$someArray[$i]['secondary_qty']??null,
                    'primaryCheck'=>$someArray[$i]['primaryCheck']??null,
                    'secondaryCheck'=>$someArray[$i]['secondaryCheck']??null
                ]);
            }
            
        }
        
        return Api::setMessage('Weighment updated successfully');
    }


}
