@extends('admin.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> Edit Inventory </h3>
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
                            <h4 class="card-title">Edit Inventory</h4>
                            <form class="forms-sample" action="#" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-8">
                                        <label for="date">Date</label>
                                        <input type="date" name="date" id="date" class="form-control">
                                    </div>

                                    <div class="form-group col-md-8 category_container" style="display: none">
                                        <label for="category">Category</label>
                                        <select name="category_id" id="category" class="form-control">
                                            <option value="" selected >Select any category</option>
                                            @foreach (App\Models\Category::all() as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-8 product_container" style="display: none">
                                        <label for="product">Product</label>
                                        <select name="product_id" id="product" class="form-control">
                                            <option value="" selected >Select any product</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-10 table-container styleDeve" >

                                    </div>

                                </div>
                                <button class="btn btn-gradient-primary me-2 mt-5" id="add-btn" >Add Inventory</button>

                            </form>
                        </div>
                    </div>
                   
                </div>
               
                <div class="col-md-10 summery">
                    
                </div>
                <div class="col-md-10">
                    <form action="{{route('admin.add.inventory')}}" method="POST" class="summeryForm">
                        @csrf
                        <input type="hidden" name="data" class="summeryIputDataField">
                       <button type="submit" class="btn btn-primary summerySubmit" style="display: none">Submit Summery</button>
                    </form>
                    
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
                date,
                pro_id,
                qty,
                pids = [],
                sizes = [],
                summerysizes = [],
                lengths = [];
                summeryArray=[];
                let table_count=1;
                let product_name;
                let data=[];
                // $('category_container').hid();
                // $('_container').hid();

            $('#date').on('change', function(e) {
                e.preventDefault();
                date = $('#date').val();
                delay = true;
                fetchInventoryByDate();
            });

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
                     
                        
                        appendProductsList(result, $('#product'));
                    }
                });
            }

            function fetchProduct() {
                $.ajax({
                    url: "{{ route('admin.product.get') }}",
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

            

            function appendTable(j) {
               
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
               $('.table-container').append(row);
               // $('#lengthBoxes'+j).append(lengthBoxes);

               appendLengthColumn();
               appendSizes();
               $('.quantity').attr("colspan",lengths.length);
           }

           function appendLengthColumn(){
              for(let i=0; i<lengths.length; i++){
                      $('.lengthtd').append('<td>'+lengths[i].name+'</td>') 
                   }
           }

           function appendSizes(){
               console.log(sizes);
              for(let i=0; i<sizes.length; i++){
                   let coount=i+1;
                  let srow= '<tr class=" mt-3 text-center " id="lengthBoxes'+i+'">'+
                       '<td colspan="2">'+coount+'</td>'+
                       '<td class="text-white">dfsdf</td>'+
                       '<td colspan="3">'+'<small>'+sizes[i].name+'</small>'+'</td>'+
                       '<td colspan="2" class="text-white">sdfsdfdsf</td>'+
                   '</tr>';
                      $('#tab').append(srow);
                      lengthBoxes(i);

               }
           }

           function lengthBoxes(j){
               for(let i=0; i<lengths.length; i++){
                   // let lengthBoxes= '<td style="margin-left: 50px">'+'<input type="number" class="summery_input text-center" value="'+searchValue(sizes[j].id,sizes[j].product_id,lengths[i].id)+'" sizeId="'+sizes[j].id+'" productId="'+sizes[j].product_id+'" lengthId="'+lengths[i].id+'"  type="text" style="width: 50px !important; height:40px; border-radius:8px;border: 1px solid #800080">'+'</td>'
                   //     $('#summerylengthBoxes'+j+table_count).append(lengthBoxes);
                   let lengthBoxes= '<td style="margin-left: 50px">'+'<input type="number" class="input text-center"  sizeId="'+sizes[j].id+'" productId="'+sizes[j].product_id+'" value="'+searchValue(sizes[j].id,sizes[j].product_id,lengths[i].id)+'" lengthId="'+lengths[i].id+'"  type="text" style="width: 50px !important; height:40px; border-radius:8px;border: 1px solid #800080">'+'</td>'
                   $('#lengthBoxes'+j).append(lengthBoxes);
               }
           }

            $('#add-btn').click(function(e) {
                e.preventDefault();
                $("select option").prop("selected", false);
                $("select option").prop("selected", false);
                let check=false;
                // if(pids.length>0){
                //     $.each(pids, function (index, value) {
                //         if(pro_id==value){
                //             check=true;
                           
                //         }
                //     });
                //     if(check==true){
                //         toastr.error("Sorry this product already exist in summery");
                //     }else{
                //         addsummery();
                //     }
                // }else{
                //     addsummery();
                // }
                addsummery();
                $('.summerySubmit').css("display","block");
                $('#add-btn').css("display","none");
           });

           function addsummery(){
            
            $(".input").each(function(){
                let product_id=$(this).attr('productId');
                let length_id=$(this).attr('lengthId');
                let size_id=$(this).attr('sizeId');
                let qty=this.value;
                // if(qty!=0){
                    let test={
                    'product_id':product_id,
                    'length_id':length_id,
                    'size_id':size_id,
                    'qty':qty
                };
                arr.push(test);
               

                // }
                
            });
            pids.push(pro_id);
         //    arr=JSON.stringify(arr);
            apendSummery(arr);
           
             if(lengths.length>9){
                 $('.summerystyleDeve'+table_count).css("overflow-x", "scroll"); 
             
             }else{
                 $('.summerystyleDeve'+table_count).css("overflow-x", ""); 
                 
             }
             if(sizes.length>9){
                 $('.summerystyleDeve'+table_count).css("height", "300px");
                 $('.summerystyleDeve'+table_count).css("overflow-y", "scroll"); 
             }else{
                 $('.summerystyleDeve'+table_count).css("overflow-y", ""); 
                 $('.summerystyleDeve'+table_count).css("height", ""); 
             }
             table_count++;
             sizes='';
             lengths='';
             $('.table-container').empty();
             $('.styleDeve').css("height", "");
             $('.styleDeve').css("overflow-x", ""); 
             $('.styleDeve').css("overflow-y", ""); 
        }
        // function apendSummery(arr){
        //         // for(let i=1; i<4; i++){
        //         let div='<div class="col-md-12 grid-margin stretch-card">'+
        //                 '<div class="card">'+
        //                     '<div class="card-body row">'+
        //                         '<h1>'+product_name+'</h1>'+
        //                         '<div class="col-md-10">'+
        //                             '<div class="col-md-12 summerystyleDeve'+table_count+'" id="summery_table_container'+table_count+'">'+'</div>'+
        //                         '</div>'+
        //                     '</div>'+
        //                 '</div>'+
        //             '</div>';
        //         $('.summery').append(div);
        //         apendSummeryTable(arr);
        //     // }
        //     }


            function fetchInventoryByDate() {
                $.ajax({
                    url: "{{ route('admin.product.inventorybytimestamp.get') }}",
                    method:'post',
                    headers:{
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                    data: {
                        date: date
                    },
                    success: function(result) {
                        alert('hiiddd');
                        console.log(result);
                        if(result.length>0){
                            for (let index = 0; index < result.length; index++) {
                                sizes=result[index].sizes;
                                lengths=result[index].lengths;
                                arr=result[index].inventories;
                                product_name=result[index].name;
                                pro_id=result[index].id;
                                createSummeryArray();
                                 pids.push(pro_id);
                                    appendSummery();

                                    if(lengths.length>9){
                    
                                        $('.summerystyleDeve'+table_count).css("overflow-x", "scroll"); 
                                    
                                    }else{
                                        $('.summerystyleDeve'+table_count).css("overflow-x", ""); 
                                        
                                    }
                                    if(sizes.length>9){
                                        $('.summerystyleDeve'+table_count).css("height", "300px");
                                        $('.summerystyleDeve'+table_count).css("overflow-y", "scroll"); 
                                    }else{
                                        $('.summerystyleDeve'+table_count).css("overflow-y", ""); 
                                        $('.summerystyleDeve'+table_count).css("height", ""); 
                                    }
                                    table_count++;
                                //     sizes='';
                                //     lengths='';
                                // $('.table-container').empty();
                                // $('.summery').empty();
                                $('.category_container').css("display","block");
                                $('.product_container').css("display","block");
                            
                            }
                        }else{
                            $('.styleDeve').css("height", "");
                            $('.styleDeve').css("overflow-y", ""); 
                            $('.styleDeve').css("overflow-x", ""); 
                            $('.table-container').empty();
                            $('.category_container').css("display","none");
                           $('.product_container').css("display","none");
                            toastr.error('Sorry no record found');
                        }
                     
                      
                    
                       
                        // product_name=result.name;
                        // arr=result.inventory;
                        // pro_id=result.id;
                        // appendTable(result);

                       

                        // $('#add-btn').css("display","block");
                    }
                });
            }


            function appendSummery(){
                let div='<div class="col-md-12 grid-margin stretch-card">'+
                        '<div class="card">'+
                            '<div class="card-body row">'+
                                '<h1>'+product_name+'</h1>'+
                                '<div class="col-md-10">'+
                                    '<div class="col-md-12 summerystyleDeve'+table_count+'" id="summery_table_container'+table_count+'">'+'</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>';
                $('.summery').append(div);
                apendSummeryTable(arr);
                
            }

            function apendSummeryTable(arr){
                let row = '<table style="width: 100% !important" class="summery_tab'+table_count+'">' +
                        '<tr style="background-color:#9a55ff">' +
                            '<td colspan="2" class="text-center text-white p-2">'+'Sr.#'+'</td>'+
                            '<td style="color:#9a55ff">'+'dfsdf'+'</td>'+
                            '<td colspan="4" class="text-center text-white">'+'Size'+'</td>'+
                            '<td colspan="2">'+'</td>'+
                            '<td colspan="5" class="text-white table_summery_quantity'+table_count+'">'+'Quantity'+'</td>'+
                        '</tr>'+
                        '<tr class="text-center summerylengthtd'+table_count+'">'+
                            '<td colspan="2"></td>'+
                            '<td class="text-white">dfsdf</td>'+
                            '<td class="text-white">dfsdf</td>'+
                            '<td class="text-white">dfsdf</td>'+
                            '<td class="text-white">dfsdf</td>'+
                            '<td colspan="2"></td>'+
                        '</tr>'+
                    '</table>';
                    
                // $('.summery_table_container').empty();
                $('#summery_table_container'+table_count).html(row);

                appendSummeryLengthColumn(arr);
                appendSummerySizes(arr);
                $('.table_summery_quantity'+table_count).attr("colspan",lengths.length);
            }
           

            function appendSummeryLengthColumn(arr){
                for(let i=0; i<lengths.length; i++){
                       $('.summerylengthtd'+table_count).append('<td>'+lengths[i].name+'</td>') 
                    }
            }

            function appendSummerySizes(arr){
                
                for(let i=0; i<sizes.length; i++){
                    let coount=i+1;
                   let srow= '<tr class=" mt-3 text-center " id="summerylengthBoxes'+i+table_count+'">'+
                        '<td colspan="2">'+coount+'</td>'+
                        '<td class="text-white">dfsdf</td>'+
                        '<td colspan="3">'+'<small>'+sizes[i].name+'</small>'+'</td>'+
                        '<td colspan="2" class="text-white">sdfsdfdsf</td>'+
                    '</tr>';
                       $('.summery_tab'+table_count).append(srow);
                       summerylengthBoxes(lengths,i);

                }
            }

            function summerylengthBoxes(lengths,j){
                for(let i=0; i<lengths.length; i++){
                    // $.each(arr, function (index, value) {  
                        // if(value.length_id==lengths[i].id && value.size_id==sizes[j].id && value.product_id==sizes[j].product_id){
                        //     let lengthBoxes= '<td style="margin-left: 50px">'+'<input type="number" class="input text-center" value="'+value.qty+'" sizeId="'+sizes[j].id+'" productId="'+sizes[j].product_id+'" lengthId="'+lengths[i].id+'"  type="text" style="width: 50px !important; height:40px; border-radius:8px;border: 1px solid #800080">'+'</td>'
                        //     $('#summerylengthBoxes'+j+table_count).append(lengthBoxes);
                        // }else{
                            let lengthBoxes= '<td style="margin-left: 50px">'+'<input type="number" class="summery_input text-center" value="'+searchValue(sizes[j].id,sizes[j].product_id,lengths[i].id)+'" sizeId="'+sizes[j].id+'" productId="'+sizes[j].product_id+'" lengthId="'+lengths[i].id+'"  type="text" style="width: 50px !important; height:40px; border-radius:8px;border: 1px solid #800080">'+'</td>'
                            $('#summerylengthBoxes'+j+table_count).append(lengthBoxes);
                        // }
                        
                    // }); 

                    
                }
            }




            function createSummeryArray(){
                $.each(arr, function (index, summeryObject) { 
                    summeryArray.push(summeryObject);
                });
            }


            function searchValue(s_id,p_id,l_id){
                let v=0;
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
