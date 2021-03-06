@extends('layouts.main')
@section('title','Khách hàng')
@section('headbar-title','Khách hàng')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/headbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/customer.css') }}">
@endsection
@section('headbar')
@section('search')
    @include('customer_search')
@endsection
@include('layouts/headbar')
@endsection
@section('content')
    <div class="main-content">
        <div class="l-content">
            <div class="zY">
                <div class="yP" onclick="jQuery.UbizOIWidget.w_create()">Thêm mới</div>
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
                                    <span class="dG">Danh sách</span>
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
                                    <div class="GNi" onclick="jQuery.UbizOIWidget.w_f_checkbox_click(this)">
                                        <div class="ax7 poK utooltip" title="Chọn">
                                            <div class="asA">
                                                <div class="asU ckb-f"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="GNi" onclick="jQuery.UbizOIWidget.w_refresh_output_page()">
                                        <div class="ax7 poK utooltip" title="Làm mới">
                                            <div class="asA">
                                                <div class="asF"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="GNi" onclick="jQuery.UbizOIWidget.w_o_delete()">
                                        <div class="ax7 poK utooltip" title="Xóa">
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
                            <div class="aqJ">
                                <div class="ar5">
                                <span class="Di">
                                    @include('layouts/paging',['paging'=>$paging])
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
                    <div class="aqH" role="presentation">
                        <div class="yTP" role="presentation">
                            <div class="clG">
                                <div class="col-1" role="presentation"></div>
                                <div class="col-2" role="presentation"></div>
                                <div class="col-3" role="presentation"></div>
                                <div class="col-4" role="presentation"></div>
                                <div class="col-5" role="presentation"></div>
                                <div class="col-6" role="presentation"></div>
                                <div class="col-7" role="presentation"></div>
                            </div>
                            <div class="hdG">
                                <div class="dcB col-1" role="presentation">
                                    <div class="dWB dWT" role="button" sort-name="cus_id" order-by="asc"
                                         onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">Mã Khách Hàng</div>
                                            <div class="mhH">
                                                <div class="acD">
                                                    <div class="huK">
                                                        <svg class="faH asc sVGT" x="0px" y="0px" width="18px"
                                                             height="18px"
                                                             viewBox="0 0 48 48" focusable="false" fill="#000000">
                                                            <path fill="none" d="M0 0h48v48H0V0z"></path>
                                                            <path d="M8 24l2.83 2.83L22 15.66V40h4V15.66l11.17 11.17L40 24 24 8 8 24z"></path>
                                                        </svg>
                                                        <svg class="faH desc" x="0px" y="0px" width="18px"
                                                             height="18px" viewBox="0 0 48 48" focusable="false"
                                                             fill="#000000">
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
                                    <div class="dWB" role="button" sort-name="cus_type" order-by=""
                                         onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">Loại Khách Hàng</div>
                                            <div class="mhH">
                                                <div class="acD">
                                                    <div class="huK">
                                                        <svg class="faH asc" x="0px" y="0px" width="18px" height="18px"
                                                             viewBox="0 0 48 48" focusable="false" fill="#000000">
                                                            <path fill="none" d="M0 0h48v48H0V0z"></path>
                                                            <path d="M8 24l2.83 2.83L22 15.66V40h4V15.66l11.17 11.17L40 24 24 8 8 24z"></path>
                                                        </svg>
                                                        <svg class="faH desc" x="0px" y="0px" width="18px"
                                                             height="18px" viewBox="0 0 48 48" focusable="false"
                                                             fill="#000000">
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
                                    <div class="dWB" role="button" sort-name="cus_name" order-by=""
                                         onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">Tên Công Ty</div>
                                            <div class="mhH">
                                                <div class="acD">
                                                    <div class="huK">
                                                        <svg class="faH asc" x="0px" y="0px" width="18px" height="18px"
                                                             viewBox="0 0 48 48" focusable="false" fill="#000000">
                                                            <path fill="none" d="M0 0h48v48H0V0z"></path>
                                                            <path d="M8 24l2.83 2.83L22 15.66V40h4V15.66l11.17 11.17L40 24 24 8 8 24z"></path>
                                                        </svg>
                                                        <svg class="faH desc" x="0px" y="0px" width="18px"
                                                             height="18px" viewBox="0 0 48 48" focusable="false"
                                                             fill="#000000">
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
                                    <div class="dWB" role="button" sort-name="cus_phone" order-by=""
                                         onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">Số Điện Thoại</div>
                                            <div class="mhH">
                                                <div class="acD">
                                                    <div class="huK">
                                                        <svg class="faH asc" x="0px" y="0px" width="18px" height="18px"
                                                             viewBox="0 0 48 48" focusable="false" fill="#000000">
                                                            <path fill="none" d="M0 0h48v48H0V0z"></path>
                                                            <path d="M8 24l2.83 2.83L22 15.66V40h4V15.66l11.17 11.17L40 24 24 8 8 24z"></path>
                                                        </svg>
                                                        <svg class="faH desc" x="0px" y="0px" width="18px"
                                                             height="18px" viewBox="0 0 48 48" focusable="false"
                                                             fill="#000000">
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
                                    <div class="dWB" role="button" sort-name="cus_fax" order-by=""
                                         onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">Fax</div>
                                            <div class="mhH">
                                                <div class="acD">
                                                    <div class="huK">
                                                        <svg class="faH asc" x="0px" y="0px" width="18px" height="18px"
                                                             viewBox="0 0 48 48" focusable="false" fill="#000000">
                                                            <path fill="none" d="M0 0h48v48H0V0z"></path>
                                                            <path d="M8 24l2.83 2.83L22 15.66V40h4V15.66l11.17 11.17L40 24 24 8 8 24z"></path>
                                                        </svg>
                                                        <svg class="faH desc" x="0px" y="0px" width="18px"
                                                             height="18px" viewBox="0 0 48 48" focusable="false"
                                                             fill="#000000">
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
                                    <div class="dWB" role="button">
                                        <div class="dvJ" sort-name="cus_mail" order-by=""
                                             onclick="jQuery.UbizOIWidget.w_sort(this)">
                                            <div class="tDv">Email</div>
                                            <div class="mhH">
                                                <div class="acD">
                                                    <div class="huK">
                                                        <svg class="faH asc" x="0px" y="0px" width="18px" height="18px"
                                                             viewBox="0 0 48 48" focusable="false" fill="#000000">
                                                            <path fill="none" d="M0 0h48v48H0V0z"></path>
                                                            <path d="M8 24l2.83 2.83L22 15.66V40h4V15.66l11.17 11.17L40 24 24 8 8 24z"></path>
                                                        </svg>
                                                        <svg class="faH desc" x="0px" y="0px" width="18px"
                                                             height="18px" viewBox="0 0 48 48" focusable="false"
                                                             fill="#000000">
                                                            <path fill="none" d="M0 0h48v48H0V0z"></path>
                                                            <path d="M40 24l-2.82-2.82L26 32.34V8h-4v24.34L10.84 21.16 8 24l16 16 16-16z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="dcB col-7" role="presentation">
                                    <div class="dWB" role="button" sort-name="address" order-by=""
                                         onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">Địa chỉ</div>
                                            <div class="mhH">
                                                <div class="acD">
                                                    <div class="huK">
                                                        <svg class="faH asc" x="0px" y="0px" width="18px" height="18px"
                                                             viewBox="0 0 48 48" focusable="false" fill="#000000">
                                                            <path fill="none" d="M0 0h48v48H0V0z"></path>
                                                            <path d="M8 24l2.83 2.83L22 15.66V40h4V15.66l11.17 11.17L40 24 24 8 8 24z"></path>
                                                        </svg>
                                                        <svg class="faH desc" x="0px" y="0px" width="18px"
                                                             height="18px" viewBox="0 0 48 48" focusable="false"
                                                             fill="#000000">
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
                        <input type="hidden" id="pageno" name="pageno" value="0">
                    </div>
                    <div class="aqB nicescroll" id="nicescroll-oput">
                        <div class="yTP">
                            <div id="table-content" class="jFr">
                                @foreach($customers as $key => $customer)
                                    <div class="jvD"
                                         ondblclick="jQuery.UbizOIWidget.w_go_to_input_page({{ $key + 1 }}, {{$customer->cus_id}})">
                                        <div class="tcB col-1">
                                            <div class="cbo">
                                                <div class="jgQ" onclick="jQuery.UbizOIWidget.w_c_checkbox_click(this)">
                                                    <input type="checkbox" class="ckb-i" value="{{$customer->cus_id}}"
                                                           style="display: none"/>
                                                    <div class="asU ckb-c"></div>
                                                </div>
                                                <div class="nCT" title="{{$customer->cus_code}}">
                                                    <span>{{$customer->cus_code}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-2">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$customer->cus_type}}">
                                                    @if ($customer->cus_type == 1)
                                                        <span>Khách hàng mới</span>
                                                    @elseif ($customer->cus_type == 2)
                                                        <span>Khách hàng cũ</span>
                                                    @else
                                                        <span>Khách hàng thân thiết</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tcB col-3">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$customer->cus_name}}">
                                                    <span>{{$customer->cus_name}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-4">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$customer->cus_phone}}">
                                                    <span>{{$customer->cus_phone}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-5">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$customer->cus_fax}}">
                                                    <span>{{$customer->cus_fax}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-6">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$customer->cus_mail}}">
                                                    <span>{{$customer->cus_mail}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-7">
                                            <div class="cbo">
                                                <div class="nCj"
                                                     title="{{count($customer->address) ? $customer->address[0]->cad_address : ''}}">
                                                    <span>{{count($customer->address) ? $customer->address[0]->cad_address : ''}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="jAQ" id="i-put" style="display: none">
                <div class="bkK">
                    <div class="aeH">
                        <div class="aqK">
                            <div class="aqL">
                                <div class="GtF">
                                    <div class="GNi" onclick="jQuery.UbizOIWidget.w_go_back_to_output_page(this)">
                                        <div class="ax7 poK utooltip" title="Quay lại">
                                            <div class="asA">
                                                <div class="arB"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="GNi" onclick="jQuery.UbizOIWidget.w_save()">
                                        <div class="ax7 poK utooltip save" title="Lưu trữ">
                                            <div class="asA">
                                                <div class="arS"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="GNi" onclick="jQuery.UbizOIWidget.w_i_refresh()">
                                        <div class="ax7 poK utooltip" title="Làm mới">
                                            <div class="asA">
                                                <div class="arR"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="GNi" onclick="jQuery.UbizOIWidget.w_i_delete()">
                                        <div class="ax7 poK utooltip delete" title="Xóa">
                                            <div class="asA">
                                                <div class="asX"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="GNi" id="quoteprice-create">
                                        <div class="ax7 poK dropdown">
                                            <div class="asA" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="asY"></div>
                                            </div>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="#" onclick="jQuery.UbizOIWidget.w_add_quoteprice(event)">Tạo báo giá</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="aqJ">
                                <div class="ar5">
                                <span class="Di">
                                    <div id="i-paging-label"></div>
                                    <div id="i-paging-older"></div>
                                    <div id="i-paging-newer"></div>
                                    <div class="amD utooltip" title="{{ __("Setting") }}">
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
                    <div class="aqI nicescroll" id="nicescroll-iput">
                        <form id="f-input">
                            <div class="row z-mgl z-mgr">
                                <div class="col-sm-9 col-md-9 col-xl-9 z-pdl">
                                    <div class="row z-mgl z-mgr z-pdl z-pdr">
                                        <div class="col-sm-3 col-md-3 col-xl-3 z-pdl">
                                            <div class="image-upload mb-1" style="max-width: 150px; max-height: 150px">
                                                <img id="cus-img" name="cus-img" style="height: 150px; width:150px"
                                                     onclick="jQuery.UbizOIWidget.w_cus_avatar_click()"
                                                     src="{{ asset("images/avatar.png") }}"
                                                     class="img-thumbnail img-show ">
                                                <input id="cus-file"
                                                       type="file" accept="image/*" name="cus-file"
                                                       onchange="jQuery.UbizOIWidget.w_cus_avatar_change(this)"
                                                       style="display:none">
                                                <input id="cus-avatar" type="hidden" name="cus-avatar" value="">
                                                <input id="cus-avatar-base64" type="hidden" name="cus-avatar-base64" value="">
                                                <button type="button" style="top: -150px;" class="close"
                                                        aria-label="Close"
                                                        onclick="removeImage(this, jQuery.UbizOIWidget.w_callback_remove_image)">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                                <span class="label-change"
                                                      onclick="jQuery.UbizOIWidget.w_cus_avatar_click()"
                                                      style="width: 150px;">{{ __("Change") }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-9 col-md-9 col-xl-9">
                                            <input type="hidden" name="cus-id" value="0"/>
                                            @include('components.input',['type'=>'required', 'control_id'=>'cus-code', 'i_focus'=>'', 'i_blur'=>'', 'label'=>'Mã', 'length'=>5])
                                            @include('components.input',['type'=>'required', 'control_id'=>'cus-name', 'i_focus'=>'', 'i_blur'=>'', 'label'=>'Tên công ty', 'length'=>250])
                                            @include('components.input',['control_id'=>'cus-fax', 'label'=>'Fax', 'i_focus'=>'', 'i_blur'=>'', 'length'=>20])
                                            @include('components.input',['control_id'=>'cus-mail', 'label'=>'Email', 'i_focus'=>'', 'i_blur'=>'', 'length'=>250])
                                            @include('components.input',['control_id'=>'cus-phone', 'label'=>'Điện thoại', 'i_focus'=>'', 'i_blur'=>'', 'width'=>450])
                                            @include('components.input',['control_id'=>'cus-field', 'label'=>'Lĩnh vực', 'i_focus'=>'', 'i_blur'=>'', 'width'=>450])

                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        @include('components.input',['control_id'=>'cus-address-1', 'label'=>'Địa chỉ 1', 'i_focus'=>'', 'i_blur'=>'', 'width'=>450])
                                                        @include('components.hidden_input',['control_id'=>'cad-id-1', 'value'=>'0'])
                                                    </td>
                                                    <td>
                                                        <div class="textfield  root_textfield rootIsUnderlined" style="width: 100px">
                                                            <div class="wrapper" style="height: 33px">
                                                                <div class="fieldGroup">
                                                                    <select class="dropdown_field" name="lct-location-1"">
                                                                        @foreach($addLocations as $lct)
                                                                            <option value="{{ $lct->lct_id }}">{{ $lct->lct_location }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        @include('components.input',['control_id'=>'cus-address-2', 'label'=>'Địa chỉ 2', 'i_focus'=>'', 'i_blur'=>'', 'width'=>450])
                                                        @include('components.hidden_input',['control_id'=>'cad-id-2', 'value'=>'0'])
                                                    </td>
                                                    <td>
                                                        <div class="textfield  root_textfield rootIsUnderlined" style="width: 100px">
                                                            <div class="wrapper" style="height: 33px">
                                                                <div class="fieldGroup">
                                                                    <select class="dropdown_field" name="lct-location-2">
                                                                        @foreach($addLocations as $lct)
                                                                            <option value="{{ $lct->lct_id }}">{{ $lct->lct_location }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <table>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        @include('components.input',['control_id'=>'cus-address-3', 'label'=>'Địa chỉ 3', 'i_focus'=>'', 'i_blur'=>'', 'width'=>450])
                                                        @include('components.hidden_input',['control_id'=>'cad-id-3', 'value'=>'0'])
                                                    </td>
                                                    <td>
                                                        <div class="textfield  root_textfield rootIsUnderlined" style="width: 100px">
                                                            <div class="wrapper" style="height: 33px">
                                                                <div class="fieldGroup">
                                                                    <select class="dropdown_field" name="lct-location-3">
                                                                        @foreach($addLocations as $lct)
                                                                            <option value="{{ $lct->lct_id }}">{{ $lct->lct_location }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <div class="textfield  root_textfield rootIsUnderlined cus_type_container"
                                                 style="width: 300px">
                                                <div class="wrapper">
                                                    <label for="cus-type" class="ms-Label root-56 lbl-primary" style="">Loại khách hàng:&nbsp;&nbsp;&nbsp;</label>
                                                    <div class="fieldGroup">
                                                        <select class="dropdown_field" name="cus-type">
                                                            @foreach($customerTypeList as $item)
                                                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <span class="error_message hidden-content">
                                           <div class="message-container">
                                              <p class="label_errorMessage css-57 errorMessage">
                                                  <span class="error-message-text"></span>
                                              </p>
                                           </div>
                                        </span>
                                            </div>
                                            <div class="textfield  root_textfield rootIsUnderlined"
                                                 style="width: 300px">
                                                <div class="wrapper">
                                                    <label for="cus-pic"
                                                           class="ms-Label root-56 lbl-primary"
                                                           style="">Nhân viên phụ trách:&nbsp;&nbsp;&nbsp;</label>
                                                    <div class="fieldGroup">
                                                        <select class="dropdown_field" name="cus-pic">
                                                            @foreach($users as $user)
                                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <span class="error_message hidden-content">
                                           <div class="message-container">
                                              <p class="label_errorMessage css-57 errorMessage">
                                                  <span class="error-message-text"></span>
                                              </p>
                                           </div>
                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3 col-xl-3 z-pdr cus-part-2">
                                    <div class="row z-mgl z-mgr">
                                        <span class="text-primary">Người liên hệ</span>
                                    </div>
                                    <hr class="z-mgt">
                                    <div id="con-summary-container" class="row z-mgl z-mgr"></div>
                                    <div class="row z-mgl z-mgr">
                                        <div class="PnGFPb" onclick="jQuery.UbizOIWidget.w_con_add()">
                                            <div class="qpLcp dagkwb">
                                                <div class="cnTo8e cnTo7e FYQzvb K2GaRc min-width-100">
                                                    <div class="Hbkijd w-100">
                                                        <div class="kMp0We YaPvld nO3x3e w-100 z-pdr">
                                                            <div class="NI2kox YnkeVe pXxjhe w-100">
                                                                <span>Thêm mới</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Modal -->
    <div class="modal fade" id="contact-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Người liên hệ</h5>
                    <img name="ajax-loader" src="{{ asset('images/ajax-loader.gif') }}"
                         style="display: none; height: 28px; margin-left: 10px">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4 col-md-4 col-xl-4 z-pdr">
                            <div class="image-upload mb-1" style="max-width: 150px; max-height: 150px">
                                <img id="m-con-img" style="height: 150px; width:150px"
                                     onclick="jQuery.UbizOIWidget.w_con_avatar_click()"
                                     src="{{ asset("images/avatar.png") }}"
                                     class="img-thumbnail img-show ">
                                <input id="m-con-file"
                                       onchange="jQuery.UbizOIWidget.w_con_avatar_change(this);"
                                       type="file" accept="image/*"
                                       name="m-con-file" style="display:none">
                                <input id="m-con-avatar" type="hidden" name="m-con-avatar" value="">
                                <input id="m-con-avatar-base64" type="hidden" name="m-con-avatar-base64" value="">
                                <button type="button" style="top: -150px;" class="close" aria-label="Close"
                                        onclick="removeImage(this, jQuery.UbizOIWidget.w_con_remove_image)">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <span onclick="jQuery.UbizOIWidget.w_con_avatar_click()"
                                      class="label-change" style="width: 150px;">{{ __("Change") }}</span>
                            </div>
                        </div>
                        <div class="col-sm-8 col-md-8 col-xl-8">
                            <input type="hidden" id="m-con-id" name="m-con-id" value="0"/>
                            @include('components.input',['control_id'=>'m-con-name', 'i_focus'=>'', 'i_blur'=>'', 'label'=>'Tên', 'length'=>200])
                            @include('components.input',['control_id'=>'m-con-mail', 'i_focus'=>'', 'i_blur'=>'', 'label'=>'E-mail', 'length'=>200])
                            @include('components.input',['control_id'=>'m-con-phone', 'i_focus'=>'', 'i_blur'=>'', 'label'=>'Điện thoại', 'length'=>200])
                            @include('components.input',['control_id'=>'m-con-rank', 'i_focus'=>'', 'i_blur'=>'', 'label'=>'Chức vụ', 'length'=>200])
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    <button type="button" class="btn btn-primary" onclick="jQuery.UbizOIWidget.w_con_modal_save()">Lưu
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Summary -->
    <div name="con-summary" style="display: none">
        <div name="con-summary-detail" class="PnGFPb width-230">
            <input type="hidden" name="dt-con-id" value="0"/>
            <input type="hidden" name="dt-con-name" value=""/>
            <input type="hidden" name="dt-con-mail" value=""/>
            <input type="hidden" name="dt-con-phone" value=""/>
            <input type="hidden" name="dt-con-rank" value=""/>
            <input type="hidden" name="dt-con-avatar" value=""/>
            <input type="hidden" name="dt-con-avatar-base64" value=""/>
            <div class="qpLcp dagkwb">
                <div class="cnTo8e cnTo9e FYQzvb K2GaRc">
                    <div onclick="jQuery.UbizOIWidget.w_con_edit(this, event)" class="Hbkijd">
                        <div class="kMp0We YaPvld nO3x3e">
                            <div class="nGJqzd OLw7vb cSfOjc">
                                <div class="T6JWhd" style="width: 22px; height: 22px;">
                                    <div class="EzBbpc" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 192"
                                             enable-background="new 0 0 192 192" width="22px" height="22px">
                                            <path fill="#E0E0E0"
                                                  d="M96,0C43.01,0,0,43.01,0,96s43.01,96,96,96s96-43.01,96-96S148.99,0,96,0z"></path>
                                            <path fill="#BDBDBD"
                                                  d="M96,85.09c13.28,0,24-10.72,24-24c0-13.28-10.72-24-24-24s-24,10.72-24,24C72,74.37,82.72,85.09,96,85.09z"></path>
                                            <path fill="#BDBDBD"
                                                  d="M96,99.27c-29.33,0-52.36,14.18-52.36,27.27c11.09,17.06,30.51,28.36,52.36,28.36s41.27-11.3,52.36-28.36C148.36,113.45,125.33,99.27,96,99.27z"></path>
                                            <rect fill="none" width="192" height="192"></rect>
                                        </svg>
                                    </div>
                                    <div class="jPtXgd">
                                        <img name="dt-con-avatar-view" src="">
                                    </div>
                                </div>
                            </div>
                            <div class="NI2kfb YnkeVe pXxjhe">
                                <span name="dt-con-name-view" class="HfUiNb"></span>
                            </div>
                        </div>
                    </div>
                    <i onclick="jQuery.UbizOIWidget.w_con_del(this, event)" class="fas fa-times RpN9Ve" role="button"
                       tabindex="0"></i>
                </div>
            </div>
            <div class="Gk2rXd"></div>
        </div>
    </div>
    </div>
@endsection
@section('end-javascript')
    <script type="text/javascript" src="{{ asset('js/customer.js') }}"></script>
    <script type="text/javascript">
        jQuery.UbizOIWidget.rows_num = {{ intval($paging['rows_num']) }};
    </script>
@endsection