<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function addInventory(Request $request)
    {
        // $someJSON = '[{"product_id":"1","size_id":"1","length_id":"1","qty":"5"},{"product_id":"1","size_id":"1","length_id":"2","qty":"4"},{"product_id":"1","size_id":"2","length_id":"1","qty":"6"},{"product_id":"1","size_id":"2","length_id":"2","qty":"7"}]';

        $someArray = json_decode($request->data, true);

        for ($i = 0; $i < count($someArray); $i++) {
            $preinventory = Inventory::where('product_id', $someArray[$i]['product_id'])->where('size_id', $someArray[$i]['size_id'])->where('length_id', $someArray[$i]['length_id'])->first();
            if ($preinventory == null) {
                $inventory = Inventory::create([
                    'product_id' => $someArray[$i]['product_id'],
                    'size_id' => $someArray[$i]['size_id'],
                    'length_id' => $someArray[$i]['length_id'],
                    'qty' => $someArray[$i]['qty'],
                    'created_by' => Auth::user()->id,
                    
                ]);
                InventoryTransaction::create([
                    'inventory_id' => $inventory->id,
                    'product_id' => $someArray[$i]['product_id'],
                    'size_id' => $someArray[$i]['size_id'],
                    'length_id' => $someArray[$i]['length_id'],
                    'qty' => $someArray[$i]['qty'],
                    'created_by' => Auth::user()->id,
                    'time'=>$request->time
                ]);
            } else {
                $preinventory->qty += $someArray[$i]['qty'];
                $preinventory->updated_by = Auth::user()->id;
                $preinventory->update();
                // $preTransaction = InventoryTransaction::where('created_by', Auth::user()->id)->where('inventory_id', $preinventory->id)->where('product_id', $someArray[$i]['product_id'])->where('size_id', $someArray[$i]['size_id'])->where('length_id', $someArray[$i]['length_id'])->first();
                // if ($preTransaction == null) {
                    InventoryTransaction::create([
                        'inventory_id' => $preinventory->id,
                        'product_id' => $someArray[$i]['product_id'],
                        'size_id' => $someArray[$i]['size_id'],
                        'length_id' => $someArray[$i]['length_id'],
                        'qty' => $someArray[$i]['qty'],
                        'created_by' => Auth::user()->id,
                        'time'=>$request->time
                    ]);
                // } else {
                //     $preTransaction->qty += $someArray[$i]['qty'];
                //     $preTransaction->updated_by = Auth::user()->id;
                //     $preTransaction->update();
                // }
            }
        }
        return Api::setMessage('inventory added successfully');
    }

    public function viewInventory(Request $request)
    {
        $product = Product::find($request->product_id);
        $category = Category::find($product->category_id);
        $product->category_name = $category->name;
        $product->inventory;
        $product->sizes;
        $product->lengths;
        return Api::setResponse('productData', $product);
    }



    ////////////// this function is to get loadTime objects /////////


    /////////////// This function is to get inventory transactions by date/////
    public function inventoryByDate(Request $request)
    {
        $loads = InventoryTransaction::where('created_by', Auth::user()->id)->whereDate('created_at', $request->date)->get()->unique('time');
        $loadTimes=[];
        // $productData = [];
        foreach ($loads as $key => $load) {
            $loadTimes[] = $load;
           
        }

        return Api::setResponse('loadTimes', $loadTimes);
      
    }


    public function inventoryByLoads(Request $request)
    {
        $inventories = InventoryTransaction::where('time', $request->time)->get()->unique('product_id');
        $productData = [];
        foreach ($inventories as $key => $inventory) {
            $product = $inventory->productData;
            // $product->sizes;
            $product->lengths;
            $sizes=[];
            $product->inventories = InventoryTransaction::where('created_by', Auth::user()->id)->where('time', $request->time)->where('product_id', $product->id)->get();
            foreach ($product->inventories->unique('size_id') as $key => $inventoryItem) {
                $size=ProductSize::find($inventoryItem->size_id);
                $sizes[]=$size;
            }
            $product->sizes=$sizes;
            $productData[] = $product;
        }
        return Api::setResponse('productData', $productData);
    }




    public function updateInventory(Request $request)
    {

        $someArray = json_decode($request->data, true);
        for ($i = 0; $i < count($someArray); $i++) {

            $preTransaction = InventoryTransaction::find($someArray[$i]['id']);
   
            // $preTransaction = InventoryTransaction::where('product_id', $someArray[$i]['product_id'])->where('size_id', $someArray[$i]['size_id'])->where('length_id', $someArray[$i]['length_id'])->first();

            $preinventory = Inventory::where('product_id', $someArray[$i]['product_id'])->where('size_id', $someArray[$i]['size_id'])->where('length_id', $someArray[$i]['length_id'])->first();
            if ($preinventory != null) {
                if ($preTransaction != null) {
                    
                    ///////////// inventory update ///////////
                    $preinventory->qty =  $preinventory->qty-$preTransaction->qty;
                    $preinventory->qty = $preinventory->qty+$someArray[$i]['qty'];
                    $preinventory->updated_by = Auth::user()->id;
                    $preinventory->update();
                    ////////// inventory transaction update ////////
                    $preTransaction->qty = $someArray[$i]['qty'];
                    $preTransaction->updated_by = Auth::user()->id;
                    $preTransaction->created_at=$request->date;
                    $preTransaction->updated_at=$request->date;
                    $preTransaction->update();
                } else {
                    $inv=InventoryTransaction::create([
                        'inventory_id' => $preinventory->id,
                        'product_id' => $someArray[$i]['product_id'],
                        'size_id' => $someArray[$i]['size_id'],
                        'length_id' => $someArray[$i]['length_id'],
                        'qty' => $someArray[$i]['qty'],
                        'created_by' => Auth::user()->id,
                    ]);
                    $inv->created_at= $request->date;
                    $inv->updated_at= $request->date;
                    $inv->time=$request->time;
                    $inv->update();
                    $preinventory->qty += $someArray[$i]['qty'];
                    $preinventory->update();
                }
            } else {
                // if ($preTransaction != null) {
                //     ////inventroy transaction update //////////
                //     $preinventory->qty -= $preTransaction->qty;
                //     $preinventory->qty += $someArray[$i]['qty'];
                //     $preinventory->updated_by = Auth::user()->id;
                //     $preinventory->update();
                //     ////////// Inventory update
                //     $preTransaction->qty = $someArray[$i]['qty'];
                //     $preTransaction->updated_by = Auth::user()->id;
                //     $preTransaction->created_at=$request->date;
                //     $preTransaction->updated_at=$request->date;
                //     $preTransaction->update();
                // } else {
                    $inventory = Inventory::create([
                        'product_id' => $someArray[$i]['product_id'],
                        'size_id' => $someArray[$i]['size_id'],
                        'length_id' => $someArray[$i]['length_id'],
                        'qty' => $someArray[$i]['qty'],
                        'created_by' => Auth::user()->id
                    ]);
                    $inventory->created_at=$request->date;
                    $inventory->updated_at=$request->date;
                    $inventory->update();
                    $inv=InventoryTransaction::create([
                        'inventory_id' => $inventory->id,
                        'product_id' => $someArray[$i]['product_id'],
                        'size_id' => $someArray[$i]['size_id'],
                        'length_id' => $someArray[$i]['length_id'],
                        'qty' => $someArray[$i]['qty'],
                        'created_by' => Auth::user()->id,
                    ]);
                    $inv->created_at= $request->date;
                    $inv->updated_at= $request->date;
                    $inv->time=$request->time;
                    $inv->update();
                // }
            }
        }
        return Api::setMessage('Updated Successfully');
    }



    public function thirtyDaysInventory(Request $request){
        $date = \Carbon\Carbon::today()->subDays(30)->endOfDay();
        $inventories=[];
        
      
        while ($date <=now()) {
            $inventoryCount=InventoryTransaction::whereDate('created_at', $date)->get()->count();
            $obj=new Api();
            $obj->inventory_add_date=$date;
            $obj->inventory_sum=$inventoryCount;
            $inventories[]=$obj;
            
            $date= date('Y-m-d', strtotime('+1 day', strtotime($date)));
        }
        return Api::setResponse('inventories',$inventories);
    }




    // //////////////// This function is used to get whole inventory by timestap /////////////
    // public function getInventoryByTimestamp(Request $request)
    // {
    //     $product = Product::find($request->product_id);
    //     $product->lengths;
    //     $product->sizes;
    //     $inventories = Inventory::whereDate('updated_at', $request->date)->where('product_id', $request->product_id)->get();
    //     $product->inventory = $inventories;
    //     if (count($inventories) > 0) {
    //         return Api::setResponse('product', $product);
    //     } else {
    //         return Api::setMessage('No record found');
    //     }
    // }

    public function deleteLoads(Request $request){
     
        $inventoryTransactions = InventoryTransaction::where('time', $request->time)->get();
        if(count($inventoryTransactions)>0){
            foreach ($inventoryTransactions as $key => $transaction) {
                $inventory=Inventory::find($transaction->inventory_id);
                $inventory->qty-=$transaction->qty;
                $inventory->update();
                $transaction->delete();
            }
            return Api::setMessage('inentory deleted');
        }else{
            return Api::setError('no inventory found');
        }
      
        
    }
}
