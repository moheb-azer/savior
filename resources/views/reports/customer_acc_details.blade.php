@extends('layout')

@section('pageTitle')
    - customer account details
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
                                Customer Account Details
                            </h3>

                        </div>
                        <div class="card-body p-3">
                            <div>
                                <label>Customter Name: {{$customer->c_name}} </label>
                                <br>
                                <label class="m-4">Phone 1: {{$customer->c_phone1}} </label>
                                <label class="m-4">Phone 2: {{$customer->c_phone2}} </label>
                            </div>
                            <table id="customerAcc" class="table table-bordered table-striped text-center mb-3 " style="width: 100%;">
                                <thead>
                                <tr>
                                    <th>ID</th>
{{--                                        <th>Customter Name</th>--}}
{{--                                        <th>Phone 1</th>--}}
{{--                                        <th>Phone 2</th>--}}
                                    <th>Transaction</th>
                                    <th>Transaction ID</th>
                                    <th>date</th>
                                    <th>total</th>
                                    <th>Cash</th>
                                    <th>Balance</th>
{{--                                        <th>Actions</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($accounts as $account)
                                        <tr>
                                            <td>{{$account->id}}</td>
                                            <td>{{$account->trans_type}}</td>
                                            <td>{{$account->trans_id}}</td>
                                            <td>{{$account->date}}</td>
                                            <td>{{$account->total}}</td>
                                            <td>{{$account->cash}}</td>
                                            <td>{{$account->credit}}</td>
                                        </tr>
                                    @endforeach
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






    </script>




@endsection
