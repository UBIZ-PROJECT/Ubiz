@extends('layouts.main')
@section('title','Trang chủ')
@section('headbar-title','Trang chủ')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/headbar.css') }}">
@endsection
@section('headbar')
@section('headbar-icon')
    <svg class="gb_he" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        <path d="M0 0h24v24H0z" fill="none"/>
    </svg>
@endsection
@include('layouts/headbar')
@endsection
@section('content')
    <div style="text-align: center; margin-top: 50px">HOME PAGE</div>
@endsection