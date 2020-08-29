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
    <link rel="stylesheet" href="{{ asset('/css/home.css') }}">

    <script src="{{ asset('/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('/js/popper.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/datatable/datatables.min.js') }}"></script>

    @stack('css')
    @stack('js')

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark h-auto">
        <a class="navbar-brand" href="/">
            <img src="{{asset('/img/logo1.jpg')}}" class="rounded-circle" width="40" height="40" alt="Savior">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Database
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{route('customers_page')}}">Customers</a>
                        <a class="dropdown-item" href="{{route('suppliers_page')}}">ٍSuppliers</a>
                        <a class="dropdown-item" href="{{route('products_page') }}">Products</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('categories_page')}}">Basic Data</a>
                    </div>
                </li>
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Transcations
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{route('purchase_invioces_page')}}">Purchse Invioces</a>

                    </div>
                </li>

            </ul>
{{--            <form class="form-inline my-2 my-lg-0">--}}
{{--                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">--}}
{{--                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>--}}
{{--            </form>--}}




            <ul class="navbar-nav ml-auto ">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown active">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="Event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>




        </div>
    </nav>

@yield('pagecontent')

@yield('script')
</body>
</html>
