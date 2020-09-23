@extends('layout')

@section('pageTitle')
    - Suppliers
@endsection

@section('pagecontent')
        <div class="container-fluid">

            <h1 class="display-6">Suppliers</h1>

            <!-- Start Modal -->
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#formModal" onclick="clearData()">
                Add New Supplier
            </button>

            <!-- Modal -->
            <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="formModalLabel">Supplier's Data</h5>
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
                                    <label for="s_name">Supplier's Nmae</label>
                                    <input class="form-control" type="text" name="s_name" id="s_name" value="" >
                                </div>
                                <div class="form-group">
                                    <label for="s_phone1">1st Phone No.</label>
                                    <input class="form-control" type="text" name="s_phone1" id="s_phone1" value="" >
                                </div>
                                <div class="form-group">
                                    <label for="s_phone2">2nd Phone No.</label>
                                    <input class="form-control" type="text" name="s_phone2" id="s_phone2" value="" >
                                </div>
                                <div class="form-group">
                                    <label for="s_address">Address</label>
                                    <input class="form-control" type="text" name="s_address" id="s_address" value="" >
                                </div>
                                <div class="form-group">
                                    <label for="s_email">Email</label>
                                    <input class="form-control" name="s_email"  id="s_email" >
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
                            <th>#</th>
                            <th>Supplier's Nmae</th>
                            <th>1st Phone No.</th>
                            <th>2nd Phone No.</th>
                            <th>Address</th>
                            <th>Email</th>
{{--                            <th>Balance</th>--}}
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

            saveBtn.show();
            updateBtn.hide();
            myId.hide();
            form.trigger("reset");

        }

        $(document).ready(function () {
            let table = dataTable.DataTable({
                "ajax":"{{ route('suppliers.index') }}",
                "columns": [
                    {"data":"id"},
                    {"data":"s_name"},
                    {"data":"s_phone1"},
                    {"data":"s_phone2"},
                    {"data":"s_address"},
                    {"data":"s_email"},
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

                dom: "Bfrtip",
                buttons: [
                    // 'excel', 'print','pageLength',
                    { "extend": 'excel', "text":'<span>Excel</span>',"className": 'btn btn-success btn-xs m-1 rounded'},
                    { "extend": 'pageLength', "text":'<span>pageLength</span>',"className": 'btn btn-primary btn-xs m-1 rounded'},
                ],
                fixedHeader: true,
                "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                processing:true,
                serverSide:false,
            });
            table.on( 'order.dt search.dt', function () {
                table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                });
            }).draw();
        });

        function saveData()     {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: form.serialize(),
                url: "/suppliers",
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
                url: "/suppliers/"+id+"/edit",
                success: function (response) {
                    $('#id').val(response.id);
                    $('#s_name').val(response.s_name);
                    $('#s_phone1').val(response.s_phone1);
                    $('#s_phone2').val(response.s_phone2);
                    $('#s_address').val(response.s_address);
                    $('#s_email').val(response.s_email);

                }
            });
        }

        function updateData() {
            let id =  $('#id').val();
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: form.serialize(),
                url: "/suppliers/"+id,
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
                    url: "/suppliers/" + id,
                    success: function () {
                        dataTable.DataTable().ajax.reload(null, false);
                        clearData();
                    }
                });
            }
        }
    </script>

@endsection
