@extends('layouts.main')
@section('title','Báo cáo')
@section('headbar-title','Báo cáo')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/headbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/report.css') }}">
@endsection
@section('headbar')
    @include('layouts/headbar')
@endsection
@section('content')
<div class="main-content">
        <div class="l-content">
            <div id="nicescroll-sidebar" class="zX nicescroll">
                @include('report-nav')
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
                                    <div class="GNi" onclick="jQuery.UbizOIWidget.w_refresh_output_page(this)">
                                        <div class="ax7 poK utooltip" title="Làm mới">
                                            <div class="asA">
                                                <div class="asF"></div>
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
                    <form id="f-export">
                        <table>
                            <tr>
                                <td style="padding: 10px">@include('components.input',['control_id'=>'report_from_date', 'value'=> date('Y/m')."/01", 'width'=> '150', 'lbl_width'=>'70', 'label'=>'Từ ngày', 'class'=>'datepicker z-pdl z-pdr', 'i_focus'=>'', 'i_blur'=>'', 'onchange'=>"qp_date_change(this)"])</td>
                                <td style="padding: 10px">@include('components.input',['control_id'=>'brd_name', 'value'=> '', 'width'=> '250', 'lbl_width'=>'110', 'label'=>'Tên thương hiệu', 'length'=>'200'])</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="padding: 10px">@include('components.input',['control_id'=>'report_to_date', 'value'=> date('Y/m/d'), 'width'=> '150', 'lbl_width'=>'70', 'label'=>'Đến ngày', 'class'=>'datepicker z-pdl z-pdr', 'i_focus'=>'', 'i_blur'=>'', 'onchange'=>"qp_date_change(this)"])</td>
                                <td style="padding: 10px">@include('components.input',['control_id'=>'prd_name', 'value'=> '', 'width'=> '250', 'lbl_width'=>'100', 'label'=>'Tên hàng hoá', 'length'=>'200'])</td>
                                <td style="padding: 10px">
                                    <div class="textfield  root_textfield rootIsUnderlined cus_type_container"
                                         style="width: 200px">
                                        <div class="wrapper">
                                            <label for="user_id" class="ms-Label root-56 lbl-primary" style="">Loại
                                                hàng hoá:&nbsp;&nbsp;&nbsp;</label>
                                            <div class="fieldGroup">
                                                <select class="dropdown_field" id="prd_query_type" name="prd_query_type">
                                                    <option value="1">Bơm</option>
                                                    <option value="2">Phụ tùng</option>
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
                                </td>
                                <td><span class="btn btn-info" id="statis-button" onclick="jQuery.UbizOIWidget.w_statis()"> Thống kê </span></td>
                            </tr>
                        </table>
                    </form>
                    <table>
                        <tr>
                            <td style="width: 280px"><p style="font-size:15px"><strong>Tổng số lượng tồn đầu kì:</strong> <span id="total_start_time_cnt">{{ $report->total_start_time_cnt }}</span></p></td>
                            <td style="width: 280px"><p style="font-size:15px"><strong>Tổng số lượng tồn cuối kì:</strong> <span id="total_end_time_cnt">{{ $report->total_end_time_cnt }}</span></p></td>
                        </tr>
                    </table>
                    <div class="export">
                    <span class="btn btn-info export" id="rev-export-button" onclick="jQuery.UbizOIWidget.w_export('repository')"> Xuất excel </span>
                    <span class="btn btn-info export" id="export-rep-btn"> Xuất kho </span>
                    <span class="btn btn-info export" id="import-rep-btn"> Nhập kho </span>
                    </div>
                    <div class="aqH" role="presentation">
                        <div class="yTP" role="presentation">
                            <div class="clG">
                                <div class="col-1" role="presentation"></div>
                                <div class="col-1" role="presentation"></div>
                                <div class="col-1" role="presentation"></div>
                                <div class="col-1" role="presentation"></div>
                                <div class="col-1" role="presentation"></div>
                                <div class="col-1" role="presentation"></div>
                                <div class="col-1" role="presentation"></div>
                                <div class="col-4" role="presentation"></div>
                                <div class="col-1" role="presentation"></div>
                            </div>
                            <div class="hdG">
                                <div class="dcB col-1" role="presentation">
                                    <div class="dWB dWT" role="button" sort-name="brd_name" order-by="asc"
                                         onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">Hãng Bơm</div>
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
                                <div class="dcB col-1" role="presentation">
                                    <div class="dWB" role="button" sort-name="prd_name" order-by=""
                                         onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">Tên hàng hoá</div>
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
                                <div class="dcB col-1" role="presentation">
                                    <div class="dWB" role="button" sort-name="prd_unit" order-by=""
                                         onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">Đơn vị tính</div>
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
                                <div class="dcB col-1" role="presentation">
                                    <div class="dWB" role="button">
                                        <div class="dvJ" sort-name="" order-by="">
                                            <div class="tDv">Tồn đầu kì</div>
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
                                <div class="dcB col-1" role="presentation">
                                    <div class="dWB" role="button">
                                        <div class="dvJ" sort-name="" order-by="">
                                            <div class="tDv">Nhập kho</div>
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
                                <div class="dcB col-1" role="presentation">
                                    <div class="dWB" role="button">
                                        <div class="dvJ" sort-name="" order-by="">
                                            <div class="tDv">Xuất kho</div>
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
                                <div class="dcB col-1" role="presentation">
                                    <div class="dWB" role="button">
                                        <div class="dvJ" sort-name="" order-by="">
                                            <div class="tDv">Tồn cuối kì</div>
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
                                <div class="dcB col-2" role="presentation">
                                    <div class="dWB" role="button" sort-name="" order-by="">
                                        <div class="dvJ">
                                            <div class="tDv">Số lượng giữ</div>
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
                                <div class="dcB col-2" role="presentation">
                                    <div class="dWB" role="button" sort-name="" order-by="">
                                        <div class="dvJ">
                                            <div class="tDv">Series</div>
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
                                <div class="dcB col-1" role="presentation">
                                    <div class="dWB" role="button" sort-name="prd_note" order-by=""
                                         onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">Ghi chú</div>
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
                                @foreach($report as $row)
                                    <div class="jvD"
                                         ondblclick="jQuery.UbizOIWidget.w_go_to_input_page({{$row->prd_id}}, this)">
                                        <div class="tcB col-1">
                                            <div class="cbo">
                                                <div class="nCT" title="{{$row->brd_name}}">
                                                    <span>{{$row->brd_name}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-1">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$row->prd_name}}">
                                                    <span>{{$row->prd_name}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-1">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$row->prd_unit}}">
                                                    <span>{{$row->prd_unit}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-1">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$row->start_time_cnt}}">
                                                    <span>{{$row->start_time_cnt}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-1">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$row->import_cnt}}">
                                                    <span>{{$row->import_cnt}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-1">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$row->export_cnt}}">
                                                    <span>{{$row->export_cnt}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-1">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$row->end_time_cnt}}">
                                                    <span>{{$row->end_time_cnt}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-1">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$row->keep_prd_cnt}}">
                                                    <span>{{$row->keep_prd_cnt}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-2">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$row->serial_no_list}}">
                                                    <span>{{$row->serial_no_list??'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;–'}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-1">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$row->prd_note}}">
                                                    <span>{{$row->prd_note}}</span>
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
        </div>
    </div>
    <div id="export-rep-modal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close-modal-export close-modal-btn">&times;</span>
            <form id="f-export-rep" enctype="multipart/form-data" method="POST">
            {{ csrf_field() }}
            <p><input type="file" name="fileExportRep"></p>
            </form>
            <span class="btn btn-info export-rep" onclick="jQuery.UbizOIWidget.w_export_rep()"> Thực hiện </span>
        </div>

    </div>
    <div id="import-rep-modal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close-modal-import close-modal-btn" style="float:right">&times;</span>
            <form id="f-import-rep" enctype="multipart/form-data" method="POST">
            {{ csrf_field() }}
            <p><input type="file" name="fileImportRep"></p>
            </form>
            <span class="btn btn-info import-rep" onclick="jQuery.UbizOIWidget.w_import_rep()"> Thực hiện </span>
        </div>

    </div>
@endsection
@section('end-javascript')
    <script type="text/javascript" src="{{ asset('js/report.js') }}"></script>
@endsection