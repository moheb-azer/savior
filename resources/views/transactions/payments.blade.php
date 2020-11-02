<!--

 ********************************
 ******* Payments Page 
 ********************************

 // Notes
 ** All Comments Has Asterisk Is Required
-->

@extends('layout')

@section('pageTitle', '- Payments') {{-- Page Title* --}}

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
                                <h3 class="card-title">
									Payments 	<!-- Header Title* -->
                                    <span>
                                     <a href="" class="btn btn-sm btn-primary float-md-right" data-toggle="modal" data-target="#formModal" onclick="clearData()">New Payment</a>
                                    </span>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>Supplier Name</th>
                                        <th>Cash</th>
                                        <th>Balance</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Supplier Name</th>
                                        <th>Cash</th>
                                        <th>Balance</th>
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

		<!--payment modal -->
		
			<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">
								New Payment 	<!-- Modal Title* -->
							</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="" method="post">
								<ul id="validation" class="alert alert-danger" style="display:none;"></ul>
								<div class="row">
									<div class="col-12">
										<p class="text-info float-right mb-3" id="supplier-balance">Balance : <span>0.00</span> LE</p>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-9">
											<label for="search_value">Supplier Name</label>
											<input type="text" name="s_id" id="s_id" style="display:none;">
											<input type="text" class="form-control" name="search_value" id="search_value" data-text="" placeholder="Search for Supplier Name or Phone Number..." autocomplete="off">
											<div class="suggestions-list mx-2"></div>
									</div>
									<div class="form-group col-md-3">
										<label for="pay">Pay</label>
										<input type="number" name="pay" id="pay" class="form-control pay" placeholder="0.00" required>
									</div>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-success" id="save" onclick="saveData()"><i class="fas fa-sm fa-credit-card"></i>Submit Payment</button>
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
        let dataTable = $('#example1');
        let modal = $("#formModal");
        let validateAlert = $('#validation');
		let search = $('#search_value');
        let saveBtn = $("#save");
        let updateBtn= $("#update");
        let form = $('form');
		let balance = $('#supplier-balance span');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name = "csrf-token"]').attr('content')
            }
        });

        function clearData() {
			form.trigger("reset");
			search.removeAttr('disabled');
			balance.html('0.00');
			$('#search_value').attr('placeholder', 'Search for Supplier Name or Phone Number...');
            validateAlert.hide();
            saveBtn.show();
            updateBtn.hide();
        }

        $(document).ready(function () {
             dataTable.DataTable({
                "ajax":{
                   	"url": "{{ route('payments.index') }}", 			//Route* 
                    "dataSrc": "payments"			  	//Object Name*
                },
                "columns": [
                    {"data":"s_name"},  	//Name col1 Of Database*
                    {"data":"cash"},	//Name col2 Of Database*
                    {"data":"balance"},	//Name col3 Of Database*
                    {"data":"id", render: function (data, type, row) { 		//Action Column
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
			let formData = form.serialize() + '&balance=' + balance.html()
            $.ajax({
                type: "POST",
                dataType: "json",
                data: formData,
                url: "/payments",	//URL*
				success: function() {
                    dataTable.DataTable().ajax.reload(null, false);
                    modal.modal('hide');
                    clearData();

                },
                error: function(response){
                    let row ="";
					row += "<ul>"
                    $.each(response.responseJSON.errors,function (key, value) {
                         row += "<li>" + value + "</li>";
                    });
					row += "</ul>";
                    validateAlert.html(row);
                    validateAlert.show();
                }
            });
        }

        function editData(id) {
            saveBtn.hide();
            updateBtn.show();
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/payments/"+id+"/edit", 	//URL*
                success: function (response) {
					//@response -> User Data Array.
					//**
					//Set Old User Data For Inputs Value
					const supplierBalance = response.credit === null ? '0.00' : response.credit;
					$('#search_value').attr('disabled', '');
					balance.html(supplierBalance + '.00');
					$('#s_id').val(response.supplier_id);
					$('#search_value').attr('placeholder',response.s_name);
					$('#pay').val(response.cash);
                }
            });
        }

        function updateData() {
            let id =  $('#id').val();
            $.ajax({
                type: "PUT",
                dataType: "json",
                data: form.serialize(),
                url: "/URL/"+id,	//URL*
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

                    let url = "URL/" + id;	//URL*
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
		
		function supplierSuggestions() {
        	$('.suggestions-list').hide();
        	var searchValue = $("#search_value").val().trim();
        	    
        	$.ajax({
        	    headers:{
        	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        	    },
        	    method: 'GET',
        	    url: '{{ route("purchase_invoice.searchforsupplier") }}',
        	    data: {'searchValue': searchValue},
        	    success: function (response) {
        	                
        	        $('.suggestions-list').empty();
        	        $('.suggestions-list').show();
        	                
        	        if(response.length > 3) {
        	            $('.suggestions-list').css({'overflow':'auto','height':'215px'});
        	        } else if(response.length > 0) {
        	            $('.suggestions-list').css({'overflow':'auto','height':'auto'});
        	        } else {
						$('.suggestions-list').hide();
					}
        	                    
        	        let searchResult = "";
        	        $.each(response,function (key,value) {
        	            
        	            let phoneNumbers = value.s_phone1;
        	            if(value.s_phone2 !== null) {
        	                phoneNumbers += ', ' + value.s_phone2;
        	            }
        	                    
        	            searchResult += '<div class="suggestions-list-item border-bottom p-2">'+
        	                            '<div class="id" style="display:none;">' + value.id + '</div>' +
        	                            '<div class="supplier-credit" style="display:none;">' + value.credit + '</div>' +
        	                            '<div class="name">' + value.s_name + '</div>' +
        	                            '<div>' + phoneNumbers + '</div>'+
        	                            '</div>';
        	                    
        	            $('.suggestions-list').html(searchResult);
        	                    
        	        });    
        	    } 
        	}); 
			}
		
			function closeSuggestions() {
				$('.suggestions-list').empty();
				$('.suggestions-list').hide();
			}
		
			$(document).ready(function() {
				$('#search_value').on('input',function() {
					supplierSuggestions();
				});

				$(document).on('click','.suggestions-list-item',function() {
					const supplierId = $(this).children('.id').html();
					const supplierName = $(this).children('.name').html();
					const credit = $(this).children('.supplier-credit').html();
					const supplierBalance = credit === 'null' ? '0.00' : credit + '.00';
					$('#search_value').attr('placeholder',supplierName);
					$('#s_id').val(supplierId);
					balance.html(supplierBalance);
					closeSuggestions;
				});

				$('#search_value').focusout(function() {
					$('#search_value').val('');
				});

				document.onclick = closeSuggestions;

			});
    </script>

@endsection