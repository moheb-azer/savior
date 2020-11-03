@extends('layout')

@section('pageTitle', '- Expenses')

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
                                <h3 class="card-title">Expenses LISTS
                                    <span>
                                     <a href="" class="btn btn-sm btn-primary float-md-right" data-toggle="modal" data-target="#formModal" onclick="clearData()">New Expense</a>
									 <a href="{{ route('expense_items_page') }}" class="btn btn-sm btn-success mr-1">Items</a>
                                    </span>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Description</th>
                                        <th>Amount</th>
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
		<!--payment modal -->
		<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">
							New Expense 	<!-- Modal Title* -->
						</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form>
							<div id="validation" class="alert alert-danger" style="display:none;"></div>
							<div class="form-row">
								<div class="form-group col-md">
                                   	<label for="item_id">Item</label>
                                   	<select class="form-control" type="text" name="item_id" id="item_id">
                                   	</select>
                               	</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-9">
									<label for="description">Description</label>
									<input type="text" class="form-control" name="description">
								</div>
								<div class="form-group col-md">
									<label for="amount">Amount</label>
									<input type="number" name="amount" id="amount" class="form-control pay" placeholder="0.00">
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-success" id="save" onclick="saveData()"><i class="fas fa-sm fa-credit-card"></i>Submit Expense</button>
						<button type="button" class="btn btn-warning" id="update" onclick="updateData()">Edit</button>
					</div>
				</div>
			</div>
		</div>
		<!--/.payment modal -->
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
        let dataTable =$('#example1');
        let modal = $("#formModal");
        let validateAlert =$('#validation').hide();
        let saveBtn =$("#save").show();
        let updateBtn= $("#update").hide();
        let myId = $('.myid').hide();
        let form = $('form');
        let prefCat ="";

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
            prefCat ="";
        }

        $(document).ready(function () {
             dataTable.DataTable({
                "ajax":{
                    "url": "{{ route('expenses.index') }}",
                    "dataSrc": "expenses"
                },
                "columns": [
                    {"data":"item_name"},
                    {"data":"description"},
                    {"data":"amount"},
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
        
        function showItem() {
            $.ajax({
                type : "GET",
                dataType: "json",
                url: "{{ route('show_item') }}",
                success: function(response) { 
                    let items ="";
                    $.each(response, function (key, value) {
                        items += "<option value='";
                        items += value.id ;
                        items += "'";
                        if (prefCat === value.id) {items += "selected";}
                        items += ">";
                        items += value.item_name ;
                        items += "</option>" ;
                    });
                    $('#item_id').html(items);
                }
            });
        }
        showItem();
        
    
        function saveData() {
			console.log(form.serialize())
            $.ajax({
                type: "POST",
                dataType: "json",
                data: form.serialize(),
                url: "/expenses",
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
                    prefCat = response.item_id;
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
                    
                    let url = "subcategories/" + id;
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