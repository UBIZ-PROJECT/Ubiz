<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    @yield('style')
    <!-- Javascript -->
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

    <!-- Nicescroll -->
    <script type="text/javascript" src="{{ asset('dist/nicescroll/jquery.nicescroll.min.js') }}"></script>

    <!-- Tooltipster -->
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/tooltipster/tooltipster.bundle.css') }}">
    <script type="text/javascript" src="{{ asset('dist/tooltipster/tooltipster.bundle.js') }}"></script>

    @yield('top-javascript')
</head>
<body>
@yield('sidebar')
@yield('content')
<!-- Javascript -->
@yield('end-javascript')
</body>
</html>