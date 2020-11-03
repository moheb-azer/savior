@extends('layout')

@section('pageTitle', '- Suppliers')

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
                                <h3 class="card-title">SUPPLIERS LISTS
                                    <span>
                                     <a href="" class="btn btn-sm btn-primary float-md-right" data-toggle="modal" data-target="#formModal" onclick="clearData()">Add New</a>
                                    </span>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Supplier Name</th>
                                        <th>Phone1</th>
                                        <th>Phone2</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Supplier Name</th>
                                        <th>Phone1</th>
                                        <th>Phone2</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Action</th>
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
                                   <label for="s_name">Supplier's Name</label>
                                   <input class="form-control" type="text" name="s_name" id="s_name" value="" required>
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
        let validateAlert = $('#validation').hide();
        let saveBtn = $("#save").show();
        let updateBtn= $("#update").hide();
        let myId = $('.myid').hide();
        let form = $('.form');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name = "csrf-token"]').attr('content')
            }
        });

        function clearData() {
            validateAlert.hide();
            saveBtn.show();
            updateBtn.hide();
            myId.hide();
            form.trigger("reset");

        }

        $(document).ready(function () {
             dataTable.DataTable({
                "ajax":{
                    "url": "{{ route('suppliers.index') }}",
                    "dataSrc": "suppliers"
                },
                "columns": [
                    {"data":"id"},
                    {"data":"s_name"},
                    {"data":"s_phone1"},
                    {"data":"s_phone2"},
                    {"data":"s_address"},
                    {"data":"s_email"},
                    {"data":"id", render: function (data, type, row) {
                            return  '<button class="btn btn-info m-1" data-toggle="modal" data-target="#formModal" onclick="editData(' + row.id + ")" + '">'+
                                    '<i class="fas fa-edit" aria-hidden="true"></i></button>'+
                                    '<button class="btn btn-danger m-1" type="button" onclick="deleteItem(' + row.id + ")" + '">'+
                                    '<i class="fa fa-trash" aria-hidden="true"></i></button>'+
                                    '<form id="delete-form-' + row.id + '" action="" method="post" style="display:none;"></form>';
                        }},
                ],
                "autoWidth": false
            });
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
//                    document.getElementById('delete-form-'+id).submit();
                    let url = "suppliers/" + id;
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