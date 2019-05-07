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
    <script type="text/javascript" src="{{ asset('js/common.js') }}"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/roboto/v18/roboto.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('iconfont/fontmaterial/material-icons.css') }}">

    <!-- Nicescroll -->
    <script type="text/javascript" src="{{ asset('dist/nicescroll/jquery.nicescroll.min.js') }}"></script>

    <!-- Tooltipster -->
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/tooltipster/tooltipster.bundle.css') }}">
    <script type="text/javascript" src="{{ asset('dist/tooltipster/tooltipster.bundle.js') }}"></script>

    <!-- Tinymce -->
    <script type="text/javascript" src="{{ asset('dist/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/tinymce/jquery.tinymce.min.js') }}"></script>

    <!-- Flag-Sprites -->
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/flagsprites/flags.min.css') }}">

    <script>
        var i18next_options = {};
        i18next_options.lng = document.documentElement.lang;
        i18next_options.resources = {};
        i18next_options.resources[document.documentElement.lang] = {};
        i18next_options.resources[document.documentElement.lang]['translation'] = {!! Helper::readJsonBasedLanguage() !!};
        i18next.init(i18next_options);
    </script>

    @yield('top-javascript')
</head>
<body>
@yield('headbar')
@yield('content')
<!-- Javascript -->
@yield('end-javascript')
</body>
</html>