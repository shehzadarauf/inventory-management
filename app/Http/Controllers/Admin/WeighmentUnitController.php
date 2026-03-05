<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\WeighmentUnit;
use Illuminate\Http\Request;

class WeighmentUnitController extends Controller
{

    public function storeUnit(Request $request){
        $WeighmentUnit=WeighmentUnit::create($request->all());
        toastr()->success('Weighment unit added successfully');
        return redirect()->back();
    }
    public function weighmentUnits($id){

        $product=Product::find($id);
        $units=WeighmentUnit::where('product_id',$id)->get();
        return view('admin.weighmentUnit.index')->with('units',$units)->with('product',$product);
    }

    public function destroyUnit(Request $request){
        $unit=WeighmentUnit::find($request->unit_id);
        $unit->delete();
        toastr()->error('Unit deleted ');
        return redirect()->back();
    }
}
