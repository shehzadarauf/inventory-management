@extends('admin.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            {{-- <div class="page-header">
                <h3 class="page-title"> Basic Tables </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Tables</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Basic tables</li>
                    </ol>
                </nav>
            </div> --}}
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Users List</h4>
                            <p class="card-description" style="text-align: right"><a href="{{route('admin.user.create')}}" class="btn btn-primary">Add New</a>
                            </p>
                            <table class="table table-striped" id="example">
                                <thead>
                                    <tr>
                                        <th> Name </th>
                                        <th> Email </th>
                                        <th> Phone </th>
                                        <th>Role</th>
                                        <th> Action </th>
                                        {{-- <th> Action </th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    @if (Auth::user()->id!=$user->id)
                                    <tr>
                                        <td> {{$user->name}}</td>
                                        <td> {{$user->email}}</td>
                                        <td> {{$user->phone}}</td>  
                                        <td> {{$user->type}}</td>                       
                                        <td><a href="{{route('admin.user.edit',$user->id)}}" class="btn btn-primary">Edit</a></td>
                                        {{-- <td>
                                            <button onclick="confirmDelete('{{$user->id}}')" class="btn btn-danger">Delete</button>
                                            <form id="delete-{{$user->id}}" action="{{ route('admin.user.destroy', $user->id) }}" method="POST" style="display: none;">
                                                {{ method_field('DELETE') }}
                                                {{csrf_field()}}
                                            </form>
                                        </td> --}}
                                    </tr>
                                    @endif
                                   
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
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
