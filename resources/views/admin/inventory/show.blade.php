@extends('admin.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> View Inventory </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    </ol>
                </nav>
            </div>
           
            <div class="row">
                <div class="col-md-10 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body row">
                            <h4 class="card-title">View Inventory</h4>
                            <form class="forms-sample" action="#" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-8">
                                        <label for="category">Category</label>
                                        <select name="category_id" id="category" class="form-control">
                                            <option value="" selected >Select any category</option>
                                            @foreach (App\Models\Category::all() as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label for="product">Product</label>
                                        <select name="product_id" id="product" class="form-control">
                                            <option value="" selected >Select any product</option>
                                        </select>
                                    </div>
                                    <div class="col-md-10 table-container styleDeve" >
                                        {{-- <table style="width: 100% !important">
                                            <tr class="bg-primary">
                                                <td colspan="2" class="text-center; text-white p-2">Sr.#</td>
                                                <td class="text-primary">dfsdf</td>
                                                <td colspan="2" class="text-center text-white">Length</td>
                                                <td colspan="2"></td>
                                                <td colspan="5" class=" text-white">Size</td>
                                            </tr>
                                            <tr class="text-center">
                                                <td colspan="2"></td>
                                                <td class="text-white">dfsdf</td>
                                                <td class="text-white">dfsdf</td>

                                                <td colspan="2"></td>
                                                <td>3ft</td>
                                                <td>3ft</td>
                                                <td>3ft</td>
                                                <td>3ft</td>
                                                <td>3ft</td>
                                                <td>3ft</td>
                                            </tr>
                                            <tr class=" mt-3 text-center">
                                                <td colspan="2">1</td>
                                                <td class="text-white">dfsdf</td>
                                                <td>1*2*3</td>
                                                <td colspan="2" class="text-white">sdfsdfdsf</td>
                                                <td style="margin-left: 50px"><input type="text" name="" id=""
                                                        style="width: 50px !important; height:40px; border-radius:8px;border: 1px solid black">
                                                </td>
                                                <td><input type="text" name="" id=""
                                                        style="width: 50px !important; height:40px; border-radius:8px;border: 1px solid black">
                                                </td>
                                                <td><input type="text" name="" id=""
                                                        style="width: 50px !important; height:40px; border-radius:8px;border: 1px solid black">
                                                </td>
                                                <td><input type="text" name="" id=""
                                                        style="width: 50px !important; height:40px; border-radius:8px;border: 1px solid black">
                                                </td>
                                                <td><input type="text" name="" id=""
                                                        style="width: 50px !important; height:40px; border-radius:8px;border: 1px solid black">
                                                </td>
                                                <td><input type="text" name="" id=""
                                                        style="width: 50px !important; height:40px; border-radius:8px;border: 1px solid black">
                                                </td>

                                            </tr>


                                        </table> --}}

                                    </div>
                                </div>
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
        $(document).ready(function() {

           
            // var arr = new Array();
            // var record1 = {'a':'1','b':'2','c':'3'};
            // var record2 = {'d':'4','e':'5','f':'6'};
            // arr.push(record1);
            // arr.push(record2);
            // alert(JSON.stringify(arr));

            





            var arr =[];
            let id,
            pro_id,
                qty,
                pids = [],
                sizes = [],
                lengths = [];

                let table_count=1;
                let product_name;
                let data=[];

            $('#category').on('change', function() {
                id = this.value;
                fetchProductsByCategory(id);
            });

            $('#product').on('change', function() {
                id = this.value;
                delay = true;
                fetchProduct();
            });

           

            $('body').on('click', '.remove-btn', function(e) {
                e.preventDefault();
                removeRow(this);
                removeData();
            });


            function fetchProduct() {
               
                $.ajax({
                    url: "{{ route('admin.product.inventory.get') }}",
                    method: 'post',
                    headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                    data: {
                        id: id
                    },
                    success: function(result) {
                        sizes=result.sizes;
                        lengths=result.lengths;
                        product_name=result.name;
                        arr=result.inventory;
                        pro_id=result.id;
                        appendTable(result);

                        if(result.lengths.length>9){
                            $('.styleDeve').css("overflow-x", "scroll"); 
                        }else{
                            $('.styleDeve').css("overflow-x", ""); 
                        }
                        if(result.sizes.length>7){
                            $('.styleDeve').css("height", "300px");
                            $('.styleDeve').css("overflow-y", "scroll"); 
                        }else{
                            $('.styleDeve').css("overflow-y", ""); 
                        }

                        $('#add-btn').css("display","block");
                    }
                });
            }

            function fetchProductsByCategory(id) {
                $.ajax({
                    url: "{{ route('admin.category.products') }}",
                    method: 'post',
                    headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                    data: {
                        id: id
                    },
                    success: function(result) {
                        console.log(result);
                        
                        appendProductsList(result, $('#product'));
                    }
                });
            }


            function appendTable(result) {
               
                let row = '<table style="width: 100% !important" id="tab">' +
                        '<tr style="background-color:#9a55ff">' +
                            '<td colspan="2" class="text-center text-white p-2">'+'Sr.#'+'</td>'+
                            '<td style="color:#9a55ff">'+'dfsdf'+'</td>'+
                            '<td colspan="4" class="text-center text-white">'+'Size'+'</td>'+
                            '<td colspan="2">'+'</td>'+
                            '<td colspan="5" class="text-white quantity">'+'Quantity'+'</td>'+
                        '</tr>'+
                        '<tr class="text-center lengthtd">'+
                            '<td colspan="2"></td>'+
                            '<td class="text-white">dfsdf</td>'+
                            '<td class="text-white">dfsdf</td>'+
                            '<td class="text-white">dfsdf</td>'+
                            '<td class="text-white">dfsdf</td>'+
                            '<td colspan="2"></td>'+
                        '</tr>'+
                    '</table>';
                    
                $('.table-container').empty();
                $('.table-container').html(row);

                appendLengthColumn(result);
                appendSizes(result);
                $('.quantity').attr("colspan",result.lengths.length);
            }

            function appendLengthColumn(result){
               for(let i=0; i<result.lengths.length; i++){
                       $('.lengthtd').append('<td>'+result.lengths[i].name+'</td>') 
                    }
            }

            function appendSizes(result){
                console.log(result.sizes);
               for(let i=0; i<result.sizes.length; i++){
                    let coount=i+1;
                   let srow= '<tr class=" mt-3 text-center " id="lengthBoxes'+i+'">'+
                        '<td colspan="2">'+coount+'</td>'+
                        '<td class="text-white">dfsdf</td>'+
                        '<td colspan="3">'+'<small>'+result.sizes[i].name+'</small>'+'</td>'+
                        '<td colspan="2" class="text-white">sdfsdfdsf</td>'+
                    '</tr>';
                       $('#tab').append(srow);
                       lengthBoxes(result,i);

                }
            }

            function lengthBoxes(result,j){
                for(let i=0; i<result.lengths.length; i++){
                    // let lengthBoxes= '<td style="margin-left: 50px">'+'<input type="number" class="summery_input text-center" value="'+searchValue(sizes[j].id,sizes[j].product_id,lengths[i].id)+'" sizeId="'+sizes[j].id+'" productId="'+sizes[j].product_id+'" lengthId="'+lengths[i].id+'"  type="text" style="width: 50px !important; height:40px; border-radius:8px;border: 1px solid #800080">'+'</td>'
                    //     $('#summerylengthBoxes'+j+table_count).append(lengthBoxes);
                    let lengthBoxes= '<td style="margin-left: 50px">'+'<input type="number" class="input text-center"  sizeId="'+result.sizes[j].id+'" productId="'+result.sizes[j].product_id+'" value="'+searchValue(sizes[j].id,sizes[j].product_id,lengths[i].id)+'" lengthId="'+result.lengths[i].id+'"  type="text" style="width: 50px !important; height:40px; border-radius:8px;border: 1px solid #800080" readonly>'+'</td>'
                    $('#lengthBoxes'+j).append(lengthBoxes);
                }
            }


            function searchValue(s_id,p_id,l_id){
              
                let v=0;
                console.log(arr);
                $.each(arr, function (index, d) {  
                        if(d.length_id==l_id && d.size_id==s_id && d.product_id==p_id){
                            v=d.qty;
                          
                            return false;
                          
                        }
                        
                    }); 
                return v;
            }
            function appendProductsList(result, div) {
                div.empty();
                div.append('<option selected >Select Product</option>');
                for (i = 0; i < result.length; i++) {
                    div.append('<option value="' + result[i].id + '">' + result[i].name + '</option>');
                }
               
            }


            ///FOCUS MANAGMENT/////////


            $('#category').on("change", function() {
                $('#product').focus();
            });

           
        });
    </script>
@endsection
