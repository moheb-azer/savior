@extends('layout')

@section('pageTitle')
    - Subcategories
@endsection

@section('pagecontent')
        <div class="container-fluid">

            <a class="btn btn-success mt-2" href="{{route('categories_page')}}">Categories</a>
            <a class="btn btn-success mt-2" href="{{route('brands_page')}}">Brands</a>


            <h1 class="display-6">Subcategories</h1>

            <!-- Start Modal -->
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#formModal" onclick="clearData()">
                Add New Subcategory
            </button>

            <!-- Modal -->
            <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
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
                                    <label for="cat_id">Category</label>
                                    <select class="form-control" type="text" name="cat_id" id="cat_id">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="subcat_name">Subcategory Name</label>
                                    <input class="form-control" type="text" name="subcat_name" id="subcat_name" value="" >
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearData()">Close</button>
                            <button type="button" class="btn btn-primary"
                                    id="save" onclick="saveData()">Save</button>
                            <button type="button" class="btn btn-warning"
                                    id="update" onclick="updateData()"
                                    data-toggle="modal" data-target="#formModal">update</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->

            <div class="row">
                <div class="col-auto">
                    <table id="datatable" class="table table-dark table-striped table-hover table-bordered ">
                        <thead class="thead-light">
                        <tr>
                            <th>Id</th>
                            <th>Subcategory</th>
                            <th>Category</th>
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

        let dataTable =$('#datatable');
        let modat = $("#formModal");
        let validateAlert =$('#validation').hide();
        let saveBtn =$("#save").show();
        let updateBtn= $("#update").hide();
        let myId = $('.myid').hide();
        let form = $('.form');
        let prefCat ="";



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name = "csrf-token"]').attr('content')
            }
        })

        function clearData() {
            validateAlert.hide();
            saveBtn.show();
            updateBtn.hide();
            myId.hide();
            form.trigger("reset");
            prefCat ="";

        }

        $(document).ready(function () {
            dataTable.DataTable({
                "ajax":"{{ route('subcategories.index') }}",
                "columns": [
                    {"data":"id"},
                    {"data":"subcat_name"},
                    {"data":"cat_name"},
                    {"data":"id", render: function (data, type, row, ) {
                            return "<button type='button' class='btn ml-4 p-0 ' " +
                                "onclick='editData("+row.id +")' " +
                                "data-toggle=\"modal\" data-target=\"#formModal\"><i class=\"far fa-edit \"></i></button>" + "<button type='button' class='btn ml-2 p-0'" +
                                " onclick='deleteData("+ row.id +")'><i class=\"far fa-trash-alt \"></i></button>";
                    }},
                ],
                //responsive: true,
                scrollY:        300,
                scrollX:        true,
                scrollCollapse: false,
                columnDefs: [ {
                    sortable: false,
                    "class": "index",
                    targets: 0
                } ],
                //order: [[ 1, 'asc' ]],
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
            // table.on( 'order.dt search.dt', function () {
            //     table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            //         cell.innerHTML = i+1;
            //     } );
            // } ).draw();
        });


        function showCat() {
            $.ajax({
                type : "GET",
                dataType: "json",
                url: "{{ route('show_cat') }}",
                success: function(response) {
                    console.log(response);
                    let cats ="";
                    $.each(response, function (key, value) {
                        cats += "<option value='";
                        cats += value.id ;
                        cats += "'";
                        if (prefCat === value.id) {cats += "selected";}
                        cats += ">";
                        cats += value.cat_name ;
                        cats += "</option>" ;
                    });
                    $('#cat_id').html(cats);
                }
            });
        }
        showCat();

        function saveData()     {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: form.serialize(),
                url: "/subcategories",
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
                url: "/subcategories/"+id+"/edit",
                success: function (response) {
                    $('#id').val(response.id);
                    $('#subcat_name').val(response.subcat_name);
                    prefCat = response.cat_id;
                    showCat();
                }
            });
        }

        function updateData() {
            let id =  $('#id').val();
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: form.serialize(),
                url: "/subcategories/"+id,
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
            $.ajax({
                type: "DELETE",
                dataType: "json",
                url: "/subcategories/"+id,
                success: function () {
                    dataTable.DataTable().ajax.reload(null, false);
                    clearData();
                }
            });
        }


    </script>

@endsection
