@extends('layout')

@section('pageTitle')
    - customers accounts
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
                <div class="">
                    <div class="card">
                        <div class="card-header clearfix">
                            <h3 class="card-title float-left">
                                Customers Accounts
                            </h3>

                        </div>
                        <div class="card-body p-3">
                                <table id="customerAcc" class="table table-bordered table-striped text-center mb-3 " style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Phone 1</th>
                                        <th>Phone 2</th>
{{--                                        <th>Transaction</th>--}}
{{--                                        <th>Transaction ID</th>--}}
{{--                                        <th>date</th>--}}
{{--                                        <th>total</th>--}}
{{--                                        <th>Cash</th>--}}
                                        <th>Balance</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>

                                </table>
                        </div>
                    </div>



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

        let customerTable = $('#customerAcc');

        $(document).ready(function () {
             let table = customerTable.DataTable({
                "ajax": {
                    "url": "{{ route('customer_accounts.index') }}",
                    "dataSrc": "customers"
                },
                "columns": [
                    {"data":"id"},
                    {"data":"c_name"},
                    {"data":"c_phone1"},
                    {"data":"c_phone2"},
                    // {"data":"trans_type"},
                    // {"data":"trans_id"},
                    // {"data":"date"},
                    // {"data":"total"},
                    // {"data":"cash"},
                    {"data":"credit"},
                    // {"data":""},
                    {"data":"id", render: function (data, type, row) {
                            return "<a  class='btn btn-info ml-4 p-0 ' " +
                                "href='customer_accounts/"+row.id +"' >details</a>"

                        }},
                ],
                responsive: false,
                scrollY:       1000,
                scrollX:        true,
                scrollCollapse: true,
                dom: "Bfrtip",
                buttons: [
                  //  'excel', 'print','pageLength',
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





    </script>




@endsection
