@extends('layouts.main')
@section('title','Login')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
@endsection
@section('content')
    <div id="login-page"></div>
@endsection
@section('end-javascript')
    <script type="text/javascript" src="{{ asset('js/login.js') }}"></script>
@endsection
