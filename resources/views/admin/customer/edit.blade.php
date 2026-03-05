@extends('admin.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Update Customer </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          </ol>
        </nav>
      </div>
      <div class="row">
        <div class="col-md-9 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Edit  customer data</h4>
              <form class="forms-sample" action="{{route('admin.customer.update',$customer->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="exampleInputUsername1">Name</label>
                  <input type="text" name="name" value="{{$customer->name}}" class="form-control" id="exampleInputUsername1" placeholder="Enter name" >
                </div>
                <div class="form-group">
                  <label for="exampleInputUsername1">Company Name*</label>
                  <input type="text" name="company_name" value="{{$customer->company_name}}" class="form-control" id="exampleInputUsername1" placeholder="Enter Company Name" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputUsername1">Phone*</label>
                  <div class="input-group ">
                    <div class="input-group-prepend">
                      <span class="input-group-text bg-white text-dark" >+91</span>
                    </div>
                    <input type="text" class="form-control" name="phone" value="{{str_replace('+91','',$customer->phone)}}" placeholder="phone" aria-label="Username" aria-describedby="basic-addon1" required style="height: 50px">
                  </div>
                  @if ($errors->has('phone'))
                  <small class="form-text text-danger">{{$errors->first('phone')}}</small>
                  @endif
                </div>
               
                <div class="form-group">
                  <label for="exampleInputUsername1">GST Number*</label>
                  <input type="text" name="gst_no" value="{{$customer->gst_no}}" class="form-control" id="exampleInputUsername1" placeholder="Enter gst number" required >
                 @if ($errors->has('gst_no'))
                  <small class="form-text text-danger">{{$errors->first('gst_no')}}</small>
                  @endif
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" name="email" value="{{$customer->email}}" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Address</label>
                    <input type="text" name="address" value="{{$customer->address}}" class="form-control" placeholder="Enter your address">
                </div>
                <button type="submit" class="btn btn-gradient-primary me-2">Update</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection