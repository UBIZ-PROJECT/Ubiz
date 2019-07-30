@extends('layouts.main')
@section('title', __("Product") )
@section('headbar-title',__("Product") )
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/headbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/product.css') }}">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
@endsection
@section('headbar')
@section('search')
    <div class="active ubiz-search ubiz-search-brand">
        @include('layouts/brand_search')
    </div>
    <div class="ubiz-search ubiz-search-product">
        @include('layouts/accessory_search')
    </div>

@section('headbar-icon')
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <path d="M9 11.75c-.69 0-1.25.56-1.25 1.25s.56 1.25 1.25 1.25 1.25-.56 1.25-1.25-.56-1.25-1.25-1.25zm6 0c-.69 0-1.25.56-1.25 1.25s.56 1.25 1.25 1.25 1.25-.56 1.25-1.25-.56-1.25-1.25-1.25zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8 0-.29.02-.58.05-.86 2.36-1.05 4.23-2.98 5.21-5.37C11.07 8.33 14.05 10 17.42 10c.78 0 1.53-.09 2.25-.26.21.71.33 1.47.33 2.26 0 4.41-3.59 8-8 8z"/>
        <path fill="none" d="M0 0h24v24H0z"/>
    </svg>
@endsection
@endsection
@include('layouts/headbar')
@endsection
@section('content')
    <div class="main-content">
        <div class="l-content">
            <div class="zY">
                <div class="yP" onclick="jQuery.UbizOIWidget.w_create()">{{ __("Add new") }}</div>
            </div>
            <div id="nicescroll-sidebar" class="zX">
                <nav role="navigation">
                    <div class="kL"></div>
                    <div class="sP">
                        <div class="aW NaT" id="ds_bom">
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
                                    <span class="dG"><a href="/brands">Danh Sách Bơm</a></span>
                                </div>
                            </div>
                        </div>
                        <div class="aW aT" id="ds_phutung">
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
                                    <span class="dG"><a href="/products">Danh Sách Phụ Tùng</a></span>
                                </div>
                            </div>
                        </div>
                        <div class="aW NaT" id="tk_tonkho">
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
                                    <span class="dG">Thống Kê Tồn Kho</span>
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
                                <div class="GtF">
                                    <div class="refresh" onclick="jQuery.UbizOIWidget.w_refresh_output_page(this)">
                                        <div class="ax7 poK utooltip" title="{{ __("Refresh") }}">
                                            <div class="asA">
                                                <div class="asF"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="delete" onclick="jQuery.UbizOIWidget.w_delete()">
                                        <div class="ax7 poK utooltip" title="{{ __("Delete") }}">
                                            <div class="asA">
                                                <div class="asX"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="GNi">
                                        <div class="ax7 poK">
                                            <div class="asA">
                                                <div class="asY"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="brd-content">
                    <?php foreach ($data as $brd) { ?>
                    <div class="brd-box" onclick="jQuery.UbizOIWidget.w_go_to_input_page('<?= $brd->brd_id ?>')">
                        <img src="<?= $brd->brdImage['src'] ?>" class="brd-img rounded mx-auto d-block">
                        <div class="brd-name"><?=$brd->brd_name ?></div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="jAQ" id="i-put"  style="display: none">
                <div class="bkK onsite">
                    <div class="aeH">
                        <div class="aqK">
                            <div class="aqL">
                                <div class="GtF">
                                    <div class="goback" onclick="jQuery.UbizOIWidget.w_go_back_to_output_page(this)">
                                        <div class="ax7 poK utooltip" title="{{ __("Back") }}">
                                            <div class="asA">
                                                <div class="arB"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="save">
                                        <div class="ax7 poK utooltip" title="{{ __("Save") }}">
                                            <div class="asA">
                                                <div class="arS"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="refresh">
                                        <div class="ax7 poK utooltip" title="{{ __("Refresh") }}">
                                            <div class="asA">
                                                <div class="arR"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="delete">
                                        <div class="ax7 poK utooltip" title="{{ __("Delete") }}">
                                            <div class="asA">
                                                <div class="asX"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="jAQ">
                    <div class="aqI nicescroll" id="nicescroll-iput">
                        <div class="row z-mgl z-mgr">
                            <div class="col-sm-2 col-md-2 col-xl-2 z-pdl">
                                @include('components.upload_image',['width'=>'200', 'height'=>'200'])
                            </div>
                            <div class="col-sm-3 col-md-3 col-xl-3 brd-info">
                                <input type="hidden" value="" id="txt_brd_id">
                                @include('components.input',['width'=>'250','type'=>'disabled', 'control_id'=>'txt_brd_id', 'label'=>__("Brand No"), 'length'=>5])
                                @include('components.input',['width'=>'250','type'=>'required', 'control_id'=>'txt_brd_name', 'label'=>__("Brand Name"), 'length'=>100])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bkK">
                    <div class="aeH">
                        <div class="aqK">
                            <div class="aqL">
                                <div class="GtF">
                                    <div class="select" onclick="jQuery.UbizOIWidget.w_f_checkbox_click(this)">
                                        <div class="ax7 poK utooltip-prd" title="{{ __("Select") }}">
                                            <div class="asA">
                                                <div class="asU ckb-f"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="save">
                                        <div class="ax7 poK utooltip-prd" title="{{ __("Save") }}">
                                            <div class="asA">
                                                <div class="arS"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="refresh">
                                        <div class="ax7 poK utooltip-prd" title="{{ __("Refresh") }}">
                                            <div class="asA">
                                                <div class="arR"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="delete">
                                        <div class="ax7 poK utooltip-prd" title="{{ __("Delete") }}">
                                            <div class="asA">
                                                <div class="asX"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="aqJ">
                                <div class="ar5">
                                <span class="Di">
                                    @include('layouts/paging',['paging'=>$paging])
                                    <div class="amD utooltip-prd setting" title="{{ __("Setting") }}">
                                        <span class="amF">&nbsp;</span>
                                        <img class="amG" src="{{ asset("images/cleardot.gif") }}" alt="">
                                    </div>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-content">
                    <div class="jAQ">
                        <div class="aqH" role="presentation">
                            <div class="yTP" role="presentation">
                                <div class="clG">
                                    <div class="col-1" role="presentation"></div>
                                    <div class="col-2" role="presentation"></div>
                                    <div class="col-3" role="presentation"></div>
                                    <div class="col-4" role="presentation"></div>
                                    <div class="col-5" role="presentation"></div>
                                </div>
                                <div class="hdG">
                                    <div class="dcB col-1" role="presentation">
                                        <div class="dWT" role="button" sort-name="" order-by="">
                                            <div class="dvJ">
                                                <div class="tDv"></div>
                                                <div class="mhH">
                                                    <div class="acD">
                                                        <div class="huK">
                                                            <svg class="faH asc" x="0px" y="0px" width="18px" height="18px"
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dcB col-2" role="presentation">
                                        <div class="dWT" role="button" sort-name="prd_name" order-by="" onclick="jQuery.UbizOIWidgetPrd.w_sort(this)">
                                            <div class="dvJ">
                                                <div class="tDv">Hình Ảnh</div>
                                                <div class="mhH">
                                                    <div class="acD">
                                                        <div class="huK">
                                                            <svg class="faH asc" x="0px" y="0px" width="18px" height="18px"
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dcB col-3" role="presentation">
                                        <div class="dWT" role="button" sort-name="prd_name" order-by="" onclick="jQuery.UbizOIWidgetPrd.w_sort(this)">
                                            <div class="dvJ">
                                                <div class="tDv">{{ __('Name') }}</div>
                                                <div class="mhH">
                                                    <div class="acD">
                                                        <div class="huK">
                                                            <svg class="faH asc" x="0px" y="0px" width="18px" height="18px"
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dcB col-4" role="presentation">
                                        <div class="dWB" role="button" sort-name="" order-by="" >
                                            <div class="dvJ">
                                                <div class="tDv">{{__('Brand')}}</div>
                                                <div class="mhH">
                                                    <div class="acD">
                                                        <div class="huK">
                                                            <svg class="faH asc" x="0px" y="0px" width="18px" height="18px"
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dcB col-5" role="presentation">
                                        <div class="dWB" role="button" sort-name="prd_model" order-by="" onclick="jQuery.UbizOIWidgetPrd.w_sort(this)">
                                            <div class="dvJ">
                                                <div class="tDv">{{ __('Type') }}</div>
                                                <div class="mhH">
                                                    <div class="acD">
                                                        <div class="huK">
                                                            <svg class="faH asc" x="0px" y="0px" width="18px" height="18px"
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dcB col-6" role="presentation">
                                        <div class="dWB" role="button" sort-name="type_id" order-by="" onclick="jQuery.UbizOIWidgetPrd.w_sort(this)">
                                            <div class="dvJ">
                                                <div class="tDv">{{__("Quantity")}}</div>
                                                <div class="mhH">
                                                    <div class="acD">
                                                        <div class="huK">
                                                            <svg class="faH asc" x="0px" y="0px" width="18px" height="18px"
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="aqB product-content-detail">

                        </div>
                    </div>
                </div>
            </div>
            <div class="jAQ" id="i-put-2"  style="display: none">
                <div class="bkK">
                    <div class="aeH">
                        <div class="aqK">
                            <div class="aqL">
                                <div class="GtF">
                                    <div class="goback" onclick="jQuery.UbizOIWidgetPrd.w_go_back_to_output_page(this)">
                                        <div class="ax7 poK utooltip" title="{{ __("Back") }}">
                                            <div class="asA">
                                                <div class="arB"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="save">
                                        <div class="ax7 poK utooltip" title="{{ __("Save") }}">
                                            <div class="asA">
                                                <div class="arS"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="refresh">
                                        <div class="ax7 poK utooltip" title="{{ __("Refresh") }}">
                                            <div class="asA">
                                                <div class="arR"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="delete">
                                        <div class="ax7 poK utooltip" title="{{ __("Delete") }}">
                                            <div class="asA">
                                                <div class="asX"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="aqJ">
                                <div class="ar5">
                                <span class="Di">
                                    <div class="amH" style="user-select: none">
                                        <span class="Dj">
                                            <span><span class="current-page"></span></span> / <span class="row-numbers"></span>
                                        </span>
                                    </div>
                                    <div class="amD utooltip previous" title="{{ __("Older") }}">
                                        <span class="amF">&nbsp;</span>
                                        <img class="amI" src="{{ asset("images/cleardot.gif") }}" alt="">
                                    </div>
                                    <div class="amD utooltip next" title="{{ __("Newer") }}">
                                        <span class="amF">&nbsp;</span>
                                        <img class="amJ" src="{{ asset("images/cleardot.gif") }}" alt="">
                                    </div>
                                    <div class="amD utooltip setting" title="{{ __("Setting") }}">
                                        <span class="amF">&nbsp;</span>
                                        <img class="amG" src="{{ asset("images/cleardot.gif") }}" alt="">
                                    </div>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="jAQ">
                    <div class="aqI nicescroll" id="nicescroll-iput-2">
                        <div class="row z-mgl z-mgr">
                            <div class="col-sm-5 col-md-5 col-xl-5 z-pdl">
                                <ul>
                                    <li>@include('components.upload_image',['multiUpload'=>true,'width'=>'120', 'height'=>'120'])</li>
                                    <li>@include('components.upload_image',['multiUpload'=>true,'width'=>'120', 'height'=>'120'])</li>
                                    <li>@include('components.upload_image',['multiUpload'=>true,'width'=>'120', 'height'=>'120'])</li>
                                </ul>
                            </div>
                            <div class="col-sm-3 col-md-3 col-xl-3">
                                <input type="hidden" value="" id="txt_acs_id">
                                <input type="hidden" value="" id="txt_brd_id">
                                @include('components.input',['width'=>'250','type'=>'disabled', 'control_id'=>'txt_brand_name', 'label'=>__("Brand"), 'length'=>100])
                                @include('components.input',['width'=>'250','type'=>'required', 'control_id'=>'txt_name', 'label'=>__("Name"), 'length'=>100])
                                @include('components.input',['width'=>'250','control_id'=>'txt_unit', 'label'=>__('Unit'), 'length'=>20])
                                @include('components.dropdown',['width'=>'250','control_id'=>'txt_name_type', 'label'=>__('Type'), 'data'=> convertDataToDropdownOptions($product_type, 'id', 'name_type')])
                            </div>
                            <div class="col-sm-3 col-md-3 col-xl-3 z-pdr">
                                @include('components.textarea',['width'=>'250', 'height'=>'80', 'control_id'=>'txt_acs_note', 'label'=>__('Note')])
                                @include('components.input',['width'=>'250','control_id'=>'txt_quantity', 'label'=>__('Quantity'), 'length'=>20])
                            </div>
                        </div>
                        <table width="90%" class="mt-5">
                            <tr>
                                <th class="text-left pl-0 border-0"><div class="lbl-primary font-weight-bold">Danh sách giữ hàng</div></th>
                                <th class="text-right pr-0 border-0 float-right">
                                    <div><input type="button" class="btn btn-primary" onclick="openKeeperModal()" data-target="#addAcsKeeperModal" value="+"></div>
                                </th>
                            </tr>
                        </table>
                        <div class="list-keep-accessory mt-4">
                            <div class="table-responsive">
                                <table id="dtVerticalScrollExample" class="table tb-keeper table-fixed">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="keep-col-1 text-center">STT</th>
                                            <th class="keep-col-3 ">Người giữ hàng</th>
                                            <th class="keep-col-3 ">{{__("Keep Date")}}</th>
                                            <th class="keep-col-3 ">{{__("Expired Date")}}</th>
                                            <th class="keep-col-1 ">Số lượng</th>
                                            <th class="keep-col-2 ">{{__("Note")}}</th>
                                            <th class="keep-col-4 "></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addAcsKeeperModal" tabindex="-1" role="dialog" aria-labelledby="addAcsKeeperModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAcsKeeperModalTitle">Người giữ phụ tùng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('components.dropdown',['width'=>'250','type'=>'required', 'control_id'=>'txt_keeper', 'label'=>__("Keeper"), 'data'=> convertDataToDropdownOptions($users, 'id', 'name')])
                    @include('components.input',['width'=>'250','type'=>'required', 'control_id'=>'txt_quantity', 'label'=>__("Quantity"), 'length'=>10])
                    @include('components.input',['width'=>'250','type'=>'required', 'placeholder'=>__("Day/Month/Year"),'control_id'=>'expired_date', 'label'=>__("Expired Date"), 'length'=>10])
                    @include('components.textarea',['width'=>'250', 'control_id'=>'txt_note', 'label'=>__('Note')])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary btn-save" onclick="keeperSave(0)">Lưu</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('end-javascript')
    <script type="text/javascript" src="{{ asset('js/product.js?v=12') }}"></script>
@endsection