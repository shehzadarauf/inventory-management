@extends('admin.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Add Product </h3>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item btn"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          </ol>
        </nav>
      </div>
      <div class="row">
        <div class="col-md-9 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Add new Product</h4>
              <form class="forms-sample" action="{{route('admin.product.store')}}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="exampleInputUsername1">Name*</label>
                  <input type="text" name="name" class="form-control" value="{{old('name')}}"  id="exampleInputUsername1" placeholder="Enter name" required>
                </div>
                <div class="form-group">
                    <label for="category">Category*</label>
                    <select name="category_id" id="category" class="form-control" required>
                        <option value="" selected>Select category</option>
                        @foreach (App\Models\Category::all() as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
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
                    <h4 class="card-title">Products List</h4>
                   
                   
                    <table class="table table-striped" id="example">
                        <thead>
                            <tr>
                                <th> Sr# </th>
                                <th> Name </th>
                                <th> Category Name </th>
                                <th> Action </th>
                                <th> Action </th>
                                <th> Action </th>
                                <th> Action </th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (App\Models\Product::all() as $key => $product)
                            <tr>
                                <td> {{$key+1}}</td>
                                <td> {{$product->name}}</td>
                                <td> {{$product->category->name}}</td>
                                
                               
                                <td><a href="{{route('admin.product.sizes',$product->id)}}" class="btn btn-info">Sizes</a></td>
                                <td><a href="{{route('admin.product.lengths',$product->id)}}" class="btn btn-info">Lengths</a></td>
                                <td><a href="{{route('admin.weighmentUnit',$product->id)}}" class="btn btn-info">Units</a></td>
                                <td>
                                  <button type="button" class="btn btn-primary editproduct" productName="{{$product->name}}" productId="{{$product->id}}" productCategory="{{$product->category->id}}" data-toggle="modal" data-target="#product">
                                      Edit
                                    </button>
                                </td>
                                <td>
                                  
                                    <button onclick="confirmDelete('{{$product->id}}')" class="btn btn-danger">Delete</button>
                                    <form id="delete-{{$product->id}}" action="{{ route('admin.product.destroy', $product->id) }}" method="POST" style="display: none;">
                                        {{ method_field('DELETE') }}
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



<div class="modal fade" id="product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="updateProductForm"  class="form-group" method="POST">
        <div class="modal-body">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control">  
            </div>
            
              <div class="form-group">
                <label for="category">Category*</label>
                <select name="category_id" id="productCategory" class="form-control">
                    <option value="" selected></option>
                    @foreach (App\Models\Category::all() as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
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
          $('.editproduct').on('click',function(e){
            e.preventDefault();
            let productId = $(this).attr('productId');
            let productName = $(this).attr('productName');
            let productCategory = $(this).attr('productCategory');
            $('#name').val(productName);
            $('#productCategory').val(productCategory);
            $('#productCategory').change();
            $('#updateProductForm').attr('action','{{route('admin.product.update','')}}'+'/'+productId); 
          });
            var table = $('#example').DataTable( {
            responsive: true,
         } );
 
          new $.fn.dataTable.FixedHeader( table );

         
        });
    </script>
@endsection