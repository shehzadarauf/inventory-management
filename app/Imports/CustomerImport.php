<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
HeadingRowFormatter::default('none');
class CustomerImport implements ToModel,WithHeadingRow
{

    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        $customer= new Customer([
            'user_id' => Auth::user()->id,
            'name' =>trim($row['name']),
            'company_name' =>ucwords(trim($row['company_name'])),
            'email' => trim($row['email']),
            'address' => trim($row['address']),
            'phone' => trim($row['phone']),
            'gst_no' => trim($row['gst_no']),
        ]);
        $pcustomer=Customer::where('company_name',ucfirst($customer->company_name))->first();
        if($pcustomer==null){
        return $customer;
        }
    }
}
