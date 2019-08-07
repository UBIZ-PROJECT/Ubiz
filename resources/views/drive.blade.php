@extends('layouts.main')
@section('title','Drive')
@section('headbar-title','Drive')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/headbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/drive.css') }}">
@endsection
@section('headbar')
    @section('search')
        @include('drive_search')
    @endsection
    @include('layouts/headbar')
@endsection
@section('content')
    <div class="main-content">
        <div class="l-content">
            <div class="zY">
                <div class="yP" onclick="">Thêm mới</div>
            </div>
            <div id="nicescroll-sidebar" class="zX nicescroll">
                <nav role="navigation">
                    <div class="kL"></div>
                    <div class="sP">
                        <div class="aW aT" id="li">
                            <div class="mR">
                                <div class="eT">
                                    <div class="Vf"></div>
                                    <div class="Vg">
                                        <svg x="0px" y="0px" width="20px" height="20px"
                                             viewBox="0 0 20 20" focusable="false">
                                            <polygon points="5,8 10,13 15,8"></polygon>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="iU">
                                <div class="wQ">
                                    <div class="tA">
                                        <div class="vD">
                                            <div class="xT">
                                                <div class="oQ">
                                                    <svg width="24px" height="24px" viewBox="0 0 24 24">
                                                        <path fill="none" d="M0 0h24v24H0V0zm0 0h24v24H0z"></path>
                                                        <path d="M3 20.01c0 1.1.89 1.99 2 1.99h14c1.1 0 2-.9 2-1.99V18H3v2.01zM18 19c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm1-17H5c-1.1 0-2 .9-2 1.99V17h18V3.99C21 2.89 20.11 2 19 2zm-8.62 3h3.24l3.25 5.68h-3.24L10.38 5zm-3.52 6.16l3.11-5.44s1.62 2.85 1.62 2.84L8.49 14l-1.63-2.84zM15.51 14H9.3l1.62-2.84h6.21L15.51 14z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="xV">
                                                <div class="oQ">
                                                    <svg width="24px" height="24px" viewBox="0 0 24 24">
                                                        <path fill="none" d="M0 0h24v24H0V0zm0 0h24v24H0z"></path>
                                                        <path d="M3 20.01c0 1.1.89 1.99 2 1.99h14c1.1 0 2-.9 2-1.99V18H3v2.01zM18 19c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm1-17H5c-1.1 0-2 .9-2 1.99V17h18V3.99C21 2.89 20.11 2 19 2zm-8.62 3h3.24l3.25 5.68h-3.24L10.38 5zm-3.52 6.16l3.11-5.44s1.62 2.85 1.62 2.84L8.49 14l-1.63-2.84zM15.51 14H9.3l1.62-2.84h6.21L15.51 14z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="dG">Drive</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="m-content"></div>
        <div class="r-content">
            <div class="jAQ" id="o-put">
                <div class="bkK">
                    <div class="aeH">
                        <div class="aqK">
                            <div class="aqL">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb z-mgb z-pdt z-pdb">
                                        <li class="breadcrumb-item"><a href="#">Drive</a></li>
                                        <li class="breadcrumb-item"><a href="#">Marketing</a></li>
                                        <li class="breadcrumb-item active dropdown" aria-current="page">
                                            <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Pictures
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="aqJ">
                                <div class="ar5">
                                <span class="Di">
                                    <div class="amH" style="user-select: none">
                                        <span class="Dj">
                                            <span class="ts">Tên</span>
                                        </span>
                                        <div class="amD utooltip" title="Sắp xếp">
                                            <svg class="faH asc sVGT" x="0px" y="0px" width="18px" height="18px"
                                                 viewBox="0 0 48 48" focusable="false" fill="#000000">
                                                <path fill="none" d="M0 0h48v48H0V0z"></path>
                                                <path d="M8 24l2.83 2.83L22 15.66V40h4V15.66l11.17 11.17L40 24 24 8 8 24z"></path>
                                            </svg>
                                            <svg class="faH desc" x="0px" y="0px" width="18px"
                                                 height="18px" viewBox="0 0 48 48" focusable="false" fill="#000000">
                                                <path fill="none" d="M0 0h48v48H0V0z"></path>
                                                <path d="M40 24l-2.82-2.82L26 32.34V8h-4v24.34L10.84 21.16 8 24l16 16 16-16z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="amD utooltip" title="Cài đặt">
                                        <span class="amF">&nbsp;</span>
                                        <img class="amG" src="./images/cleardot.gif" alt="">
                                    </div>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="jAQ">
                    <div class="aqC nicescroll" id="nicescroll-oput">
                        <div class="row z-pdr">
                            <div class="col-12 z-pdr z-mgr">
                                <div class="row">
                                    <div class="col-12">
                                        Thư mục
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        Thư mục
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row z-pdr z-mgr">
                            <div class="col-12 z-pdr">
                                <div class="row">
                                    <div class="col-12">
                                        Tệp
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        Tệp
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('end-javascript')
    <script type="text/javascript" src="{{ asset('js/drive.js') }}"></script>
@endsection