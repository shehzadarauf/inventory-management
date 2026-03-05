@extends('admin.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Add weighmentUnit </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item "><a href="{{route('admin.product.index')}}" class="btn btn-primary">Products</a></li>
          </ol>
        </nav>
      </div>
      <div class="row">
        <div class="col-md-9 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title">Add new unit for ( <strong>{{$product->name}}</strong> )</h3>
              <form class="forms-sample" action="{{route('admin.productUnit.store')}}" method="POST">
                @csrf
                <input type="hidden" name="product_id" id="" value="{{$product->id}}">
                <div class="form-group">
                  <label for="exampleInputUsername1">Name*</label>
                  <input type="text" name="name" class="form-control" value="{{old('name')}}"  id="exampleInputUsername1" placeholder="Enter name" required>
                </div>
                <div class="form-group">
                  <label for="type">Select Type</label>
                  <select name="type" class="form-control">
                    <option value="primary">Primary</option>
                    <option value="secondary">Secondary</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-gradient-primary me-2">Add New</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"><strong>{{$product->name}}</strong> Units list</h3>
                   
                   
                    <table class="table table-striped" id="example">
                        <thead>
                            <tr>
                                <th> Sr# </th>
                                <th> Name </th>
                                <th> Type </th>
                                <th> Action </th>
                                {{-- <th> Action </th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($units as $key => $unit)
                            <tr>
                                <td> {{$key+1}}</td>
                                <td> {{$unit->name}}</td>
                                <td> {{$unit->type}}</td>
                                
                                {{-- <td>
                                    <button type="button" class="btn btn-primary editlength" lengthName="{{$length->name}}" lengthId="{{$length->id}}" data-toggle="modal" data-target="#length">
                                        Edit
                                    </button>
                                </td> --}}
                                <td>
                                    <button onclick="confirmDelete('{{$unit->id}}')" class="btn btn-danger">Delete</button>
                                    <form id="delete-{{$unit->id}}" action="{{ route('admin.productUnit.destroy') }}" method="POST" style="display: none;">
                                      <input type="hidden" name="unit_id" value="{{$unit->id}}">
                                        {{csrf_field()}}
                                    </form>
                                </td>
                                
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmDelete(id) {
        let choice=confirm("Are you sure, You want to delete");
        if (choice){
            document.getElementById("delete-"+id).submit();
        }
    }
</script>
    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable( {
            responsive: true,
         } );
 
          new $.fn.dataTable.FixedHeader( table );

         
        });
    </script>
@endsection