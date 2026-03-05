<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin=User::create([
            'name'=>'Admin',
            'email'=>'admin@mail.com',
            'password'=>'1234',
            'api_token' => 'bni88iRLwG02MDSSkkVhTYDaEYwLnaQwi57AMLO9xyXKPZ9bJEkU6OTFWbpN',
            'type'=>'Admin'
        ]);
        for ($i=1; $i <=25 ; $i++) { 
           Customer::create([
               'user_id'=>$admin->id,
               'name'=>'Customer'.$i,
               'company_name'=>'Company'.$i,
               'email'=>'customer'.$i.'@mail.com',
               'phone'=>'03424456789',
               'gst_no'=>'1234'.$i,
               'address'=>'Lahore City',
           ]);
        }
       $sale_manager= User::create([
            'name'=>'Aslam',
            'email'=>'aslam@mail.com',
            'password'=>'1234',
            'phone'=>'03421152643',
            'api_token' => 'Hmk9X7BZQ9UzAUDkgelhfAS1TLL2RDf9qDRnJ87Er9rtF7mVQJpg3Iy3DQA3',
            'type'=>'Sales Manager'
        ]);
        for ($i=26; $i <=50 ; $i++) { 
            Customer::create([
                'user_id'=>$sale_manager->id,
                'name'=>'Customer'.$i,
                'company_name'=>'Company'.$i,
                'email'=>'customer'.$i.'@mail.com',
                'phone'=>'03424456789',
                'gst_no'=>'1234'.$i,
                'address'=>'Sargodha city',
            ]);
         }
       $store_manager= User::create([
            'name'=>'Ali',
            'email'=>'ali@mail.com',
            'password'=>'1234',
            'phone'=>'03421152643',
            'api_token' => 'K3GUD3vAvzEwqw0WnVm0Es8OLy07Lt8d2XNx6twQYYAVzmHhysGwRNZXpdz7',
            'type'=>'Store Manager'
        ]);
    }
}
