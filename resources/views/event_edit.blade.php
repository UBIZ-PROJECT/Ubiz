@extends('layouts.main')
@section('title',__("Events Calendar"))
@section('headbar-title', __("Events Calendar"))
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/headbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/air-datepicker/css/datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/fullcalendar-4.0.2/packages/core/main.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/fullcalendar-4.0.2/packages/bootstrap/main.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/fullcalendar-4.0.2/packages/daygrid/main.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/fullcalendar-4.0.2/packages/timegrid/main.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/fullcalendar-4.0.2/packages/list/main.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/event.css') }}">
@endsection
@section('headbar')
    @include('layouts/headbar')
@endsection
@section('content')
    <div class="main-content">
        @include('event_detail')
    </div>
@endsection
@section('end-javascript')
    <script type="text/javascript" src="{{ asset('dist/air-datepicker/js/datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/fullcalendar-4.0.2/packages/core/main.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/fullcalendar-4.0.2/packages/core/locales-all.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/fullcalendar-4.0.2/packages/bootstrap/main.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/fullcalendar-4.0.2/packages/interaction/main.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/fullcalendar-4.0.2/packages/daygrid/main.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/fullcalendar-4.0.2/packages/timegrid/main.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/fullcalendar-4.0.2/packages/list/main.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/event.js') }}"></script>
@endsection