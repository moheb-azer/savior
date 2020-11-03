@extends('layout')

@section('pageTitle')
    - New Purchase Invoce
@endsection

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@section('pagecontent')
    <section class="content m-3">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header clearfix">
                            <h3 class="card-title float-left">
                                Supplier
                            </h3>
                            <!-- Start Modal -->
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#supplier-modal" onclick="clearData()">
                                Add New Supplier
                            </button>
                        </div>
                        <form action="" method="post" id="purchaseForm">
                            @csrf
                            <div class="card-body p-3">
                                <div class="form-group  ">
                                    <label for="search_value">Supplier Name</label>
                                    <input name="supplier_id" id="supplier_id" style="display:none;">
                                    <input name="search_value" id="search_value" class="form-control " placeholder="Search for Supplier Name or Phone Number..." autocomplete="off">
                                    <div class="suggestions-list border rounded mx-3">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="date" >Date</label>
                                    <input type="date" name="date" id="date" class="form-control datepicker-dropdown">
                                </div>
                            </div>

                        </form>

                    </div>


                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa fa-info"></i>
                                Shopping Lists
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <!--
                            <div class="alert alert-danger">
                                No Product Added
                            </div>
                            -->

                            <table id="example2" class="table table-bordered table-striped text-center mb-3 " style="width: 100%;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Qty</th>
                                    <th>Sale Price</th>
                                    <th>Price</th>
                                    <th>Sub Total</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                </tbody>
                            </table>


{{--                            <div class="sub_qty alert alert-info">--}}
{{--                                <p>Quantity : {{ Cart::count() }}</p>--}}
{{--                                <p>Sub Total : {{ Cart::subtotal() }} LE</p>--}}
{{--                            </div>--}}

                            <div class="total alert alert-dark col-6 mt-4">
                                Total : {{ Cart::total() }} LE
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa fa-info"></i>
                                Method of payment
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                                <div class="form-group">
                                    <label for="cash">Cash</label>
                                    <input name="cash" id="cash" type="text" class="form-control pay" value="{{ Cart::total(2,'.','') }}">
                                </div>
                                <div class="form-group">
                                    <label for="credit">Credit</label>
                                    <input name="credit" id="credit" type="text" class="form-control" disabled>
                                </div>
                                <div class="form-group">
                                    <button type="button" id="create_invoice" class="btn btn-success form-control" onclick=""><i class="fas fa-sm fa-credit-card submit-payment-icon"></i>Create Invoice</button>
                                </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title float-left ">
                                Product list
                            </h3>
                            <div class="float-right">
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#product-modal" onclick="clearData()">
                                    Add New Product
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="productTable" class="table table-bordered table-striped text-center">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>code</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <!--                                        <th>Stock</th>-->
                                    <th>Sale Price</th>
                                    <th>Price</th>

                                    <!--                                        <th>Product Code</th>-->
                                    <th>Add To Cart</th>
                                </tr>
                                </thead>

                                <tbody>

                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Supplier Modal -->
    <div class="modal fade" id="supplier-modal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
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
                        <div class="alert alert-danger validation-alert">
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
                    <button type="button" class="btn btn-primary save-data"
                            onclick="saveData('/suppliers')">Save</button>
                    <button type="button" class="btn btn-warning update-data"
                            onclick="updateData()">update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Supplier Modal -->

    <!-- Product Modal -->
    <div class="modal fade" id="product-modal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
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
                        <div class="alert alert-danger validation-alert">
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
                    <button type="button" class="btn btn-primary save-data"
                            onclick="saveData('/products')">Save</button>
                    <button type="button" class="btn btn-warning update-data"
                             onclick="updateData()">update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Product Modal -->


@endsection

@push('js')

    <!-- DataTables -->
    <script src="{{ asset('assets/backend/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <!--SlimScroll -->
    <!--    <script src="{{ asset('assets/backend/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>-->
    <!-- FastClick -->
    <!--    <script src="{{ asset('assets/backend/plugins/fastclick/fastclick.js') }}"></script>-->

    <!-- Sweet Alert Js -->
    <!--    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.1/dist/sweetalert2.all.min.js"></script>-->
