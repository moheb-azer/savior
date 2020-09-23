@extends('layout')

@section('pageTitle', '- Products')

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@section('pagecontent')
        <!-- Main content -->
        <section class="content m-5">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">PRODUCTS LISTS
                                    <span>
                                     <a href="" class="btn btn-sm btn-primary float-md-right" data-toggle="modal" data-target="#formModal" >Add New</a>
                                    <a class="btn btn-sm btn-success mr-1" href="{{route('categories_page')}}">Categories</a>
                                    <a class="btn btn-sm btn-success mr-1" href="{{route('subcategories_page')}}">Subcategories</a>
                                    <a class="btn btn-sm btn-success mr-1" href="{{route('brands_page')}}">Brands</a>
                                    </span>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Code</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Subcategory</th>
                                        <th>Brand</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Code</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Subcategory</th>
                                        <th>Brand</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        <!-- Modal -->
        <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                   <div class="modal-header">
                           <h5 class="modal-title" id="formModalLabel">Product's Data</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                               <span aria-hidden="true">&times;</span>
                           </button>
                       </div>
                       <div class="modal-body ">
                           <form class="form">
                                   <div id="validation" class="alert alert-danger">
                                    <ul>
                                    </ul>
                                </div>
                                <div class="form-group myid">
                                    <label for="id">id</label>
                                    <input class="form-control" type="text" name="id" id="id" value="" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="p_code">Code</label>
                                    <input class="form-control" type="text" name="p_code" id="p_code" value="" >
                                </div>
                                <div class="form-group">
                                    <label for="p_name">Product Name</label>
                                    <input class="form-control" type="text" name="p_name" id="p_name" value="" >
                                </div>
                                <div class="form-group">
                                    <label for="cat_id">Category</label>
                                    <select class="form-control" type="text" name="cat_id" id="cat_id">
                                    </select>
                                </div><div class="form-group">
                                    <label for="subcat_id">Subcategory</label>
                                    <select class="form-control" type="text" name="subcat_id" id="subcat_id"  >
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="brand_id">Brand</label>
                                    <select class="form-control" type="text" name="brand_id" id="brand_id"  >
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" type="text" name="description" id="description"  ></textarea>
                                </div>
                           </form>
                       </div>
                       <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearData()">Close</button>
                           <button type="button" class="btn btn-primary"
                                   id="save" onclick="saveData()">Save</button>
                           <button type="button" class="btn btn-warning"
                                   id="update" onclick="updateData()">update</button>
                       </div>
                   </div>
               </div>
           </div>
           <!-- End Modal -->
@endsection




@push('js')

    <!-- DataTables -->
    <script src="{{ asset('assets/backend/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('assets/backend/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('assets/backend/plugins/fastclick/fastclick.js') }}"></script>

    <!-- Sweet Alert Js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.1/dist/sweetalert2.all.min.js"></script>

@endpush


