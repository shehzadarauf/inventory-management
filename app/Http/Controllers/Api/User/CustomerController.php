<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Helpers\ApiValidate;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function addCustomer(Request $request){
        $customer=Customer::where('company_name',ucwords($request->company_name))->first();
     if($customer!=null){
        return Api::setError('a customer with this nane already exist');
     }else{
        $customer = Customer::create([
            'user_id'=>Auth::user()->id,
            'company_name'=>ucwords($request->company_name)
        ]+$request->all());
        return Api::setResponse('customer', $customer);
     }
      
    }

    public function getCustomers(Request $request){
        $customers=Customer::where('type',null)->get();
        return Api::setResponse('customers',$customers);
    }
    public function getWalkInCustomers(Request $request){
        $customers=Customer::where('type','walkin')->get();
        return Api::setResponse('customers',$customers);
    }
    public function editCustomer(Request $request){
        $customer=Customer::find($request->customer_id);
        return Api::setResponse('customers',$customer);
    }

    public function updateCustomer(Request $request){
        $customer=Customer::find($request->customer_id);
        $request->request->remove('api_token');
        $customer->update([
            'company_name'=>ucwords($request->company_name)
        ]+$request->all());
        return Api::setResponse('customers',$customer);
    }

    public function deleteCustomer(Request $request){
        $customer=Customer::find($request->customer_id);
        $customer->delete();
        return Api::setMessage('Customer Deleted');
    }

    public function searchCustomer(Request $request){
        $customers=Customer::where('company_name', 'like', '%' .$request->company_name. '%')->get();
        if($customers!=null){
            return Api::setResponse('customers',$customers);
        }else{
            return Api::setError('No data found');
        }
    }
}
