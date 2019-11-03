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
            <div class="zY add-new col-auto">
                <div class="yP" onclick="fnc_add_new_click(this)">
                    Thêm mới
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
                                    <i class="far fa-hdd"></i>
                                </div>
                                <div class="col-auto pdl-5 nav-label">
                                    <span>Drive</span>
                                </div>
                            </div>
                            <div class="nav-li"></div>
                        </div>
                    </div>
                    <div class="nav-item-child"></div>
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
                                <div id="dri-breadcrumb" class="row justify-content-start dri-breadcrumb"></div>
                            </div>
                            <div class="aqJ">
                                <div class="ar5">
                                <span class="Di">
                                    <div class="amD utooltip selected-function" title="Xóa" style="display: none">
                                        <button class="i-btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    <div class="amD utooltip selected-function" title="Tác vụ khác" style="display: none">
                                        <button class="i-btn">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                    </div>
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
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="jAQ">
                    <div class="aqC nicescroll" id="nicescroll-oput">
                        <div id="folder-container" class="row z-pdr z-mgr" style="visibility: hidden">
                            <div class="col-12 z-pdr z-mgr">
                                <div class="row z-mgr">
                                    <div class="col-12 pdt-10 pdb-10">Thư mục</div>
                                </div>
                                <div class="folder-list row justify-content-start z-mgr"></div>
                            </div>
                        </div>
                        <div id="file-container" class="row z-pdr z-mgr" style="visibility: hidden">
                            <div class="col-12 z-pdr z-mgr">
                                <div class="row z-mgr">
                                    <div class="col-12 pdt-10 pdb-10">Tệp</div>
                                </div>
                                <div class="file-list row justify-content-start z-mgr"></div>
                            </div>
                        </div>
                        <div class="bg-drive-container" onclick="fnc_drive_container_click()"></div>
                        <div class="drive-ajax-loading" style="display: none">
                            <img src="{{ asset('/images/ajax-loader.gif') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('end-javascript')
    <script type="text/javascript" src="{{ asset('dist/cryptovjs3.1.2/rollups/md5.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/bootstrap-fileinput/js/plugins/piexif.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/bootstrap-fileinput/js/plugins/purify.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/bootstrap-fileinput/js/plugins/sortable.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/bootstrap-fileinput/js/fileinput.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/bootstrap-fileinput/js/locales/vi.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/bootstrap-fileinput/themes/fas/theme.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/drive.js') }}"></script>
@endsection