@section('script')
    <script type="text/javascript">
        let dataTable = $('#example1');
        let modal = $("#formModal");
        let validateAlert =$('#validation').hide();
        let saveBtn =$("#save").show();
        let updateBtn= $("#update").hide();
        let myId = $('.myid').hide();
        let form = $('.form');
        let prefCat ="";
        let prefSubcat ="";
        let prefBrand ="";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name = "csrf-token"]').attr('content')
            }
        });

        function clearData() {
            saveBtn.show();
            updateBtn.hide();
            myId.hide();
            form.trigger("reset");
            prefCat ="";
            prefSubcat ="";
            prefBrand ="";
            validateAlert.hide();

        }

        $(document).ready(function () {
             dataTable.DataTable({
                "ajax":{
                    "url":"{{ route('products.index') }}",
                    "dataSrc": "products"
                },
                "columns": [
                    {"data":"id"},
                    {"data":"p_code"},
                    {"data":"p_name"},
                    {"data":"cat_name"},
                    {"data":"subcat_name"},
                    {"data":"brand_name"},
                    {"data":"description"},
                    {"data":"id", render: function (data, type, row) {
                            return  '<button href="" class="btn btn-info m-1" data-toggle="modal" data-target="#formModal" onclick="editData(' + row.id + ")" + '">'+
                                    '<i class="fas fa-edit" aria-hidden="true"></i></button>'+
                                    '<button class="btn btn-danger m-1" type="button" onclick="deleteItem(' + row.id + ")" + '">'+
                                    '<i class="fa fa-trash" aria-hidden="true"></i></button>'+
                                    '<form id="delete-form-' + row.id + '" action="" method="post" style="display:none;"></form>';
                        }},
                ],
                "autoWidth": false
            });
        });
        
        function showCat() {
            $.ajax({
                type : "GET",
                dataType: "json",
                url: "{{ route('show_cat') }}",
                success: function(response) {
                    let cats ="";
                    console.log(prefCat, prefSubcat);
                    if ( prefCat === "" && prefSubcat === "" ){
                        cats += "<option value=''>...</option>";
                    }

                    $.each(response, function (key, value) {
                        cats += "<option value='";
                        cats += value.id ;
                        cats += "'";
                        if (prefCat === value.id) {cats += "selected"}
                        cats += ">";
                        cats += value.cat_name ;
                        cats += "</option>" ;
                    });
                    $('#cat_id').html(cats);
                }
            });
        }
        showCat();
        
        function showSubcat() {

            $.ajax({
                type : "GET",
                dataType: "json",
                url: "{{ route('show_subcat') }}",
                success: function(response) {

                    let subcats ="";
                    $.each(response, function (key, value) {
                        if ($("#cat_id").val() == value.cat_id) {
                            subcats += "<option value='";
                            subcats += value.id;
                            subcats += "'";
                            if (prefSubcat === value.id) {subcats += "selected"}
                            subcats += ">";
                            subcats += value.subcat_name;
                            subcats += "</option>";
                        }
                        $('#subcat_id').html(subcats);
                    });

                    $('#cat_id').change(function(){
                        let subcats ="";
                        $.each(response, function (key, value) {
                            if ($("#cat_id").val() == value.cat_id) {
                                subcats += "<option value='";
                                subcats += value.id;
                                subcats += "'";
                                if (prefSubcat === value.id) {subcats += "selected"}
                                subcats += ">";
                                subcats += value.subcat_name;
                                subcats += "</option>";
                            }
                        });
                        $('#subcat_id').html(subcats);
                    })
                }
            });
        }
        showSubcat();
        
        function showBrand() {
            $.ajax({
                type : "GET",
                dataType: "json",
                url: "{{ route('show_brand') }}",
                success: function(response) {
                    let brands ="";
                    $.each(response, function (key, value) {
                        brands += "<option value='";
                        brands += value.id ;
                        brands += "'";
                        if (prefBrand === value.id) {brands += "selected"}
                        brands += ">";
                        brands += value.brand_name ;
                        brands += "</option>" ;
                    });
                    $('#brand_id').html(brands);
                }
            });
        }
        showBrand();

        function saveData()     {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: form.serialize(),
                url: "/products",
                error:function(response,){
                    let row ="";
                    $.each(response.responseJSON.errors,function (key, value) {
                         row += "<li>" + value + "</li>";
                    });
                    validateAlert.html(row);
                    validateAlert.show();
                },
                success: function() {
                    dataTable.DataTable().ajax.reload(null, false);
                    modal.modal('hide');
                    clearData();

                }
            });
        }

        function editData(id) {

            saveBtn.hide();
            updateBtn.show();
            myId.show();
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/products/"+id+"/edit",
                success: function (response) {
                    $('#id').val(response.id);
                    $('#p_code').val(response.p_code);
                    $('#p_name').val(response.p_name);
                    prefCat= response.cat_id;
                    prefSubcat= response.subcat_id;
                    prefBrand= response.brand_id;
                    $('#c_phone2').val(response.c_phone2);
                    $('#c_address').val(response.c_address);
                    $('#description').val(response.description);
                    console.log(response.subcat_id, response.cat_id,response.brand_id );
                    showCat();
                    showSubcat();
                    showBrand();
                }
            });
        }

        function updateData() {
            let id =  $('#id').val();
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: form.serialize(),
                url: "/products/"+id,
                error:function(response){
                    let row ="";
                    $.each(response.responseJSON.errors,function (key, value) {
                        row += "<li>" + value + "</li>";
                    });
                    validateAlert.html(row);
                    validateAlert.show();
                },
                success: function () {
                    dataTable.DataTable().ajax.reload(null, false);
                    modal.modal('hide');
                    clearData();
                }
            });
        }

        function deleteItem(id) {
            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            })

            swalWithBootstrapButtons({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    
                    let url = "products/" + id;
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        success: function() {
                            dataTable.DataTable().ajax.reload(null, false);
                            clearData();
                        }
                    })
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>

@endsection