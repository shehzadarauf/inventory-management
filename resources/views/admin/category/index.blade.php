@extends('admin.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="page-header">
        <h3 class="page-title"> Add Category </h3>
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
              <h4 class="card-title">Add new category</h4>
              <form class="forms-sample" action="{{route('admin.category.store')}}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="exampleInputUsername1">Name*</label>
                  <input type="text" name="name" class="form-control" value="{{old('name')}}"  id="exampleInputUsername1" placeholder="Enter name" required>
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
                    <h4 class="card-title">Categories List</h4>
                   
                   
                    <table class="table table-striped" id="example">
                        <thead>
                            <tr>
                                <th> Sr# </th>
                                <th> Name </th>
                                <th> Action </th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (App\Models\Category::all() as $key => $category)
                            <tr>
                                <td> {{$key+1}}</td>
                                <td> {{$category->name}}</td>
                                
                                <td>
                                    <button type="button" class="btn btn-primary editCategory" categoryName="{{$category->name}}" categoryId="{{$category->id}}" data-toggle="modal" data-target="#category">
                                        Edit
                                      </button>
                                <td>
                                    <button onclick="confirmDelete('{{$category->id}}')" class="btn btn-danger">Delete</button>
                                    <form id="delete-{{$category->id}}" action="{{ route('admin.category.destroy', $category->id) }}" method="POST" style="display: none;">
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



<div class="modal fade" id="category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Cateogry</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="updateCategoryForm"  class="form-group" method="POST">
        <div class="modal-body">
            @csrf
            @method('PUT')
              <label for="name">Name</label>
              <input type="text" name="name" id="name" class="form-control">
         
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
          $('.editCategory').on('click',function(e){
            e.preventDefault();
            let categoryId = $(this).attr('categoryId');
            let categoryName = $(this).attr('categoryName');
            $('#name').val(categoryName);
            $('#updateCategoryForm').attr('action','{{route('admin.category.update','')}}'+'/'+categoryId); 
          });
            var table = $('#example').DataTable( {
            responsive: true,
         } );
 
          new $.fn.dataTable.FixedHeader( table );

         
        });
    </script>
@endsection