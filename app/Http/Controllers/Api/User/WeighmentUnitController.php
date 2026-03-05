<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\WeighmentUnit;
use Illuminate\Http\Request;

class WeighmentUnitController extends Controller
{
    public function weighmentUnitStore(Request $request){
        $WeighmentUnit=WeighmentUnit::create($request->all());
        return Api::setResponse('weighmentunit',$WeighmentUnit);
    }

    public function weighmentUpdate(Request $request){
        $WeighmentUnit=WeighmentUnit::find($request->id);
        $WeighmentUnit->update($request->all());
        return Api::setMessage('Weighment unit updated');
    }
    public function weighmentDelete(Request $request){
        $WeighmentUnit=WeighmentUnit::find($request->id);
        $WeighmentUnit->delete();
        return Api::setMessage('Weighment unit Deleted');
    }
    public function weignmentUnits(Request $request){
        $punits=WeighmentUnit::where('product_id',$request->product_id)->where('type','primary')->get();
        $sunits=WeighmentUnit::where('product_id',$request->product_id)->where('type','secondary')->get();
        $obj=new Api();
        $obj->primaryUnits=$punits;
        $obj->secondaryUnits=$sunits;
        return Api::setResponse('weighmentUnit',$obj);
    }

    public function setUnitDefault(Request $request){
        // $unit=WeighmentUnit::where('product_id',$request->product_id)->where('type',$request->type)->where('unit_id',$request->unit_id)->first();
        $units=WeighmentUnit::where('product_id',$request->product_id)->where('type',$request->type)->get();
        if(count($units)>0){
            foreach ($units as $key => $unit) {
                if($unit->id==$request->unit_id){
                    $unit->isDefault=true;
                }else{
                    $unit->isDefault=false;
                }
                $unit->update();
            }
            return Api::setMessage('Unit is set as default');
        }else{
            return Api::setMessage('Sorry no recourd found');
        }
        
    }
}
