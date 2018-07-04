@extends('layouts.main')
@section('title','Nhân viên')
@section('headbar-title','Nhân viên')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/user.css') }}">
@endsection
@section('sidebar')
    @section('search')
        @include('user_search')
        @section('headbar-icon')
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M9 11.75c-.69 0-1.25.56-1.25 1.25s.56 1.25 1.25 1.25 1.25-.56 1.25-1.25-.56-1.25-1.25-1.25zm6 0c-.69 0-1.25.56-1.25 1.25s.56 1.25 1.25 1.25 1.25-.56 1.25-1.25-.56-1.25-1.25-1.25zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8 0-.29.02-.58.05-.86 2.36-1.05 4.23-2.98 5.21-5.37C11.07 8.33 14.05 10 17.42 10c.78 0 1.53-.09 2.25-.26.21.71.33 1.47.33 2.26 0 4.41-3.59 8-8 8z"/>
                <path fill="none" d="M0 0h24v24H0z"/>
            </svg>
        @endsection
    @endsection
    @include('layouts/sidebar')
@endsection
@section('content')
    <div class="main-content">
        <div class="l-content">
            <div class="zY">
                <div class="yP" onclick="goToInputPage(this)">Thêm mới</div>
            </div>
            <div id="nicescroll-sidebar" class="zX">
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
                                    <div class="GNi">
                                        <div class="ax7 poK utooltip" title="Chọn">
                                            <div class="asA">
                                                <div class="asC"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="GNi" onclick="refreshOutputPage(this)">
                                        <div class="ax7 poK utooltip" title="Làm mới">
                                            <div class="asA">
                                                <div class="asF"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="GNi">
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
                                    <div class="amH" style="user-select: none">
                                        <span class="Dj"><span><span class="ts">1</span>–<span class="ts">50</span></span> / <span class="ts">229</span></span>
                                    </div>
                                    <div class="amD utooltip" title="Cũ hơn">
                                        <span class="amF">&nbsp;</span>
                                        <img class="amI" src="http://ubiz.local/images/cleardot.gif" alt="">
                                    </div>
                                    <div class="amD utooltip" title="Mới hơn">
                                        <span class="amF">&nbsp;</span>
                                        <img class="amJ" src="http://ubiz.local/images/cleardot.gif" alt="">
                                    </div>
                                    <div class="amD utooltip" title="Cài đặt">
                                        <span class="amF">&nbsp;</span>
                                        <img class="amG" src="http://ubiz.local/images/cleardot.gif" alt="">
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
                                <div class="dcB col-1" role="presentation">
                                    <div class="dWB" role="button">
                                        <div class="dvJ">
                                            <div class="tDv">Mã</div>
                                            <div class="mhH">
                                                <div class="acD">
                                                    <div class="huK">
                                                        <svg class="faH" x="0px" y="0px" width="18px" height="18px"
                                                             viewBox="0 0 48 48" focusable="false" fill="#000000">
                                                            <path fill="none" d="M0 0h48v48H0V0z"></path>
                                                            <path d="M8 24l2.83 2.83L22 15.66V40h4V15.66l11.17 11.17L40 24 24 8 8 24z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="dcB col-2" role="presentation">
                                    <div class="dWB" role="button">
                                        <div class="dvJ">
                                            <div class="tDv">Tên</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="dcB col-3" role="presentation">
                                    <div class="dWB" role="button">
                                        <div class="dvJ">
                                            <div class="tDv">E-mail</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="dcB col-4" role="presentation">
                                    <div class="dWB" role="button">
                                        <div class="dvJ">
                                            <div class="tDv">Điện thoại</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="dcB col-5" role="presentation">
                                    <div class="dWB" role="button">
                                        <div class="dvJ">
                                            <div class="tDv">Phòng ban</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="dcB col-6" role="presentation">
                                    <div class="dWB" role="button">
                                        <div class="dvJ">
                                            <div class="tDv">Địa chỉ</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="aqB" id="nicescroll-oput">
                        <div class="yTP">
                            <div class="jFr">
                                @foreach($data as $user)
                                    <div class="jvD" ondblclick="goToInputPage(this)">
                                        <div class="tcB col-1">
                                            <div class="cbo">
                                                <div class="asC"></div>
                                                <div class="nCj">
                                                    <span>{{$user->code}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-2">
                                            <div class="cbo">
                                                <div class="nCj">
                                                    <span>{{$user->name}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-3">
                                            <div class="cbo">
                                                <div class="nCj">
                                                    <span>{{$user->email}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-4">
                                            <div class="cbo">
                                                <div class="nCj">
                                                    <span>{{$user->phone}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-5">
                                            <div class="cbo">
                                                <div class="nCj">
                                                    <span>{{$user->dep_id}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-6">
                                            <div class="cbo">
                                                <div class="nCj">
                                                    <span>{{$user->address}}</span>
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
                                    <div class="GNi" onclick="goBackToOutputPage(this)">
                                        <div class="ax7 poK utooltip" title="Quay lại">
                                            <div class="asA">
                                                <div class="arB"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="GNi">
                                        <div class="ax7 poK utooltip" title="Lưu trữ">
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
                                        <div class="ax7 poK utooltip" title="Xóa">
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
                                            <span><span class="ts">1</span></span> / <span class="ts">229</span>
                                        </span>
                                    </div>
                                    <div class="amD utooltip" title="Cũ hơn">
                                        <span class="amF">&nbsp;</span>
                                        <img class="amI" src="http://ubiz.local/images/cleardot.gif" alt="">
                                    </div>
                                    <div class="amD utooltip" title="Mới hơn">
                                        <span class="amF">&nbsp;</span>
                                        <img class="amJ" src="http://ubiz.local/images/cleardot.gif" alt="">
                                    </div>
                                    <div class="amD utooltip" title="Cài đặt">
                                        <span class="amF">&nbsp;</span>
                                        <img class="amG" src="http://ubiz.local/images/cleardot.gif" alt="">
                                    </div>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="jAQ">
                    <div class="aqI" id="nicescroll-iput">
                        <div style="height: 200px;">a</div>
                        <div style="height: 200px;">a</div>
                        <div style="height: 200px;">a</div>
                        <div style="height: 200px;">a</div>
                        <div style="height: 200px;">a</div>
                        <div style="height: 200px;">a</div>
                        <div style="height: 200px;">a</div>
                        <div style="height: 200px;">a</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('end-javascript')
    <script type="text/javascript" src="{{ asset('js/user.js') }}"></script>
@endsection