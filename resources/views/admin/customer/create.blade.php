@extends('admin.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Add Customer </h3>
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
              <h4 class="card-title">Add new customer</h4>
              <form class="forms-sample" action="{{route('admin.customer.store')}}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="exampleInputUsername1">Customer Type</label>
                  <select  id="type" class="form-control">
                    <option value="tax_payer">Tax Payer</option>
                    <option value="nontax_payer">Non Tax Payer</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputUsername1">Name</label>
                  <input type="text" name="name" value="{{old('name')}}" class="form-control" id="exampleInputUsername1" placeholder="Enter Name" >
                </div>
                <div class="form-group">
                  <label for="exampleInputUsername1">Company Name*</label>
                  <input type="text" name="company_name" value="{{old('company_name')}}" class="form-control" id="exampleInputUsername1" placeholder="Enter Company Name" required>
                </div>
              
                <div class="form-group">
                  <label for="exampleInputUsername1">Phone*</label>
                  <div class="input-group ">
                    <div class="input-group-prepend">
                      <span class="input-group-text bg-white text-dark" >+91</span>
                    </div>
                    <input type="text" class="form-control" name="phone" value="{{old('phone')}}" placeholder="phone" aria-label="Username" aria-describedby="basic-addon1" required style="height: 50px">
                  </div>
                  @if ($errors->has('phone'))
                  <small class="form-text text-danger">{{$errors->first('phone')}}</small>
                  @endif
                </div>
               
               
                <div class="form-group">
                  <label for="exampleInputUsername1">GST Number*</label>
                  <input type="text" name="gst_no" value="{{old('gst_no')}}" class="form-control" id="gst" placeholder="Enter gst number" required>
                  @if ($errors->has('gst_no'))
                  <small class="form-text text-danger">{{$errors->first('gst_no')}}</small>
                  @endif
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" name="email"  value="{{old('email')}}" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Address</label>
                    <input type="text" name="address"  value="{{old('address')}}" class="form-control" placeholder="Enter your address">
                </div>
                <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
  $(document).ready(function(){
    $(document).on('change','#type',function(){
      let type = $(this).val();

        if(type=='nontax_payer'){
        $('#gst').prop('required',false);
        }else{
          $('#gst').prop('required',true);
        }
    });

  });
</script>
@endsection