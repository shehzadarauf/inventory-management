<?php

namespace App\Jobs;

use App\Helpers\SendNotification;
use App\Models\Inventory;
use App\Models\Notification;
use App\Models\NotificationProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckStock implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Log::info('Data sjdflkdsfkldsjfkd');
        // $user=User::find(1);
       
        $users = User::all();
        $test=false;
        $inventories=Inventory::where('qty','<','0')->get()->unique('product_id');
        Log::info($inventories);
        if(count($inventories)>0){
            $message='';
            $product1=new Product();
            $product2=new Product();
            $count=0;
            foreach ($inventories as $key => $inventoryy) {
                $count++;
                if($count==1){
                    $product1=Product::find($inventoryy->product_id);
                }
                if($count==2){
                    $product2=Product::find($inventoryy->product_id);
                }
              
            }
            if(count($inventories)==1){
                $message='Inventory of '.$product1->name.' is negative';
            }
            if(count($inventories)==2){
                $message='Inventory of '.$product1->name.' and of '.$product2->name.' is negative';
            }
            if(count($inventories)>2){
                $message='Inventory of '.$product1->name.' and of '.$product2->name.' and '.(count($inventories)-2).' other is negative';
            }
            // Log::info($message);
            $notification=Notification::create([
                'title'=>null,
                'message'=>$message
            ]);
            foreach ($inventories as $key => $inventory) {
                // if($inventory->qty<0){
                    $test=true;
                  
                    NotificationProduct::create([
                        'notification_id'=>$notification->id,
                        'product_id'=> $inventory->product_id
                    ]);
                   
                // }
                
            }
            if($test==true){
                foreach ($users as $key => $user) {
                    SendNotification::sendPushNotification($user, $notification->message);
                }
            }
    
        }
       
    }
}

