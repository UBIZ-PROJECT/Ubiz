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
    <div class="mvo">
        <div class="xvo">
            <div class="bvo">
                <ul class="cto">
                    <li class="who">
                        <a class="ruo" role="button" href="/users">
                            <div class="pto">
                                <img src="{{asset('images/app_bg.png')}}">
                                <div class="zro">
                                    <div class="rco">
                                        <div class="kko">{{ __("Employee") }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="who">
                        <a class="ruo" role="button" href="/customers">
                            <div class="pto">
                                <img src="{{asset('images/app_bg.png')}}">
                                <div class="zro">
                                    <div class="rco">
                                        <div class="kko">{{ __("Customer") }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="who">
                        <a class="ruo" role="button" href="/suppliers">
                            <div class="pto">
                                <img src="{{asset('images/app_bg.png')}}">
                                <div class="zro">
                                    <div class="rco">
                                        <div class="kko">{{ __("Supplier") }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="who">
                        <a class="ruo" role="button" href="/currency">
                            <div class="pto">
                                <img src="{{asset('images/app_bg.png')}}">
                                <div class="zro">
                                    <div class="rco">
                                        <div class="kko">{{ __("Currency") }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="who">
                        <a class="ruo" role="button" href="/departments">
                            <div class="pto">
                                <img src="{{asset('images/app_bg.png')}}">
                                <div class="zro">
                                    <div class="rco">
                                        <div class="kko">{{ __("Department") }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="who">
                        <a class="ruo" role="button" href="/products">
                            <div class="pto">
                                <img src="{{asset('images/app_bg.png')}}">
                                <div class="zro">
                                    <div class="rco">
                                        <div class="kko">{{ __("Product") }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection