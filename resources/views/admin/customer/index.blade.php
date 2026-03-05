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
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="card-description"><a href="{{route('admin.customer.create')}}" class="btn btn-primary">Add New</a>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="card-description"><a href="{{route('admin.import-customers')}}" class="btn btn-gradient-primary">Import Customers</a>
                                    </p>
                                </div>
                            </div>
                            <h4 class="card-title">Customers List</h4>
                           
                           
                            <table class="table table-striped" id="example">
                                <thead>
                                    <tr>
                                        <th> Name </th>
                                        <th> Company Name </th>
                                        <th> Phone </th>
                                        <th> Email </th>
                                        <th> Address </th>
                                        <th> Gst Number </th>
                                        <th> Action </th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                    <tr>
                                        <td> {{$customer->name}}</td>
                                        <td> {{$customer->company_name}}</td>
                                        <td> {{$customer->phone}}</td>
                                        <td> {{$customer->email}}</td>
                                        <td> {{$customer->address}}</td>
                                        <td> {{$customer->gst_no}}</td>
                                        <td><a href="{{route('admin.customer.edit',$customer->id)}}" class="btn btn-primary">Edit</a></td>
                                        <td>
                                            <button onclick="confirmDelete('{{$customer->id}}')" class="btn btn-danger">Delete</button>
                                            <form id="delete-{{$customer->id}}" action="{{ route('admin.customer.destroy', $customer->id) }}" method="POST" style="display: none;">
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
