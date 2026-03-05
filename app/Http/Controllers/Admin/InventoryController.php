<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryTransaction;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function addInventory(Request $request){
        $someArray = json_decode($request->data, true);
        for ($i = 0; $i < count($someArray); $i++) {
            $preinventory = Inventory::where('product_id', $someArray[$i]['product_id'])->where('size_id', $someArray[$i]['size_id'])->where('length_id', $someArray[$i]['length_id'])->first();
            if ($preinventory == null) {
                $inventory = Inventory::create([
                    'product_id' => $someArray[$i]['product_id'],
                    'size_id' => $someArray[$i]['size_id'],
                    'length_id' => $someArray[$i]['length_id'],
                    'qty' => $someArray[$i]['qty'],
                    'created_by' => Auth::user()->id
                ]);
                InventoryTransaction::create([
                    'inventory_id' => $inventory->id,
                    'product_id' => $someArray[$i]['product_id'],
                    'size_id' => $someArray[$i]['size_id'],
                    'length_id' => $someArray[$i]['length_id'],
                    'qty' => $someArray[$i]['qty'],
                    'created_by' => Auth::user()->id
                ]);
            } else {
                $preinventory->qty += $someArray[$i]['qty'];
                $preinventory->updated_by = Auth::user()->id;
                $preinventory->update();
                $preTransaction = InventoryTransaction::where('created_by', Auth::user()->id)->where('inventory_id', $preinventory->id)->where('product_id', $someArray[$i]['product_id'])->where('size_id', $someArray[$i]['size_id'])->where('length_id', $someArray[$i]['length_id'])->first();
                if ($preTransaction == null) {
                    InventoryTransaction::create([
                        'inventory_id' => $preinventory->id,
                        'product_id' => $someArray[$i]['product_id'],
                        'size_id' => $someArray[$i]['size_id'],
                        'length_id' => $someArray[$i]['length_id'],
                        'qty' => $someArray[$i]['qty'],
                        'created_by' => Auth::user()->id
                    ]);
                } else {
                    $preTransaction->qty += $someArray[$i]['qty'];
                    $preTransaction->updated_by = Auth::user()->id;
                    $preTransaction->update();
                }
            }
        }
        toastr()->success('Inventory added successfully');
        return redirect()->back();
    }



    
}
