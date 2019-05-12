@extends('layouts.main')
@section('title','Đơn hàng')
@section('headbar-title','Đơn hàng')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/headbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/order.css') }}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
@endsection
@section('headbar')
    @section('search')
        @include('order_search')
    @endsection
    @include('layouts/headbar')
@endsection
@section('content')
    <div class="main-content">
        <div class="l-content">
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
                                    <div class="GNi" onclick="jQuery.UbizOIWidget.w_refresh_output_page(this)">
                                        <div class="ax7 poK utooltip" title="Làm mới">
                                            <div class="asA">
                                                <div class="asF"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="GNi" onclick="jQuery.UbizOIWidget.w_delete(0)">
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
                            </div>
                            <div class="hdG">
                                <div class="dcB col-1" role="presentation">
                                    <div class="dWB dWT" role="button" sort-name="ord_no" order-by="asc" onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">Mã đơn hàng</div>
                                            <div class="mhH">
                                                <div class="acD">
                                                    <div class="huK">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="dcB col-2" role="presentation">
                                    <div class="dWB" role="button" sort-name="ord_date" order-by="" onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">Ngày Tạo</div>
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
                                    <div class="dWB dWT" role="button" sort-name="sale_name" order-by="" onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">{{ __('Sale person') }}</div>
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
                                    <div class="dWB dWT" role="button" sort-name="cus_name" order-by="" onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">Khách Hàng</div>
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
                                    <div class="dWB dWT" role="button" sort-name="ord_amount_tax" order-by="" onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">Tổng tiền</div>
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
                                    <div class="dWB dWT" role="button" sort-name="ord_paid" order-by="" onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">Đã trả</div>
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
                                <div class="dcB col-7" role="presentation">
                                    <div class="dWB dWT" role="button" sort-name="ord_debt" order-by="" onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">Còn nợ</div>
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
						<input type="hidden" id="pageno" name="pageno" value="0">
                    </div>
                    <div class="aqB nicescroll" id="nicescroll-oput">
                        <div class="yTP">
                            <div id="table-content" class="jFr">
                                @foreach($orders as $order)
                                    <div class="jvD" ondblclick="jQuery.UbizOIWidget.w_go_to_input_page({{$order->ord_id}}, this)">
                                        <div class="tcB col-1">
                                            <div class="cbo">
                                                <div class="jgQ" onclick="jQuery.UbizOIWidget.w_c_checkbox_click(this)">
                                                    <input type="checkbox" class="ckb-i" value="{{$order->ord_id}}" style="display: none"/>
                                                    <div class="asU ckb-c"></div>
                                                </div>
                                                <div class="nCT" title="{{$order->ord_no}}">
                                                    <span>{{$order->ord_no}}</span>
                                                </div>
                                            </div>
                                        </div>
										<div class="tcB col-2">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$order->ord_date}}">
                                                    <span>{{date('Y/m/d',strtotime($order->ord_date))}}</span>
                                                </div>
                                            </div>
                                        </div>
										<div class="tcB col-3">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$order->sale_name}}">
                                                    <span>{{$order->sale_name}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-4">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$order->cus_name}}">
                                                    <span>{{$order->cus_name}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-5">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$order->ord_amount_tax}}">
                                                    <span>{{number_format($order->ord_amount_tax)}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-6">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$order->ord_paid}}">
                                                    <span>{{number_format($order->ord_paid)}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-7">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$order->ord_debt}}">
                                                    <span>{{number_format($order->ord_debt)}}</span>
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
            <div class="jAQ" id="i-put"  style="display: none">
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
                                    <div class="GNi">
                                        <div class="ax7 poK utooltip save" title="Lưu trữ">
                                            <div class="asA">
                                                <div class="arS"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="GNi">
                                        <div class="ax7 poK utooltip" title="Làm mới">
                                            <div class="asA">
                                                <div class="arR"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="GNi">
                                        <div class="ax7 poK utooltip delete" title="Xóa">
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
                                            <span><span class="ts curindex"></span></span> / <span class="ts totalindex"></span>
                                        </span>
                                    </div>
                                    <div class="amD utooltip" title="Cũ hơn">
                                        <span class="amF">&nbsp;</span>
                                        <img class="amI prev" src="./images/cleardot.gif" alt="">
                                    </div>
                                    <div class="amD utooltip" title="Mới hơn">
                                        <span class="amF">&nbsp;</span>
                                        <img class="amJ next" src="./images/cleardot.gif" alt="">
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
            </div>
        </div>
    </div>
@endsection
@section('end-javascript')
    <script type="text/javascript" src="{{ asset('js/order.js') }}"></script>
@endsection