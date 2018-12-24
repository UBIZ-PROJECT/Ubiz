@extends('layouts.main')
@section('title',__("Permission"))
@section('headbar-title', __("Permission"))
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/headbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/permission.css') }}">
@endsection
@section('headbar')
@section('headbar-icon')
    <i class="material-icons cl-header">
        verified_user
    </i>
@endsection
@include('layouts/headbar')
@endsection
@section('content')
    <div class="main-content">
        <div class="l-content">
            <div id="nicescroll-sidebar" class="zX nicescroll">
                @include('setting_menu',['permission'=>'aT'])
            </div>
        </div>
        <div class="m-content"></div>
        <div class="r-content">
            <div class="jAQ" id="o-put">
                <div class="bkK" style="margin-bottom: 5px">
                    <div class="aeH">
                        <div class="aqK">
                            <div class="aqL">
                                <div class="GtF">
                                    <div class="GNi" onclick="jQuery.UbizOIWidget.w_save()">
                                        <div class="ax7 poK utooltip" title="{{ __("Save") }}">
                                            <div class="asA">
                                                <div class="arS"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="GNi" onclick="jQuery.UbizOIWidget.w_refresh()">
                                        <div class="ax7 poK utooltip" title="{{ __("Refresh") }}">
                                            <div class="asA">
                                                <div class="arR"></div>
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
                <div class="jAQ">

                        <div class="yTP">
                            <div class="row kuk">
                                <div class="col lEF" style="max-width: 250px">
                                    <i class="material-icons">
                                        business
                                    </i>
                                    <span>{{__('Department')}}</span>
                                </div>
                                <div class="col lEF" style="max-width: 250px">
                                    <i class="material-icons">
                                        vibration
                                    </i>
                                    <span>{{__('Screen')}}</span>
                                </div>
                                <div class="col lEF" style="max-width: 400px">
                                    <i class="material-icons">
                                        extension
                                    </i>
                                    <span>{{__('Function')}}</span>
                                </div>
                            </div>
                            <div class="row kuk">
                                <div class="col twA" style="max-width: 250px">
                                    <div class="mOa nicescroll" id="nicescroll-1">
                                        <table>
                                            <tbody>
                                            <tr class="fck">
                                                <td>
                                                    <div class="klo">
                                                        <div class="leo">
                                                            <i class="material-icons aT">
                                                                arrow_right
                                                            </i>
                                                            <i class="material-icons">
                                                                arrow_drop_down
                                                            </i>
                                                        </div>
                                                        <div class="pad">
                                                            <i class="material-icons">
                                                                supervised_user_circle
                                                            </i>
                                                        </div>
                                                        <div class="kao">
                                                            <span class="qYt">Nhân sự</span>
                                                        </div>
                                                    </div>
                                                    <div class="oiw">
                                                        <div class="klo">
                                                            <div class="pad">
                                                                <i class="material-icons">
                                                                    account_box
                                                                </i>
                                                            </div>
                                                            <div class="kao">
                                                                <span class="qYt">Bùi Anh Tuấn</span>
                                                            </div>
                                                        </div>
                                                        <div class="klo">
                                                            <div class="pad">
                                                                <i class="material-icons">
                                                                    account_box
                                                                </i>
                                                            </div>
                                                            <div class="kao">
                                                                <span class="qYt">Thái Văn Lung</span>
                                                            </div>
                                                        </div>
                                                        <div class="klo">
                                                            <div class="pad">
                                                                <i class="material-icons">
                                                                    account_box
                                                                </i>
                                                            </div>
                                                            <div class="kao">
                                                                <span class="qYt">Đoàn Văn Hậu</span>
                                                            </div>
                                                        </div>
                                                        <div class="klo">
                                                            <div class="pad">
                                                                <i class="material-icons">
                                                                    account_box
                                                                </i>
                                                            </div>
                                                            <div class="kao">
                                                                <span class="qYt">Ưng Hoàng Phúc</span>
                                                            </div>
                                                        </div>
                                                        <div class="klo">
                                                            <div class="pad">
                                                                <i class="material-icons">
                                                                    account_box
                                                                </i>
                                                            </div>
                                                            <div class="kao">
                                                                <span class="qYt">Đinh Thị Kim Mỹ</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tbody>
                                            <tr class="fck">
                                                <td>
                                                    <div class="klo">
                                                        <div class="leo">
                                                            <i class="material-icons aT">
                                                                arrow_right
                                                            </i>
                                                            <i class="material-icons">
                                                                arrow_drop_down
                                                            </i>
                                                        </div>
                                                        <div class="pad">
                                                            <i class="material-icons">
                                                                work
                                                            </i>
                                                        </div>
                                                        <div class="kao">
                                                            <span class="qYt">Kinh doanh</span>
                                                        </div>
                                                    </div>
                                                    <div class="oiw">
                                                        <div class="klo">
                                                            <div class="pad">
                                                                <i class="material-icons">
                                                                    account_box
                                                                </i>
                                                            </div>
                                                            <div class="kao">
                                                                <span class="qYt">Nguyễn Huy Hoàng</span>
                                                            </div>
                                                        </div>
                                                        <div class="klo">
                                                            <div class="pad">
                                                                <i class="material-icons">
                                                                    account_box
                                                                </i>
                                                            </div>
                                                            <div class="kao">
                                                                <span class="qYt">Nguyễn Công Phượng</span>
                                                            </div>
                                                        </div>
                                                        <div class="klo">
                                                            <div class="pad">
                                                                <i class="material-icons">
                                                                    account_box
                                                                </i>
                                                            </div>
                                                            <div class="kao">
                                                                <span class="qYt">Trần Mai Trang</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col twA" style="max-width: 250px">
                                    <div class="mOa nicescroll" id="nicescroll-2">
                                        <div class="klo">
                                            <div class="pad">
                                                <i class="material-icons">
                                                    supervised_user_circle
                                                </i>
                                            </div>
                                            <div class="kao">
                                                <span class="qYt">Thông tin công ty</span>
                                            </div>
                                        </div>
                                        <div class="klo">
                                            <div class="pad">
                                                <i class="material-icons">
                                                    supervised_user_circle
                                                </i>
                                            </div>
                                            <div class="kao">
                                                <span class="qYt">Phân quyền</span>
                                            </div>
                                        </div>
                                        <div class="klo">
                                            <div class="pad">
                                                <i class="material-icons">
                                                    supervised_user_circle
                                                </i>
                                            </div>
                                            <div class="kao">
                                                <span class="qYt">Tiền tệ</span>
                                            </div>
                                        </div>
                                        <div class="klo">
                                            <div class="pad">
                                                <i class="material-icons">
                                                    supervised_user_circle
                                                </i>
                                            </div>
                                            <div class="kao">
                                                <span class="qYt">Nhân viên</span>
                                            </div>
                                        </div>
                                        <div class="klo">
                                            <div class="pad">
                                                <i class="material-icons">
                                                    supervised_user_circle
                                                </i>
                                            </div>
                                            <div class="kao">
                                                <span class="qYt">Khách hàng</span>
                                            </div>
                                        </div>
                                        <div class="klo">
                                            <div class="pad">
                                                <i class="material-icons">
                                                    supervised_user_circle
                                                </i>
                                            </div>
                                            <div class="kao">
                                                <span class="qYt">Nhà cung cấp</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col twA" style="max-width: 400px">
                                    <div class="mOa nicescroll" id="nicescroll-3">
                                        <table class="ngv">
                                            <tbody>
                                            <tr>
                                                <td style="width: 240px">&nbsp;</td>
                                                <td style="width: 50px">
                                                    <span>Allow</span>
                                                </td>
                                                <td style="width: 90px">
                                                    <span>Inherited</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="klo">
                                                        <div class="pad">
                                                            <i class="material-icons">
                                                                supervised_user_circle
                                                            </i>
                                                        </div>
                                                        <div class="kao">
                                                            <span class="qYt">Danh sách</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <i class="material-icons">
                                                        check_box_outline_blank
                                                    </i>
                                                </td>
                                                <td>
                                                    <i class="material-icons">
                                                        check_box
                                                    </i>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="klo">
                                                        <div class="pad">
                                                            <i class="material-icons">
                                                                supervised_user_circle
                                                            </i>
                                                        </div>
                                                        <div class="kao">
                                                            <span class="qYt">Tìm kiếm</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <i class="material-icons">
                                                        check_box_outline_blank
                                                    </i>
                                                </td>
                                                <td>
                                                    <i class="material-icons">
                                                        check_box
                                                    </i>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="klo">
                                                        <div class="pad">
                                                            <i class="material-icons">
                                                                supervised_user_circle
                                                            </i>
                                                        </div>
                                                        <div class="kao">
                                                            <span class="qYt">Sắp xếp</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <i class="material-icons">
                                                        check_box_outline_blank
                                                    </i>
                                                </td>
                                                <td>
                                                    <i class="material-icons">
                                                        check_box
                                                    </i>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="klo">
                                                        <div class="pad">
                                                            <i class="material-icons">
                                                                supervised_user_circle
                                                            </i>
                                                        </div>
                                                        <div class="kao">
                                                            <span class="qYt">Thêm</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <i class="material-icons">
                                                        check_box_outline_blank
                                                    </i>
                                                </td>
                                                <td>
                                                    <i class="material-icons">
                                                        check_box
                                                    </i>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="klo">
                                                        <div class="pad">
                                                            <i class="material-icons">
                                                                supervised_user_circle
                                                            </i>
                                                        </div>
                                                        <div class="kao">
                                                            <span class="qYt">Xóa</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <i class="material-icons">
                                                        check_box_outline_blank
                                                    </i>
                                                </td>
                                                <td>
                                                    <i class="material-icons">
                                                        check_box
                                                    </i>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="klo">
                                                        <div class="pad">
                                                            <i class="material-icons">
                                                                supervised_user_circle
                                                            </i>
                                                        </div>
                                                        <div class="kao">
                                                            <span class="qYt">Sửa</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <i class="material-icons">
                                                        check_box_outline_blank
                                                    </i>
                                                </td>
                                                <td>
                                                    <i class="material-icons">
                                                        check_box
                                                    </i>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
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
    <script type="text/javascript" src="{{ asset('js/permission.js') }}"></script>
@endsection