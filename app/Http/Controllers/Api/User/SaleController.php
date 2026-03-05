<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Helpers\SendNotification;
use App\Http\Controllers\Controller;
use App\Jobs\CheckStock;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\ProductSize;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\WeighmentUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{

    public function allSales(Request $request){
        // if(Auth::user()->type=='Admin'){
            $sales=Sale::all();
            foreach ($sales as $key => $sale) {
                $sale->customerData;
            }
            return Api::setResponse('sales',$sales);
        // }else{
        //     $date = \Carbon\Carbon::today()->subDays(2)->endOfDay();
        //     $sales=[];
          
        //     while ($date <=now()) {
        //         $sals=Sale::whereDate('created_at', $date)->get();
        //         foreach ($sals as $key => $sale) {
        //             $sale->customerData;
        //             $sales[]=$sale;
        //         }
                
        //         $date= date('Y-m-d', strtotime('+1 day', strtotime($date)));
        //     }
        //     return Api::setResponse('sales',$sales);
        // }
      
      
    }

    public function saleByDate(Request $request){
      
            $sales = Sale::whereBetween('created_at',[
                $request->start." 00:00:00",$request->end." 23:59:59"
                ])->get(); 
                foreach ($sales as $key => $sale) {
                    $sale->customerData;
                }
        // $sales=Sale::whereBetween('created_at', [$request->date1, $request->date2])->get();
        return Api::setResponse('sales',$sales);
    }
    public function createSale(Request $request){
        $customer_id='';
        if($request->has('customer_id')){
            $customer_id=$request->customer_id;
        }else{
            $customer = Customer::create([
                'user_id'=>Auth::user()->id
            ]+$request->all());
            $customer_id=$customer->id;
        }
       $sale= Sale::create([
        'customer_id'=>$customer_id
       ]+$request->all());
       $sale->sale_no='SO'.$sale->id;
       if($request->has('date'))
        $sale->created_at=$request->date;
       $sale->update();
    //    $someJSON = '[{"product_id":"1","size_id":"1","length_id":"1","qty":"5"},{"product_id":"1","size_id":"1","length_id":"2","qty":"4"},{"product_id":"1","size_id":"2","length_id":"1","qty":"6"},{"product_id":"1","size_id":"2","length_id":"2","qty":"7"}]';

       $someArray = json_decode($request->data, true);       
       for ($i=0; $i <count($someArray) ; $i++) { 
           $preinventory=Inventory::where('product_id',$someArray[$i]['product_id'])->where('size_id',$someArray[$i]['size_id'])->where('length_id',$someArray[$i]['length_id'])->first();
           if($preinventory==null){
                $inventory= Inventory::create([
                    'product_id'=>$someArray[$i]['product_id'],
                    'size_id'=>$someArray[$i]['size_id'],
                    'length_id'=>$someArray[$i]['length_id'],
                    'punit_id'=>($someArray[$i]['punit_id']!=0?$someArray[$i]['punit_id']:null),
                    'sunit_id'=>($someArray[$i]['sunit_id']!=0?$someArray[$i]['sunit_id']:null),
                    'qty'=>(-$someArray[$i]['qty']),
                ]);
               $saleItem= SaleItem::create([
                   'sale_id'=>$sale->id,
                   'product_id'=>$someArray[$i]['product_id'],
                   'size_id'=>$someArray[$i]['size_id'],
                   'length_id'=>$someArray[$i]['length_id'],
                   'punit_id'=>($someArray[$i]['punit_id']!=0?$someArray[$i]['punit_id']:null),
                    'sunit_id'=>($someArray[$i]['sunit_id']!=0?$someArray[$i]['sunit_id']:null),
                   'qty'=>$someArray[$i]['qty'],
                   'price'=>$someArray[$i]['price'],
               ]);
           }else{
            $saleItem= SaleItem::create([
                'sale_id'=>$sale->id,
                'product_id'=>$someArray[$i]['product_id'],
                'size_id'=>$someArray[$i]['size_id'],
                'length_id'=>$someArray[$i]['length_id'],
                'punit_id'=>($someArray[$i]['punit_id']!=0?$someArray[$i]['punit_id']:null),
                'sunit_id'=>($someArray[$i]['sunit_id']!=0?$someArray[$i]['sunit_id']:null),
                'qty'=>$someArray[$i]['qty'],
                'price'=>$someArray[$i]['price'],
            ]);
                $preinventory->qty-=$someArray[$i]['qty'];
                $preinventory->update();  
           }
           
          
       }
       // $inventories=Inventory::where('product_id',$someArray[0]['product_id'])->get();
       return Api::setMessage('sale created successfully');
    }



    public function sendNotification(Request $request){
        SendNotification::sendPushNotification(Auth::user(),$request);

        // try{
        //     $receiver = User::find($request->receiver_id);

        //     SendNotification::sendPushNotification($receiver->firebase_token,$request);

        // }catch(Exception $e){
        //     // dd($e);
        // }
        return Api::setMessage('Successfully send');
    }



    public function viewSales(Request $request){
        
        $sales=Sale::whereDate('created_at', $request->date)->get();
        foreach ($sales as $key => $sale) {
            $sale->customerData;
        }
        return Api::setResponse('sales',$sales);
    }


     
    public function viewSaleDetail(Request $request){
        $sale=Sale::find($request->sale_id);
        $productData=[];
            $saleItems=$sale->saleItems->unique('product_id');
            foreach ($saleItems as $key => $saleitem) {
                $product=$saleitem->productData;
               
                // $product->sizes;
                $product->lengths;
                $product->category_name=Category::find($product->category_id)->name;
                $sizes=[];
               $sunit=WeighmentUnit::find($saleitem->sunit_id);
               $punit=WeighmentUnit::find($saleitem->punit_id);
                $product->sale_items=SaleItem::where('product_id',$product->id)->where('sale_id',$sale->id)->get();
                foreach ($product->sale_items as $key => $saleItem) {
                    $size=ProductSize::find($saleItem->size_id);
                   
                    $sizes[]=$size;

                }
                $product->sizes=$sizes;
               
                $product->punit=$punit;
                $product->sunit=$sunit;
                $productData[]=$product;
            }
        return Api::setResponse('productData',$productData);
    }


    public function updateSale(Request $request){
   
        $sale=Sale::find($request->sale_id);
        $sale->update($request->all());
        $someArray = json_decode($request->data, true);
      
        for ($i=0; $i <count($someArray); $i++) {

            $sale_item=SaleItem::find($someArray[$i]['id']);
            // $sale_item=SaleItem::where('product_id',$someArray[$i]['product_id'])->where('size_id',$someArray[$i]['size_id'])->where('length_id',$someArray[$i]['length_id'])->first();
            $preinventory=Inventory::where('product_id',$someArray[$i]['product_id'])->where('size_id',$someArray[$i]['size_id'])->where('length_id',$someArray[$i]['length_id'])->first();
            if($preinventory!=null){
             
                if($sale_item!=null){
                    $preinventory->qty+=$sale_item->qty;
                    $preinventory->qty-=$someArray[$i]['qty'];
                    $preinventory->update(); 
                    if($someArray[$i]['qty']==0){
                        $sale_item->delete();
                    }else{
                        $sale_item->qty=$someArray[$i]['qty'];
                    $sale_item->update();  
                    }
                  
                    
                }else{
                    $saleItem = SaleItem::create([
                        'sale_id'=>$someArray[$i]['sale_id'],
                        'product_id'=>$someArray[$i]['product_id'],
                        'size_id'=>$someArray[$i]['size_id'],
                        'length_id'=>$someArray[$i]['length_id'],
                        'punit_id'=>($someArray[$i]['punit_id']!=0?$someArray[$i]['punit_id']:null),
                        'sunit_id'=>($someArray[$i]['sunit_id']!=0?$someArray[$i]['sunit_id']:null),
                        'qty'=>$someArray[$i]['qty'],
                        'price'=>$someArray[$i]['price'],
                    ]);
           
                    $preinventory->qty-=$someArray[$i]['qty'];
                    $preinventory->update(); 
                }

                
            }else{
                if($sale_item!=null){
                    ////inventroy create //////////
                    $inventory= Inventory::create([
                        'product_id'=>$someArray[$i]['product_id'],
                        'size_id'=>$someArray[$i]['size_id'],
                        'length_id'=>$someArray[$i]['length_id'],
                        'qty'=>(-$someArray[$i]['qty']),
                    ]);


                    ////// sale update //////////
                    if($someArray[$i]['qty']==0){
                        $sale_item->delete();
                    }else{
                        $sale_item->qty=$someArray[$i]['qty'];
                        $sale_item->update();  
                    }
                    
                }else{
                    ////inventory create///////
                    $inventory= Inventory::create([
                        'product_id'=>$someArray[$i]['product_id'],
                        'size_id'=>$someArray[$i]['size_id'],
                        'length_id'=>$someArray[$i]['length_id'],
                        'qty'=>(-$someArray[$i]['qty']),
                    ]);


                    /////sale create///////
                    $saleItem= SaleItem::create([
                        'sale_id'=>$someArray[$i]['sale_id'],
                        'product_id'=>$someArray[$i]['product_id'],
                        'size_id'=>$someArray[$i]['size_id'],
                        'length_id'=>$someArray[$i]['length_id'],
                        'punit_id'=>($someArray[$i]['punit_id']!=0?$someArray[$i]['punit_id']:null),
                        'sunit_id'=>($someArray[$i]['sunit_id']!=0?$someArray[$i]['sunit_id']:null),
                        'qty'=>$someArray[$i]['qty'],
                        'price'=>$someArray[$i]['price'],
                    ]);
                }
            }
        
        }
        return Api::setMessage('sale updated');
    }

    public function deleteSale(Request $request){
        $sale=Sale::find($request->sale_id);
        $sale_items=$sale->saleItems;
        foreach ($sale_items as $key => $sale_item) {
            $preinventory=Inventory::where('product_id',$sale_item->product_id)->where('size_id',$sale_item->size_id)->where('length_id',$sale_item->length_id)->first();
            if($preinventory!=null){
                $preinventory->qty+=$sale_item->qty;
                $preinventory->update();
            }
        }
        $sale->delete();
        return Api::setMessage('Sale deleted successfully');

    }


    public function lastThirtyDaysSales(Request $request){
       
        $date = \Carbon\Carbon::today()->subDays(30)->endOfDay();
        $sales=[];
      
        while ($date <=now()) {
            $sals=Sale::whereDate('created_at', $date)->get()->count();
            $obj=new Api();
            $obj->sale_date=$date;
            $obj->sale_sum=$sals;
            $sales[]=$obj;
            $date= date('Y-m-d', strtotime('+1 day', strtotime($date)));
        }
        return Api::setResponse('sales',$sales);
    }
}
