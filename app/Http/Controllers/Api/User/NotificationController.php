<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Notification;
use App\Models\NotificationProduct;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function viewNotifications(Request $request){
        $notifications=Notification::orderBy('created_at', 'desc')->get();
        foreach ($notifications as $key => $notification) {
            $notificationProducts=NotificationProduct::where('notification_id',$notification->id)->get();
            $products=[];
            foreach ($notificationProducts as $key => $product) {
                $products[]=$product->product;
              
            }
            foreach ($products as $key => $product) {
                $product->category_name= Category::where('id',$product->category_id)->first()->name;
            }
            $notification->products=$products;
        }
        return Api::setResponse('notifications',$notifications);
    }

    public function notificationDetail(Request $request){
        $notification=Notification::find($request->notification_id);
       
        $productData = [];
        foreach ($notification->notificationProducts as $key => $notificationProduct) {
            $product = $notificationProduct->product;
            $sizes=[];
            $product->lengths;
            $inventories = Inventory::where('product_id',$notificationProduct->product_id)->where('qty','<','0')->get();
            if(count($inventories)>0){
                $product->inventories=$inventories;
                foreach ($inventories as $key => $inventory) {

                    $size=ProductSize::find($inventory->size_id);
                    $sizes[]=$size;
                }
                $product->sizes=$sizes;
                $productData[] = $product;
            }
        }
        return Api::setResponse('productData', $productData);
    }
}