@endpush

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name = "csrf-token"]').attr('content')
            }
        })

        let search = $('#search_value');
        let suppliers = $('.suggestions-list');



        // show products in dataTables
        $(document).ready(function() {
            $("#productTable").DataTable({

                "ajax": {
                    "url": "{{ route('purchase_invoice.datatables') }}",
                    "dataSrc": "products"
                },


                "columns": [
                    {
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {"data": "p_code"},
                    {"data": "p_name"},
                    {"data": "cat_name"},
                    {"data": "subcat_name"},
                    {
                        "data": "salePrice", render: function () {
                            return '<input type="number" class="salePrice form-control pay" name="salePrice" placeholder="0.00" style="width:5.4em;" autocomplete="off" required>';
                        }
                    },
                    {
                        "data": "price", render: function () {
                            return '<input type="number" class="price form-control pay" name="price" placeholder="0.00" style="width:5.4em;" autocomplete="off">';
                        }
                    },

                    {
                        "data": "id", render: function (data, type, row) {
                            return '<form class="form-row">' +
                                '<div class="col-7">' +
                                '<input type="hidden" name="id" value="' + row.id + '">' +
                                '<input type="hidden" name="p_name" value="' + row.p_name + '">' +
                                // '<input type="hidden" name="salePrice" value="' + row.salePrice + '">' +
                                // '<input type="hidden" name="price" value="' + row.price + '">' +
                                '<input type="number" class="product_qty form-control" name="qty" placeholder="qty" value="1">' +
                                '</div>' +
                                '<div class="col-1">' +
                                '<button type="submit" class="add_cart btn btn-sm btn-success px-2">' +
                                '<i class="fa fa-cart-plus" aria-hidden="true"></i>' +
                                '</button>' +
                                '</div>' +
                                '</form>';
                        }
                    }
                ],
                "autoWidth": true,
                "responsive":false,
                "scrollX": true,




            });


            $('#example2').DataTable({

                "ajax": {
                    "url": "{{ route('purchase_invoice.datatables') }}",
                    "dataSrc": "items"
                },
                "columns": [
                    {render: function(data,type,row,meta) {
                            return meta.row + 1;
                        }},
                    {"data": "name"},
                    {"data": "qty"},
                    {"data": "salePrice",render: function(data,type,row) {
                            return row.salePrice + " LE";
                        }},
                    {"data": "price",render: function(data,type,row) {
                            return row.price + " LE";
                        }},
                    {"data": "subtotal",render: function(data,type,row) {
                            return row.subtotal + " LE";
                        }},
                    {"data": "id",render: function(data,type,row) {
                            return '<form>'+
                                '<input name="id" value="' + row.rowId + '" hidden>'+
                                '<button class="delete_item btn btn-danger" type="button">'+
                                '<i class="fa fa-trash" aria-hidden="true"></i>'+
                                '</button>'+
                                '</form>';
                        }}
                ],
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "scrollX": true,


            });
        });
        // show products in dataTables




        $(document).ready(function() {
            let total = {{ Cart::total( 2 ,'.','') }};
            let credit =$('#credit').val(0)
            // add products to shopping list
            $(document).on("click",".add_cart",function(e) {
                e.preventDefault();
                let formData = $(this).parents("form").serialize();
                let price = $(this).parents("td").prev().children();
                console.log(price);
                formData += "&price=" + price.val();
                let salePrice = $(this).parents("td").prev().prev().children();
                formData += "&salePrice=" + salePrice.val();
                console.log(formData);

                $.ajax({
                    url: "{{ route('cart.store') }}",
                    data: formData,
                    method: "POST",
                    success: function(response) {
                        console.log((response))
                        $("#example2").DataTable().ajax.reload();
                        $(".sub_qty").html("<p>Quantity : " + response.details.count + "</p>"+
                            "<p>Sub Total : " + response.details.subTotal + " LE</p>");
                        $(".total").html("Total : " + response.details.total + " LE");
                        $(".product_qty").val("1");
                        $('#cash').val(response.details.total);
                        total = response.details.total;
                        credit.val(0);
                    }
                });
            });
            // add products to shopping list

            //delete row from shopping list
            $(document).on("click",".delete_item", function() {
                let rowId = $(this).parent().children('input').val();

                let url = "{{ route('cart.deleterow','') }}" + "/" + rowId;

                $.ajax({
                    url: url,
                    success: function(response) {
                        $("#example2").DataTable().ajax.reload();
                        $(".sub_qty").html("<p>Quantity : " + response.details.count + "</p>"+
                            "<p>Sub Total : " + response.details.subTotal + " LE</p>");
                        $(".total").html("Total : " + response.details.total + " LE");
                        $('#cash').val(response.details.total);
                        total = response.details.total;
                        credit.val(0);
                    }
                });
            });
            // method of payment  1500
            $(document).on('input', '#cash', function () {
                console.log(total);
                let btotal = total.toString().replace(',' , '');
                credit.val((btotal - $('#cash').val()).toFixed(2));
            });
            // method of payment
        });
        //delete row from shopping list

        //suppliers list
        function supplierSuggestions() {
            var searchValue = search.val().trim();

            $.ajax({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET',
                url: '{{ route("purchase_invoice.searchforsupplier") }}',
                data: {'searchValue': searchValue},
                success: function (response) {
					closeSuggestions();
                    if(response.length > 0) {
						suppliers.show();
					}
                    if(response.length > 3) {
                        suppliers.css({'overflow':'auto','height':'215px'});
                    } else if(response.length > 0) {
                        suppliers.css({'overflow':'auto','height':'auto'});
                    } else {
                        suppliers.hide();
                    }

                    let searchResult = "";
                    $.each(response,function (key,value) {

                        let phoneNumbers = value.s_phone1;
                        if(value.s_phone2 !== null) {
                            phoneNumbers += ', ' + value.s_phone2;
                        }

                        searchResult += '<div class="suggestions-list-item border-bottom p-2">'+
                            '<div class="id" style="display:none;">' + value.id + '</div>' +
                            '<div class="name">' + value.s_name + '</div>' +
                            '<div>' + phoneNumbers + '</div>'+
                            '</div>';

                        suppliers.html(searchResult);

                    });
                }
            });
        }

        function closeSuggestions() {
            suppliers.empty();
            suppliers.hide();
        }

        $(document).ready(function() {
            search.on('input',function() {
				closeSuggestions();
                supplierSuggestions();
            });

            $(document).on('click','.suggestions-list-item',function() {
                const supplierId = $(this).children('.id').html();
                const supplierName = $(this).children('.name').html();
                search.attr('placeholder',supplierName);
                $('#s_id').val(supplierId);
                closeSuggestions;
            });

            search.focusout(function() {
                search.val('');


            });

            document.onclick = closeSuggestions;

        });
        //end suppliers list


        // create purchase invoice
        $(document).on("click", "#create_invoice", function(e) {
            e.preventDefault();
            let supplierId = $("#supplier_id").val();
            let date = $('#date').val();
            let cash = $('#cash').val();
            let credit = $('#credit').val();

            $.ajax({
                url: "{{ route('purchase_invoice.create') }}",
                data: {id: supplierId , date: date, cash: cash, credit:credit},
                method: "GET",
                success: function() {
                    $("#example2").DataTable().ajax.reload();
                    search.attr('placeholder','Search for Supplier Name or Phone Number...');
                    $('#s_id').val('');
                    $(".sub_qty").html("<p>Quantity : 0</p>"+
                        "<p>Sub Total : 0.00 LE</p>");
                    $(".total").html("Total : 0.00 LE");
                }
            });

        });

        //end create purchase invoice




    </script>

    <script>
{{--        New Product functions--}}
        let dataTable = $('#productTable');
        let validateAlert =$('.validation-alert').hide();
        let saveBtn =$(".save-data").show();
        let updateBtn= $(".update-data").hide();
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

            validateAlert.hide();
        }


        function showCat() {
            $.ajax({
                type : "GET",
                dataType: "json",
                url: "{{ route('show_cat') }}",
                success: function(response) {
                    let cats ="";
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


        function saveData(url)     {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: form.serialize(),
                url: url,
                error:function(response,){
                    let row ="";
                    $.each(response.responseJSON.errors,function (key, value) {
                        row += "<li>" + value + "</li>";
                    });
                    validateAlert.html(row);
                    validateAlert.show();
                },
                success: function() {
					let modal = '';
                    if(url === '/products') {
                        modal = $('#product-modal');
                        dataTable.DataTable().ajax.reload(null, false);
                    }else {
                        modal = $('#supplier-modal');
                    }
                    modal.modal('hide');
                    clearData();

                }
            });
        }

    </script>
@endsection
