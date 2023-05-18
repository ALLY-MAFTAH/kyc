<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.9, shrink-to-fit=no" />

    <title>{{ config('app.name', 'KYC') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="../../assets/vendors/mdi/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="../../assets/vendors/flag-icon-css/css/flag-icon.min.css" />
    <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="../../assets/vendors/select2/select2.min.css" />
    <link rel="stylesheet" href="../../assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css" />
    <link rel="stylesheet" href="../../assets/css/style.css" />
    <link rel="shortcut icon" href="assets/images/logo.png" />
    @yield('styles')

</head>

<body>
    <div class="container-scroller">
        @include('partials.sidebar')

        <div class="container-fluid page-body-wrapper">

            @include('partials.settings-panel')
            @include('partials.navbar')

            <div class="main-panel">
                <div class="content-wrapper pb-0">
                    
                    @yield('content')
                </div>
                @include('partials.footer')

            </div>
        </div>
    </div>
    <!-- container-scroller -->

    {{-- <script src="assets/vendors/flot/jquery.flot.js"></script> --}}
    {{-- <script src="assets/vendors/flot/jquery.flot.resize.js"></script> --}}
    {{-- <script src="assets/vendors/flot/jquery.flot.categories.js"></script> --}}
    {{-- <script src="assets/vendors/flot/jquery.flot.fillbetween.js"></script> --}}
    {{-- <script src="assets/vendors/flot/jquery.flot.stack.js"></script> --}}
    {{-- <script src="assets/vendors/flot/jquery.flot.pie.js"></script> --}}
    {{-- <script src="assets/vendors/chart.js/Chart.min.js"></script> --}}
    {{-- <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script> --}}
    {{-- <script src="assets/js/dashboard.js"></script> --}}

    {{-- <script src="../../assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/hoverable-collapse.js"></script>
    <script src="../../assets/vendors/select2/select2.min.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <script src="../../assets/js/file-upload.js"></script>
    <script src="../../assets/js/typeahead.js"></script>
    <script src="../../assets/js/select2.js"></script> --}}

    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../../assets/vendors/select2/select2.min.js"></script>
    <script src="../../assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/hoverable-collapse.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <script src="../../assets/js/file-upload.js"></script>
    <script src="../../assets/js/typeahead.js"></script>
    <script src="../../assets/js/select2.js"></script>

    @yield('scripts')
</body>

</html>
