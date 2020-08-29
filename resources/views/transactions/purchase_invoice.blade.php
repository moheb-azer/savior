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
                        <form action="" method="post">
                            @csrf
                            <div class="card-header">
                                <h3 class="card-title">
                                    Supplier
                                    <span>
                                            <button type="submit" id="create_invoice" class="btn btn-sm btn-info float-md-right ml-3">Create Invoice</button>
                                            <a href="" class="btn btn-sm btn-primary float-md-right">Add New</a>
                                        </span>
                                </h3>

                            </div>
                            <div class="card-body p-3">
                                <div class="form-group mb-0">
                                    <label for="search_value">Supplier Name</label>
                                    <input name="s_id" id="s_id" style="display:none;">
                                    <input name="search_value" id="search_value" class="form-control" placeholder="Search for Supplier Name or Phone Number..." autocomplete="off">
                                </div>
                                <div class="supplier_list border rounded mx-3 dropdown-menu">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="date" >Date</label>
                                <input type="date" name="date" id="date">
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

                            <div class="total alert alert-success">
                                Total : {{ Cart::total() }} LE
                            </div>
                            <div class="form-group">
                                <h1>Method of payment</h1>
                                <label for="cash">cash</label>
                                <input name="cash" id="cash" type="text" class="form-control" value="{{ Cart::total(2,'.','') }}">
                                <label for="credit">credit</label>
                                <input name="credit" id="credit" type="text" class="form-control" disabled>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>

                </div>

                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                POS
                                <span>
                                    <a href="" class="btn btn-sm btn-primary float-md-right">Add New</a>
                                </span>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped text-center">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>code</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <!--                                        <th>Stock</th>-->
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
        let suppliers = $('.supplier_list');



        // show products in dataTables
        $(document).ready(function() {
            $("#example1").DataTable({
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
                        "data": "price", render: function () {
//                        row.price = 5;
                            return '<input type="text" class="price form-control" name="qty" placeholder="0.00 LE" autocomplete="off">';
                        }
                    },
                    {
                        "data": "id", render: function (data, type, row) {
                            return '<form class="form-row align-items-center">' +
                                '<div class="col-7 my-1">' +
                                '<input type="hidden" name="id" value="' + row.id + '">' +
                                '<input type="hidden" name="p_name" value="' + row.p_name + '">' +
                                '<input type="hidden" name="price" value="' + row.price + '">' +
                                '<input type="number" class="product_qty form-control" name="qty" placeholder="qty" value="1">' +
                                '</div>' +
                                '<div class="col-1 my-1">' +
                                '<button type="submit" class="add_cart btn btn-sm btn-success px-2">' +
                                '<i class="fa fa-cart-plus" aria-hidden="true"></i>' +
                                '</button>' +
                                '</div>' +
                                '</form>';
                        }
                    }
                ],
                "autoWidth": false,
                "responsive":false,
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
                "autoWidth": false
            });
        })
        // show products in dataTables




        $(document).ready(function() {
            let total = {{ Cart::total( 2 ,'.','') }}
            // add products to shopping list
            $(document).on("click",".add_cart",function(e) {
                e.preventDefault();
                let formData = $(this).parents("form").serialize();
                let price = $(this).parents("td").prev().children();
                formData += "&price=" + price.val();
                console.log(formData);

                $.ajax({
                    url: "{{ route('cart.store') }}",
                    data: formData,
                    method: "POST",
                    success: function(response) {
                        $("#example2").DataTable().ajax.reload();
                        $(".sub_qty").html("<p>Quantity : " + response.details.count + "</p>"+
                            "<p>Sub Total : " + response.details.subTotal + " LE</p>");
                        $(".total").html("Total : " + response.details.total + " LE");
                        $(".product_qty").val("1");
                        price.val('');
                        $('#cash').val(response.details.total);
                        total = response.details.total;
                        $('#credit').val('');
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
                        $('#credit').val('');
                    }
                });
            });
            // method of payment
            $(document).on('change', '#cash', function () {
                let btotal = total.replace(',' , '');
                $('#credit').val( btotal - $('#cash').val());
            })
            // method of payment
        });
        //delete row from shopping list

        //suppliers list
        function supplierSuggestions() {
            suppliers.hide();
            let searchValue = $("#search_value").val().trim();

            $.ajax({
                method: 'GET',
                url: '{{ route("purchase_invoice.searchforsupplier") }}',
                data: {'searchValue': searchValue},
                success: function (response) {

                    suppliers.empty();
                    suppliers.show();

                    if(response.length > 3) {
                        suppliers.css({'overflow':'auto','height':'215px'});
                    } else{
                        suppliers.css({'overflow':'auto','height':'auto'});
                    }

                    let searchResult = "";
                    $.each(response,function (key,value) {

                        let phoneNumbers = value.s_phone1;
                        if(value.s_phone2 !== null) {
                            phoneNumbers += ', ' + value.s_phone2;
                        }

                        searchResult += '<div class="supplier_list_item border-bottom p-2">'+
                            '<div class="id" style="display:none;">' + value.id + '</div>' +
                            '<div class="name dropdown-item">' + value.s_name + '<br>' + phoneNumbers + '</div>' +
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
                supplierSuggestions();
            });

            $(document).on('click','.supplier_list_item',function() {
                const supplierId = $(this).children('.id').html();
                const supplierName = $(this).children('.name').html();
                //search.val('');
                search.attr('placeholder',supplierName);
                $('#s_id').val(supplierId);
                closeSuggestions();
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
            let supplierId = $("#s_id").val();
            let date = $('#date').val();
            let cash = $('#cash').val();
            let credit = $('#credit').val();

            $.ajax({
                url: "{{ route('purchase_invoice.store') }}",
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
@endsection
