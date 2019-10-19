@extends('layouts.main')
@section('title','Drive')
@section('headbar-title','Drive')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/headbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/drive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/bootstrap-fileinput/css/fileinput.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/bootstrap-fileinput/css/fileinput-rtl.min.css') }}">
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
            <div class="zY dropdown">
                <div id="dri-add-func" class="yP" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Thêm mới
                </div>
                <div class="dropdown-menu" aria-labelledby="dri-add-func">
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-folder-plus"></i>Thư mục
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onclick="fnc_open_upload_dialog()">
                        <i class="fas fa-file-upload"></i>Tải lên
                    </a>
                </div>
            </div>
            <div id="nicescroll-sidebar" class="zX nicescroll">
                <div class="nav-bar">
                    <div class="nav-item-root">
                        <div class="nav-li pdr-30">
                            <div class="row justify-content-start z-mgr z-mgl nav-item nav-selected">
                                <div class="col-auto z-pdr">
                                    <i class="nav-right nav-caret fas fa-caret-right"></i>
                                    <i class="nav-down nav-caret fas fa-caret-down hidden-content"></i>
                                    <img class="nav-caret nav-loading hidden-content" src="{{ asset('/images/ajax-loader.gif') }}">
                                </div>
                                <div class="col-auto z-pdl z-pdr">
                                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="#000000" focusable="false">
                                        <path d="M19 2H5c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 18H5v-1h14v1zm0-3H5V4h14v13zm-9.35-2h5.83l1.39-2.77h-5.81zm7.22-3.47L13.65 6h-2.9L14 11.53zm-5.26-2.04l-1.45-2.52-3.03 5.51L8.6 15z"></path>
                                    </svg>
                                </div>
                                <div class="col-auto pdl-5 nav-label">
                                    <span>Drive</span>
                                </div>
                            </div>
                            <div class="nav-li"></div>
                        </div>
                    </div>
                    <div class="nav-item-child">
                        <div class="nav-li pdr-30">
                            <div class="row justify-content-start z-mgr z-mgl nav-item">
                                <div class="col-auto z-pdr">
                                    <div class="nav-level"></div>
                                    <i class="nav-right nav-caret fas fa-caret-right"></i>
                                    <i class="nav-down nav-caret fas fa-caret-down hidden-content"></i>
                                    <img class="nav-caret nav-loading hidden-content" src="{{ asset('/images/ajax-loader.gif') }}">
                                </div>
                                <div class="col-auto z-pdl z-pdr">
                                    <svg width="24px" height="24px" viewBox="0 0 24 24" fill="#000000" focusable="false">
                                        <path d="M19 2H5c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 18H5v-1h14v1zm0-3H5V4h14v13zm-9.35-2h5.83l1.39-2.77h-5.81zm7.22-3.47L13.65 6h-2.9L14 11.53zm-5.26-2.04l-1.45-2.52-3.03 5.51L8.6 15z"></path>
                                    </svg>
                                </div>
                                <div class="col-auto pdl-5 nav-label">
                                    <span>Drive</span>
                                </div>
                            </div>
                            <div class="nav-li"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-content"></div>
        <div class="r-content">
            <div class="jAQ" id="o-put">
                <div class="bkK">
                    <div class="aeH">
                        <div class="aqK">
                            <div class="aqL">
                                <div class="row justify-content-start dri-breadcrumb">
                                    <div class="col-auto dri-breadcrumb-item">
                                        <a role="button" href="#">Drive</a>
                                    </div>
                                    <div class="col-auto dri-breadcrumb-item">
                                        <i class="fas fa-angle-right"></i>
                                    </div>
                                    <div class="col-auto dri-breadcrumb-item">
                                        <a role="button" href="#">ABC</a>
                                    </div>
                                    <div class="col-auto dri-breadcrumb-item">
                                        <i class="fas fa-angle-right"></i>
                                    </div>
                                    <div class="col-auto dri-breadcrumb-item">
                                        <div id="dri-breadcrumb-drd" class="dropdown">
                                            <a id="dri-breadcrumb-func" href="#"
                                               role="button" data-toggle="dropdown"
                                               aria-haspopup="true" aria-expanded="false">
                                                Pictures
                                                <i class="fas fa-caret-down"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dri-breadcrumb-func"></div>
                                        </div>
                                    </div>
                                </div>
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
                    <div class="aqC nicescroll" id="nicescroll-oput" oncontextmenu="o_context_menu(this, event)">
                        <div class="row z-pdr">
                            <div class="col-12 z-pdr z-mgr">
                                <div class="row">
                                    <div class="col-12 pdt-10 pdb-10">
                                        Thư mục
                                    </div>
                                </div>
                                <div class="folder-list row justify-content-start">
                                    <div class="col-auto" oncontextmenu="context_menu(this, event)">
                                        <div class="folder">
                                            <i class="fas fa-folder"></i>
                                            <span>ABC</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row z-pdr z-mgr">
                            <div class="col-12 z-pdr">
                                <div class="row">
                                    <div class="col-12 pdt-10 pdb-10">
                                        Tệp
                                    </div>
                                </div>
                                <div class="file-list row justify-content-start">
                                    <div class="col-auto">
                                        <div class="file">
                                            <div class="w-100 file-thumbnail"></div>
                                            <div class="w-100 file-detail">
                                                <i class="fas fa-folder"></i>
                                                <span>ABC</span>
                                            </div>
                                        </div>
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
    <script type="text/javascript" src="{{ asset('dist/bootstrap-fileinput/js/plugins/piexif.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/bootstrap-fileinput/js/plugins/purify.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/bootstrap-fileinput/js/plugins/sortable.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/bootstrap-fileinput/js/fileinput.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/bootstrap-fileinput/js/locales/vi.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/bootstrap-fileinput/themes/fas/theme.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/drive.js') }}"></script>
@endsection