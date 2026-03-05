<?php

namespace App\Http\Controllers\Api\user;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function addLead(Request $request){
        $lead = Lead::create([
            'user_id'=>Auth::user()->id
        ]+$request->all());
        return Api::setMessage('Lead Created');
    }

    public function getLeads(Request $request){
        $leads=Lead::all();
        return Api::setResponse('leads',$leads);
    }

    public function editLead(Request $request){
        $lead=Lead::find($request->lead_id);
        return Api::setResponse('lead',$lead);
    }

    public function updateLead(Request $request){
        $lead=Lead::find($request->lead_id);
        $request->request->remove('api_token');
        $lead->update($request->all());
        $lead=Lead::find($request->lead_id);
        return Api::setResponse('lead',$lead);
    }

    public function deleteLead(Request $request){
        $lead=Lead::find($request->lead_id);
        $lead->delete();
        return Api::setMessage('Lead Deleted');
    }

    public function makeLeadToCustomer(Request $request){
        $lead = Lead::find($request->lead_id);
        $Customer=Customer::create([
            'user_id'=>$lead->user_id,
            'name'=>$lead->name,
            'email'=>$lead->email,
            'phone'=>$lead->phone,
            'company_name'=>$lead->company_name,
            'gst_no'=>$lead->gst_no,
            'address'=>$lead->address
        ]);
        $lead->delete();
        return  Api::setResponse('customer',$Customer);
    }
}
