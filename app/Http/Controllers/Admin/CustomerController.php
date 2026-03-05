<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\CustomerImport;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers=Customer::all();
        return view('admin.customer.index')->with('customers',$customers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       

        // $query=DB::select("SELECT NAME FROM CUSTOMERS WHERE LOWER(NAME) LIKE '%$request->name%'");
        
        // dd($query);
        $customer=Customer::where('company_name',ucwords($request->company_name))->first();
     if($customer!=null){
        toastr()->error('A customer with this name already exist');
        return redirect()->back();
     }else{
        $Validator = Validator::make($request->all(), Customer::registerRules($request->type));
        if ($Validator->fails()) {
            $request->merge(array('add_form_validate' => 1));
            toastr()->error($Validator->errors()->first());
            return redirect()->back()->withErrors($Validator)->withInput();
        } else {
        $customer = Customer::create([
            'user_id'=>Auth::user()->id,
            'phone'=>'+91'.$request->phone,
            'company_name'=>ucwords($request->company_name)
        ]+$request->all());
        toastr()->success('Customer added successfully');
        return redirect()->route('admin.customer.index');
        }
     }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('admin.customer.edit')->with('customer',$customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $Validator = Validator::make($request->all(), Customer::registerRules());
        if ($Validator->fails()) {
            $request->merge(array('add_form_validate' => 1));
            toastr()->error($Validator->errors()->first());
            return redirect()->back()->withErrors($Validator)->withInput();
        } else {
        $customer->update([
            'phone'=>'+91'.$request->phone,
            'company_name'=>ucwords($request->company_name)
        ]+$request->all());
        toastr()->warning('Customer updated');
        return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        toastr()->error('Customer deleted');
        return redirect()->back();
    }


    public function importCustomers()
    {
       return view('admin.customer.import');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function storeCustomers(Request $request) 
    {
        
        Excel::import(new CustomerImport, $request->file('file')->store('temp'));
        toastr()->warning('Customers successfully imported');
        return back();
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function fileExport() 
    // {
    //     return Excel::download(new UsersExport, 'users-collection.xlsx');
    // }    
}
