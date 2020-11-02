<!doctype html>
<html lang="ar" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name') }}  @yield('pageTitle')</title>

    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/fontawesome/css/all.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@700&family=Markazi+Text:wght@900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/backend.css') }}">

    <script src="{{ asset('/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('/js/popper.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/backend.js') }}"></script>

    @stack('css')
    @stack('js')

</head>
<body>
    <nav class="main-header navbar navbar-expand  bg-secondary border-bottom m-0">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item d-none d-sm-inline-block">
			<a href="{{ route('home_page') }}" class="nav-link">Home</a>
		<li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Database
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{route('customers_page')}}" style="color:black !important;" style="color:black !important;">Customers</a>
                <a class="dropdown-item" href="{{route('suppliers_page')}}" style="color:black !important;">Suppliers</a>
                <a class="dropdown-item" href="{{route('products_page') }}" style="color:black !important;">Products</a>
{{--                <div class="dropdown-divider"></div>--}}
{{--                <a class="dropdown-item" href="{{route('categories_page')}}" style="color:black !important;">Basic Data</a>--}}
            </div>
        </li>
        <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Transcations
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{route('purchase_invoice_page')}}" style="color:black !important;">Purchase Invioces</a>
                <a class="dropdown-item" href="{{route('sale_invioces_page')}}" style="color:black !important;">Sale Invioces</a>
                <a class="dropdown-item" href="{{route('collections_page')}}" style="color:black !important;">Collections</a>
                <a class="dropdown-item" href="{{route('payments_page')}}" style="color:black !important;">Payments</a>
                <a class="dropdown-item" href="{{route('expenses_page')}}" style="color:black !important;">Expenses</a>
            </div>
        </li>
        <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Reports
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{route('customer_acc_page')}}" style="color:black !important;">Customer Accounts</a>
            </div>
        </li>
	</ul>

	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">
		<!-- Profile Dropdown Menu -->
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#">
				<i class="fa fa-th-large"></i>

			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<span class="dropdown-item dropdown-header">Profile Menu</span>
				<div class="dropdown-divider"></div>
{{--
				<a href="#" class="dropdown-item" style="color:black !important;">
					<i class="fa fa-envelope mr-2"></i> Profile
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item" style="color:black !important;">
					<i class="fa fa-users mr-2"></i> Settings
				</a>
				<div class="dropdown-divider"></div>
--}}
				<a class="dropdown-item" href="{{ route('logout') }}"
				    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" style="color:black !important;">
					<i class="fa fa-file mr-2"></i> Logout
				</a>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					@csrf
				</form>

			</div>
		</li>

	</ul>
</nav>

@yield('pagecontent')

@yield('script')
</body>
</html>
