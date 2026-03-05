@extends('admin.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Update User </h3>
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
              <h4 class="card-title">Eedit  user data</h4>
              <form class="forms-sample" action="{{route('admin.user.update',$user->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="exampleInputUsername1">Name*</label>
                  <input type="text" name="name" value="{{$user->name}}" class="form-control" id="exampleInputUsername1" placeholder="Enter name" required>
                  
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email Address</label>
                    <input type="email" name="email" value="{{$user->email}}"  class="form-control" id="exampleInputEmail1" placeholder="Enter email" required>
                  </div>
                <div class="form-group">
                  <label for="exampleInputUsername1">Password</label>
                  <input type="password" name="password" class="form-control" id="exampleInputUsername1" placeholder="Enter Password">
                </div> 
                {{-- <div class="form-group">
                  <label for="exampleInputUsername1">Phone</label>
                  <input type="number" name="phone" value="{{$user->phone}}" class="form-control" id="exampleInputUsername1" placeholder="Enter contact number" required>
                </div> --}}
                <div class="form-group">
                  <label for="exampleInputUsername1">Phone*</label>
                  <div class="input-group ">
                    <div class="input-group-prepend">
                      <span class="input-group-text bg-white text-dark" >+91</span>
                    </div>
                    <input type="text" class="form-control" name="phone" value="{{$user->phone}}" placeholder="phone" aria-label="Username" aria-describedby="basic-addon1" required style="height: 50px">
                  </div>
                
                </div>
                <div class="form-group">
                  <label for="exampleInputUsername1">Type*</label>
                  <select name="type" id="" class="form-control" required style="height: 50px">
                      <option value="" selected >Select any Type</option>
                      <option {{$user->type=='Sales Manager'?'selected':''}}  value="Sales Manager">Sales Manager</option>
                      <option {{$user->type=='Store Manager'?'selected':''}}  value="Store Manager">Store Manager</option>
                  </select>
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