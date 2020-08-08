@extends('layout')

@section('pageTitle')
    - Products
@endsection

@section('pagecontent')
        <div class="container-fluid">

            <h1 class="display-6">Products</h1>

            <!-- Start Modal -->
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#formModal" onclick="clearData()">
                Add New Product
            </button>

            <!-- Modal -->
            <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="formModalLabel">Product details</h5>
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

            <div class="row">
                <div class="m-3">
                    <table id="datatable" class="table table-dark table-striped table-hover table-bordered ">
                        <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>Brand</th>
                            <th>Description</th>
{{--                            <th>الكمية</th>--}}
{{--                            <th>سعر البيع</th>--}}
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody id="#cont">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

@endsection

@section('script')
    <script type="text/javascript">

        let dataTable = $('#datatable');
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
        })

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
            let table = dataTable.DataTable({
                "ajax":"{{ route('products.index') }}",
                "columns": [
                    {"data":"id"},
                    {"data":"p_code"},
                    {"data":"p_name"},
                    {"data":"cat_name"},
                    {"data":"subcat_name"},
                    {"data":"brand_name"},
                    {"data":"description"},
                    // {"data":""},
                    {"data":"id", render: function (data, type, row) {
                            return "<button type='button' class='btn ml-4 p-0 ' " +
                                "onclick='editData("+row.id +")' " +
                                "data-toggle=\"modal\" data-target=\"#formModal\"><i class=\"far fa-edit \"></i></button>"
                                + "<button type='button' class='btn ml-2 p-0'" +
                                " onclick='deleteData("+ row.id +")'><i class=\"far fa-trash-alt \"></i></button>";
                        }},
                ],
                //responsive: true,
                scrollY:        true,
                scrollX:        true,
                scrollCollapse: false,
                columnDefs: [ {
                    sortable: false,
                    "class": "index",
                    targets: 0
                } ],
                order: [[ 1, 'asc' ]],
                fixedColumns: false,
                // dom: "Bfrtip",
                // buttons: [
                //     // 'excel', 'print','pageLength',
                //     { "extend": 'excel', "text":'<span>Excel</span>',"className": 'btn btn-success btn-xs m-1 rounded'},
                //     { "extend": 'pageLength', "text":'<span>pageLength</span>',"className": 'btn btn-primary btn-xs m-1 rounded'},
                // ],
                fixedHeader: true,
                "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                processing:true,
                serverSide:false,

            });
            table.on( 'order.dt search.dt', function () {
                table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

        })

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
            // myId.show();
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
                error:function(response,){
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

        function deleteData(id){
            let result = confirm("Want to delete?");
            if (result) {
                $.ajax({
                    type: "DELETE",
                    dataType: "json",
                    url: "/products/" + id,
                    success: function () {
                        dataTable.DataTable().ajax.reload(null, false);
                        clearData();
                    }
                });
            }
        }


    </script>


@endsection
