@extends('layouts.main')
@section('title',__("Employee"))
@section('headbar-title', __("Employee"))
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/headbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/user.css') }}">
@endsection
@section('headbar')
    @section('search')
        @include('users_search')
    @endsection
    @include('layouts/headbar')
@endsection
@section('content')
    <div class="main-content">
        <div class="l-content">
            <div class="zY">
                <div class="yP" onclick="jQuery.UbizOIWidget.w_go_to_input_page(0, 0)">{{ __("Add new") }}</div>
            </div>
            <div id="nicescroll-sidebar" class="zX nicescroll">
                @include('setting_menu',['employee'=>'aT'])
            </div>
        </div>
        <div class="m-content"></div>
        <div class="r-content">
            <div class="jAQ" id="o-put" >
                <div class="bkK">
                    <div class="aeH">
                        <div class="aqK">
                            <div class="aqL">
                                <div class="GtF">
                                    <div class="GNi" onclick="jQuery.UbizOIWidget.w_f_checkbox_click(this)">
                                        <div class="ax7 poK utooltip" title="{{ __("Select") }}">
                                            <div class="asA">
                                                <div class="asU ckb-f"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="GNi" onclick="jQuery.UbizOIWidget.w_refresh_output_page(this)">
                                        <div class="ax7 poK utooltip" title="{{ __("Refresh") }}">
                                            <div class="asA">
                                                <div class="asF"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="GNi" onclick="jQuery.UbizOIWidget.w_o_delete()">
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
                            <div class="aqJ">
                                <div class="ar5">
                                <span class="Di">
                                    @include('layouts/paging',['paging'=>$paging])
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
                                    <div class="dWB dWT" role="button" sort-name="code" order-by="asc" onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">{{ __('Code') }}</div>
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
                                    <div class="dWB" role="button" sort-name="name" order-by="" onclick="jQuery.UbizOIWidget.w_sort(this)">
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
                                <div class="dcB col-3" role="presentation">
                                    <div class="dWB" role="button" sort-name="email" order-by="" onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">{{ __('E-mail') }}</div>
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
                                    <div class="dWB" role="button" sort-name="phone" order-by="" onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">{{ __('Phone') }}</div>
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
                                    <div class="dWB" role="button">
                                        <div class="dvJ" sort-name="dep_name" order-by="" onclick="jQuery.UbizOIWidget.w_sort(this)">
                                            <div class="tDv">{{ __('Department') }}</div>
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
                                    <div class="dWB" role="button">
                                        <div class="dvJ" sort-name="com_nm" order-by="" onclick="jQuery.UbizOIWidget.w_sort(this)">
                                            <div class="tDv">{{ __('Company') }}</div>
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
                                    <div class="dWB" role="button" sort-name="address" order-by="" onclick="jQuery.UbizOIWidget.w_sort(this)">
                                        <div class="dvJ">
                                            <div class="tDv">{{ __('Address') }}</div>
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
                    <div class="aqB nicescroll" id="nicescroll-oput">
                        <div class="yTP">
                            <div id="table-content" class="jFr">
                                @foreach($users as $key => $user)
                                    <div class="jvD" ondblclick="jQuery.UbizOIWidget.w_go_to_input_page({{ $key + 1 }}, {{$user->id}})">
                                        <div class="tcB col-1">
                                            <div class="cbo">
                                                <div class="jgQ" onclick="jQuery.UbizOIWidget.w_c_checkbox_click(this)">
                                                    <input type="checkbox" class="ckb-i" value="{{$user->id}}" style="display: none"/>
                                                    <div class="asU ckb-c"></div>
                                                </div>
                                                <div class="nCT" title="{{$user->code}}">
                                                    <span>{{$user->code}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-2">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$user->name}}">
                                                    <span>{{$user->name}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-3">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$user->email}}">
                                                    <span>{{$user->email}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-4">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$user->phone}}">
                                                    <span>{{$user->phone}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-5">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$user->dep_name}}">
                                                    <span>{{$user->dep_name}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-6">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$user->com_nm}}">
                                                    <span>{{$user->com_nm}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tcB col-7">
                                            <div class="cbo">
                                                <div class="nCj" title="{{$user->address}}">
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
            <div class="jAQ" id="i-put" style="display: none">
                <div class="bkK">
                    <div class="aeH">
                        <div class="aqK">
                            <div class="aqL">
                                <div class="GtF">
                                    <div class="GNi" onclick="jQuery.UbizOIWidget.w_go_back_to_output_page()">
                                        <div class="ax7 poK utooltip" title="{{ __("Back to the list page") }}">
                                            <div class="asA">
                                                <div class="arB"></div>
                                            </div>
                                        </div>
                                    </div>
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
                                    <div id="btn-delete" class="GNi" onclick="jQuery.UbizOIWidget.w_i_delete()">
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
                        <input type="hidden" id="txt_id" value="0">
                        <div class="row z-mgl z-mgr">
                            <div class="col-sm-2 col-md-2 col-xl-2 z-pdl">
                                @include('components.upload_image')
                            </div>
                            <div class="col-sm-5 col-md-5 col-xl-5">
                                @include('components.input',['control_id'=>'txt_code', 'width'=>'150', 'label'=>__('Code')])
                                @include('components.input',['control_id'=>'txt_name', 'label'=>__('Name')])
                                @include('components.input',['control_id'=>'txt_rank', 'label'=>__('Duty')])
                                @include('components.dropdown',['control_id'=>'txt_dep_id', 'label'=>__('Department'), 'data'=> convertDataToDropdownOptions($departments, 'id', 'dep_name')])
                                @include('components.dropdown',['control_id'=>'txt_com_id', 'label'=>__('Company'), 'data'=> convertDataToDropdownOptions($companies, 'com_id', 'com_nm')])
                                @include('components.input',['control_id'=>'txt_phone', 'label'=>__('Phone')])
                                @include('components.input',['control_id'=>'txt_email', 'label'=>__('E-Mail')])
                            </div>
                            <div class="col-sm-5 col-md-5 col-xl-5 z-pdr">
                                @include('components.input',['control_id'=>'txt_address', 'label'=>__('Address')])
                                @include('components.input',['control_id'=>'txt_join_date', 'class'=>'i-date', 'label'=>__('Join Date')])
                                @include('components.input',['control_id'=>'txt_salary', 'class'=>'i-numeric', 'label'=>__('Salary')])
                                @include('components.checkbox',['control_id'=>'txt_bhxh', 'width'=>'150', 'value'=>'0', 'checked' => false, 'label'=>__('Social Insurance')])
                                @include('components.checkbox',['control_id'=>'txt_bhyt', 'width'=>'150', 'value'=>'0', 'checked' => false, 'label'=>__('Health Insurance')])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('end-javascript')
    <script type="text/javascript" src="{{ asset('js/user.js') }}"></script>
    <script type="text/javascript">
        jQuery.UbizOIWidget.rows_num = {{ intval($paging['rows_num']) }};
    </script>
@endsection