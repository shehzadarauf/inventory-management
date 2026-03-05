@extends('admin.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Import Customers </h3>
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
              <h4 class="card-title">Import Customers</h4>
              <form class="forms-sample" action="{{route('admin.import')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <input type="file" name="file" class="form-control" id="exampleInputUsername1" required>
                </div>
                
                <button type="submit" class="btn btn-gradient-primary me-2">Import Data</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection