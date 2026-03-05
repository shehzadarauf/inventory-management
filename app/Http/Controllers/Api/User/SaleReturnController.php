<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SaleReturn;
use App\Models\SaleReturnItem;
use App\Models\Inventory;
use App\Helpers\Api;
use App\Models\ProductSize;
use Illuminate\Support\Facades\Auth;

class SaleReturnController extends Controller
{
    ////////////////// Function for sale return /////////////
    public function returnSale(Request $request){
        $sale_return= SaleReturn::create($request->all());
        $sale_return->sale_return_no='SRO'.$sale_return->id;
        $sale_return->update();

        $someArray = json_decode($request->data, true);
        for ($i=0; $i <count($someArray); $i++) {
            $preinventory=Inventory::where('product_id',$someArray[$i]['product_id'])->where('size_id',$someArray[$i]['size_id'])->where('length_id',$someArray[$i]['length_id'])->first();
            if($preinventory!=null){
                $sale_returnn = SaleReturnItem::create([
                    'sale_return_id'=>$sale_return->id,
                    'product_id'=>$someArray[$i]['product_id'],
                    'size_id'=>$someArray[$i]['size_id'],
                    'length_id'=>$someArray[$i]['length_id'],
                    'qty'=>$someArray[$i]['qty'],
                ]);
                $sale_returnn->created_by=Auth::user()->id;
                $sale_returnn->update();
                $preinventory->qty+=$someArray[$i]['qty'];
                $preinventory->update();
            }else{
                $inventory= Inventory::create([
                    'product_id'=>$someArray[$i]['product_id'],
                    'size_id'=>$someArray[$i]['size_id'],
                    'length_id'=>$someArray[$i]['length_id'],
                    'qty'=>$someArray[$i]['qty'],
                ]);
            }
            
        }

        return Api::setMessage('sale return created');
    }


    public function viewSaleReturns(Request $request){
        $returns=SaleReturn::whereDate('created_at', $request->date)->get();
        foreach ($returns as $key => $return) {
            $return->customerData;
        }
        return Api::setResponse('sales',$returns);
    }

    public function viewSaleReturnDetail(Request $request){
        $sale_return=SaleReturn::find($request->sale_return_id);
        $productData=[];
            $saleReturnItems=$sale_return->saleReturnItems->unique('product_id');
            foreach ($saleReturnItems as $key => $saleReturnItem) {
                $product=$saleReturnItem->productData;
                // $product->sizes;
                $product->lengths;
                $sizes=[];
                $product->sale_items=SaleReturnItem::where('product_id',$product->id)->where('sale_return_id',$sale_return->id)->get();
                foreach ($product->sale_items as $key => $saleItem) {
                    $size=ProductSize::find($saleItem->size_id);
                    $sizes[]=$size;
                }
                $product->sizes=$sizes;
                $productData[]=$product;
            }
        return Api::setResponse('productData',$productData);
    }

    public function allSalesReturns(Request $request){
        $returns=SaleReturn::all();
        foreach ($returns as $key => $return) {
            $return->customerData;
        }
        return Api::setResponse('sales',$returns);
    }
}
