<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>AY KHEDMA</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- 1. CORE FRAMEWORK (Bootstrap must be first) -->
<link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">

<!-- 2. FONT AWESOME (icons) -->
<link rel="stylesheet" href="{{ url('assets/css/font-awesome.min.css') }}">

<!-- 3. OTHER ICON SETS (if any) -->
<link rel="stylesheet" href="{{ url('assets/css/icons.css') }}">

<!-- 4. THIRD-PARTY LIBRARIES / PLUGINS -->
<link rel="stylesheet" href="{{ url('assets/css/jquery.timepicker.min.css') }}">
<link rel="stylesheet" href="{{ url('assets/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ url('assets/css/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ url('assets/css/toastr.min.css') }}">
        <link rel="stylesheet" href="/assets/css/style.css" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script>
            window.App = {'locale' : '{{ app()->getLocale() }}'};
        </script>

    </head>

    <body>
        <!-- Start Nave -->
        @include('web.navbar')
        <!-- End Nave -->
        <div id="app">
            @yield('content')
        </div>

        <!-- Start Footer -->
        <footer>

            <div class="container">
                <div class="row">
                    <div class="col-lg-4 text-sm-center">
                        <img class="logolg" src="/assets/img/Icons/logo_larg.png">
                    </div>
                </div>
            </div>
        </footer>
        <!-- End Footer -->
        @routes
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="/assets/js/web.app.js"></script>
    </body>

</html>
