@extends('layout')

@section('pageTitle')
    - Categories
@endsection

@section('pagecontent')
        <div class="container-fluid">

            <a class="btn btn-success mt-2" href="{{route('subcategories_page')}}">Subcategories</a>
            <a class="btn btn-success mt-2" href="{{route('brands_page')}}">Brands</a>


            <h1 class="display-6">Categories</h1>

            <!-- Start Modal -->
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#formModal" onclick="clearData()">
                Add New Category
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
                                    <label for="cat_name">Category Name</label>
                                    <input class="form-control" type="text" name="cat_name" id="cat_name" value="" >
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
                <div class="col-auto">
                    <table id="datatable" class="table table-dark table-striped table-hover table-bordered ">
                        <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
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

        }

        $(document).ready(function () {
            dataTable.DataTable({
                "ajax":"{{ route('categories.index') }}",
                "columns": [
                    {"data":"id"},
                    {"data":"cat_name"},
                    {"data":"id", render: function (data, type, row) {
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
        });

        function saveData()     {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: form.serialize(),
                url: "/categories",
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
                url: "/categories/"+id+"/edit",
                success: function (response) {
                    $('#id').val(response.id);
                    $('#cat_name').val(response.cat_name);

                }
            });
        }

        function updateData() {
            let id =  $('#id').val();
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: form.serialize(),
                url: "/categories/"+id,
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
                url: "/categories/"+id,
                success: function () {
                    dataTable.DataTable().ajax.reload(null, false);
                    clearData();
                }
            });
        }


    </script>

@endsection
