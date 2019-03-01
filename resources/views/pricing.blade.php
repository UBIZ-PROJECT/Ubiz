@extends('layouts.main')
@section('title','Báo giá')
@section('headbar-title','Báo giá')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/headbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/customer.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/pricing.css') }}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
@endsection
@section('headbar')
    @section('search')
        @include('pricing_search')
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
                            </div>
                            <div class="hdG">
                                <div class="dcB col-3" role="presentation">
                                    <div class="dWB dWT" role="button" sort-name="pri_code" order-by="asc" onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">Mã Báo Giá</div>
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
								<div class="dcB col-3" role="presentation">
                                    <div class="dWB dWT" role="button" sort-name="pri_code" order-by="asc" onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">Khách Hàng</div>
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
								<div class="dcB col-3" role="presentation">
                                    <div class="dWB dWT" role="button" sort-name="pri_code" order-by="asc" onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">Sale</div>
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
                                <div class="dcB col-3" role="presentation">
                                    <div class="dWB" role="button" sort-name="pri_date" order-by="" onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">Ngày Báo Giá</div>
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
                                    <div class="dWB" role="button">
                                        <div class="dvJ" sort-name="exp_date" order-by="" onclick="jQuery.UbizOIWidget.w_sort(this)">
                                            <div class="tDv">Ngày hết hạn</div>
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
                                @foreach($pricingList as $pricing)
                                    <div class="jvD" ondblclick="jQuery.UbizOIWidget.w_go_to_input_page({{$pricing->pri_id}}, this)">
                                        <div class="tcB col-3">
                                            <div class="cbo">
                                                <div class="jgQ" onclick="jQuery.UbizOIWidget.w_c_checkbox_click(this)">
                                                    <input type="checkbox" class="ckb-i" value="{{$pricing->pri_id}}" style="display: none"/>
                                                    <div class="asU ckb-c"></div>
                                                </div>
                                                <div class="nCT" title="{{$pricing->pri_code}}">
                                                    <span>{{$pricing->pri_code}}</span>
                                                </div>
                                            </div>
                                        </div>
										<div class="tcB col-3">
                                            <div class="cbo">
                                                <div class="nCT" title="{{$pricing->cus_name}}">
                                                    <span>{{$pricing->cus_name}}</span>
                                                </div>
                                            </div>
                                        </div>
										<div class="tcB col-3">
                                            <div class="cbo">
                                                <div class="nCT" title="{{$pricing->name}}">
                                                    <span>{{$pricing->name}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-3">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$pricing->pri_date}}">
                                                    <span>{{$pricing->pri_date}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-3">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$pricing->exp_date}}">
                                                    <span>{{$pricing->exp_date}}</span>
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
                <div class="jAQ">
                    <div class="aqI nicescroll" id="nicescroll-iput">
						<form id="f-input">
							<div class="row z-mgl z-mgr">
								<div class="col-sm-2 col-md-2 col-xl-2 z-pdl">
									<div class="image-upload mb-1" style="max-width: 150px; max-height: 150px">
										<img id="avt_img" src="{{ asset("images/avatar.png") }}" img-name="" style="height: 150px; width:150px" alt="" class="img-thumbnail img-show ">
										<input  id="avatar" type="file" accept="image/*" name="cus_avatar" is-change="true" style="display:none">
									</div>
								</div>
								<div class="col-sm-5 col-md-5 col-xl-5">
									<input type="hidden" name="cus_id" value="0"/>
									@include('components.input',['type'=>'disabled', 'control_id'=>'cus_code', 'label'=>'Mã'])
									@include('components.input',['type'=>'disabled', 'control_id'=>'cus_name', 'label'=>'Tên khách hàng'])
									@include('components.input',['type'=>'disabled', 'control_id'=>'cus_type', 'label'=>'Loại khách hàng'])
									@include('components.input',['type'=>'required', 'control_id'=>'exp_date', 'label'=>'Ngày hết hạn', 'length'=>10])
								</div>
								<div class="col-sm-5 col-md-5 col-xl-5 z-pdr cus-part-2">
									@include('components.input',['type'=>'disabled', 'control_id'=>'cus_phone', 'label'=>'Số điện thoại'])
									@include('components.input',['type'=>'disabled', 'control_id'=>'cus_fax', 'label'=>'Fax'])
									@include('components.input',['type'=>'disabled', 'control_id'=>'cus_mail', 'label'=>'Email'])
								</div>
							</div>
								
							<div class="row z-mgl z-mgr" style="margin-top:30px;border:1px solid #f1f1f1;width:98%; padding:10px">
								<h3 style="color:#194078;width:100%"><b>Bơm:<b></h3>
								<table class="pro-table" id="p_tab">
									<tr>
										<th>STT</th>
										<th>Thông số kĩ thuật</th>
										<th>Đơn vị</th>
										<th>Số lượng</th>
										<th>Thời gian giao hàng</th>
										<th>Trạng thái</th>
										<th>Đơn giá (VNĐ)</th>
										<th>Thành tiền (VNĐ)</th>
										<th>Xóa</th>
									</tr>
									<tr>
										<td class="index_no">1</td>
										<td><textarea size="5" name="new_p_specs[]" class="inp-specs"></textarea></td>
										<td><input type="text" name="new_p_unit[]" class="inp70"/></td>
										<td><input type="text" name="new_p_amount[]" class="inp70"/></td>
										<td><input type="text" name="new_p_delivery_date[]" class="inp100"/></td>
										<td>
											<select name="status" class="inp100">
												<option value="1" selected>Sẵn có</option>
												<option value="0">Order</option>
											</select>
										</td>
										<td><input type="text" name="new_p_price[]" class="inp100"/></td>
										<td><input type="text" name="new_p_total[]" class="inp130"/></td>
										<td><a href="#" class="delete_p_row"><i class="far fa-trash-alt" style="color:red"></i></a></td>
									</tr>
								</table>
							</div>
							
							<div id="add-pump" style="margin-top:30px" class="btn-a" onclick="jQuery.UbizOIWidget.w_add_p_row()">Thêm bơm</div>
						
							<div class="row z-mgl z-mgr" style="margin-top:30px;border:1px solid #f1f1f1;width:98%; padding:10px">
								<h3 style="color:#194078;width:100%"><b>Phụ tùng:<b></h3>
								<table class="pro-table" id="f_tab">
									<tr>
										<th>STT</th>
										<th>Mã</th>
										<th>Tên</th>
										<th>Đơn vị</th>
										<th>Số lượng</th>
										<th>Thời gian giao hàng</th>
										<th>Trạng thái</th>
										<th>Đơn giá (VNĐ)</th>
										<th>Thành tiền (VNĐ)</th>
										<th>Xóa</th>
									</tr>
									<tr>
										<td class="index_f_no">1</td>
										<td><input type="text" name="new_f_code[]" class="inp70"/></td>
										<td><input type="text" name="new_f_name[]" class="inp130"/></td>
										<td><input type="text" name="new_f_unit[]" class="inp70"/></td>
										<td><input type="text" name="new_f_amount[]" class="inp70"/></td>
										<td><input type="text" name="new_f_delivery_date[]" class="inp100"/></td>
										<td>
											<select name="new_f_status[]" class="inp100">
												<option value="1" selected>Sẵn có</option>
												<option value="0">Order</option>
											</select>
										</td>
										<td><input type="text" name="new_f_price[]" class="inp100"/></td>
										<td><input type="text" name="new_f_total[]" class="inp110"/></td>
										<td><a href="#" class="delete_f_row"><i class="far fa-trash-alt" style="color:red"></i></a></td>
									</tr>
								</table>
								
								<div id="add-accessory" style="margin-top:30px" class="btn-a" onclick="jQuery.UbizOIWidget.w_add_f_row()">Thêm phụ tùng</div>
							</div>
							<input type="hidden" name="pri_id" value=""/>
						</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('end-javascript')
    <script type="text/javascript" src="{{ asset('js/pricing.js') }}"></script>
@endsection