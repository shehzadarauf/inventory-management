<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductLength;
use Illuminate\Http\Request;

class ProductLengthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productLength=ProductLength::create($request->all());
        toastr()->success('Length added successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductLength  $productLength
     * @return \Illuminate\Http\Response
     */
    public function show(ProductLength $productLength)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductLength  $productLength
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductLength $productLength)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductLength  $productLength
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductLength $productLength)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductLength  $productLength
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductLength $productLength)
    {
        $productLength->delete();
        toastr()->error('Length deleted');
        return redirect()->back();
    }
}
