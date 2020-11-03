@extends('layout')

@section('pageTitle')
    - New Sale Invoce
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
                                Customer

                            </h3>

                        </div>
                        <form action="" method="post" id="purchaseForm">
                            @csrf
                            <div class="card-body p-3">
                                <div class="form-group  ">
                                    <label for="search_value">Customer Name</label>
                                    <input name="customer_id" id="customer_id" style="display:none;">
                                    <input name="search_value" id="search_value" class="form-control " placeholder="Search for Customer Name or Phone Number..." autocomplete="off">

                                </div>
                                <div class="customer_list border rounded mx-3  mt-0 ">
                                </div>
                                <div class="form-group">
                                    <label for="date" >Date</label>
                                    <input type="date" name="date" id="date" class="form-control datepicker-dropdown">
                                </div>
                                <div>
                                    <button type="submit" id="create_invoice" class="btn btn-info float-md-right mb-2 form-control" form="purchaseForm">Create Invoice</button>

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

                            <table id="example3" class="table table-bordered table-striped text-center mb-3 " style="width: 100%;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Sale Price</th>
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
                                Total : {{ Cart::instance('sale')->total() }} LE
                            </div>
                            <div class="form-group">
                                <h1>Method of payment</h1>
                                <label for="cash">cash</label>
                                <input name="cash" id="cash" type="text" class="form-control" value="{{ Cart::instance('sale')->total(2,'.','') }}">
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
                            <h3 class="card-title float-left ">
                                Product list
                            </h3>


                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="productTable" class="table table-bordered table-striped text-center">
                                <thead>
                                <tr>
{{--                                    <th>#</th>--}}
                                    <th>code</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <!--                                      <th>Stock</th>-->
                                    <th>Sale Price</th>
                                    <!--                                        <th>Product Code</th>-->
                                    <th>Add To Cart</th>
                                </tr>
                                </thead>

                                <tbody>

                                </tbody>
                                <tfoot>
                                <tr>
{{--                                    <th>#</th>--}}
                                    <th>code</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <!--                                      <th>Stock</th>-->
                                    <th>Sale Price</th>
                                    <!--                                        <th>Product Code</th>-->
                                    <th>Add To Cart</th>
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
        let customers = $('.customer_list');



        // show products in dataTables
        $(document).ready(function() {
            // product list table
            $("#productTable").DataTable({

                "ajax": {
                    "url": "{{ route('sale_invoice.datatables') }}",
                    "dataSrc": "products"
                },


                "columns": [
                    // {
                    //     render: function (data, type, row, meta) {
                    //         return meta.row + 1;
                    //     }
                    //},
                    {"data": "p_code"},
                    {"data": "p_name"},
                    {"data": "cat_name"},
                    {"data": "subcat_name"},
                    {"data": "salePrice"},


                    {
                        "data": "id", render: function (data, type, row) {
                            return '<form class="form-row align-items-center">' +
                                '<div class="col-7 my-1">' +
                                '<input type="hidden" name="id" value="' + row.id + '">' +
                                '<input type="hidden" name="p_name" value="' + row.p_name + '">' +
                                '<input type="hidden" name="salePrice" value="' + row.salePrice + '">' +
                                '<input type="number" max="'+ row.balance_units +'" class="product_qty form-control" name="qty" placeholder="qty" value="1">' +
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
                "responsive": false,
                "scrollX": true,
                "retrieve": true,


                initComplete: function () {
                    this.api().columns().every( function () {
                        let column = this;
                        let select = $('<select><option value=""></option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                let val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                }
            });


//invoice product table
            $('#example3').DataTable({

                "ajax": {
                    "url": "{{ route('sale_invoice.datatables') }}",
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
                    // {"data": "sarice",render: function(data,type,row) {
                    //         return row.price + " LE";
                    //     }},
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
                "autoWidth": false,
                "scrollX": true,


            });
        });
        // show products in dataTables




        $(document).ready(function() {
            let total = {{ Cart::instance('sale')->total( 2 ,'.','') }};
            let credit = $('#credit').val(0);
                // add products to shopping list
                $(document).on("click",".add_cart",function(e) {
                    e.preventDefault();
                    let formData = $(this).parents("form").serialize();
                    // let salePrice = $(this).parents("td").prev().children();
                    // console.log(formData);
                    // formData += "&salePrice=" + salePrice.val();

                    console.log(formData);

                    $.ajax({
                        url: "{{ route('cart_sale.store') }}",
                        data: formData,
                        method: "POST",
                        success: function(response) {

                            $("#example3").DataTable().ajax.reload();
                            $(".sub_qty").html("<p>Quantity : " + response.details.count + "</p>"+
                                "<p>Sub Total : " + response.details.subTotal + " LE</p>");
                            $(".total").html("Total : " + response.details.total + " LE");
                            $(".product_qty").val("1");
                            // salePrice.val('');
                            $('#cash').val(response.details.total);
                            total = response.details.total;
                            credit.val('0');
                        }
                    });
                });
            // add products to shopping list

            //delete row from shopping list
            $(document).on("click",".delete_item", function() {
                let rowId = $(this).parent().children('input').val();

                let url = "{{ route('cart_sale.delete','') }}" + "/" + rowId;

                $.ajax({
                    url: url,
                    success: function(response) {
                        $("#example3").DataTable().ajax.reload();
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
            $(document).on('change', '#cash', function () {
                console.log(total);
                let btotal = total.replace(',' , '');
                credit.val( btotal - $('#cash').val());
            });
            // method of payment
        });
        //delete row from shopping list

        //customers list
        function customerSuggestions() {
            customers.hide();
            let searchValue = $("#search_value").val().trim();

            $.ajax({
                method: 'GET',
                url: '{{ route("sale_invoice.searchforCustomer") }}',
                data: {'searchValue': searchValue},
                success: function (response) {

                    customers.empty();
                    customers.show();

                    if(response.length > 3) {
                        customers.css({'overflow':'auto','height':'215px'});
                    } else{
                        customers.css({'overflow':'auto','height':'auto'});
                    }

                    let searchResult = "";
                    $.each(response,function (key,value) {

                        let phoneNumbers = value.c_phone1;
                        if(value.s_phone2 !== null) {
                            phoneNumbers += ', ' + value.c_phone2;
                        }

                        searchResult += '<div class="customer_list_item border-bottom p-2">'+
                            '<div class="id" style="display:none;">' + value.id + '</div>' +
                            '<div class="name dropdown-item">' + value.c_name + ', '+ phoneNumbers + '</div>' +
                            '</div>';

                        customers.html(searchResult);

                    });
                }
            });
        }
        function closeSuggestions() {
            customers.empty();
            customers.hide();
        }


        $(document).ready(function() {
            search.on('input',function() {
                customerSuggestions();
            });

            $(document).on('click','.customer_list_item',function() {
                const customerId = $(this).children('.id').html();
                const customerName = $(this).children('.name').html();
                //search.val('');
                search.attr('placeholder',customerName);
                $('#customer_id').val(customerId);
                closeSuggestions();
            });

            search.focusout(function() {
                search.val('');

            });

            document.onclick = closeSuggestions;

        });
        //end customers list



        // create Sale invoice
        $(document).on("click", "#create_invoice", function(e) {
            e.preventDefault();
            let customerId = $("#customer_id").val();
            let date = $('#date').val();
            let cash = $('#cash').val();
            let credit = $('#credit').val();

            $.ajax({
                url: "{{ route('sale_invoices.create') }}",
                data: {id: customerId , date: date, cash: cash, credit:credit},
                method: "GET",
                success: function() {
                    $("#example3").DataTable().ajax.reload();
                    $("#productTable").DataTable().ajax.reload();
                    search.attr('placeholder','Search for customer Name or Phone Number...');
                    $('#customer_id').val('');
                    $(".sub_qty").html("<p>Quantity : 0</p>"+
                        "<p>Sub Total : 0.00 LE</p>");
                    $(".total").html("Total : 0.00 LE");
                }
            });

        });

        //end create Sale invoice




    </script>


@endsection
