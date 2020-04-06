@extends('layouts.main')
@section('title',__("Account"))
@section('headbar-title', __("Account"))
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/headbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/user.css') }}">
@endsection
@section('headbar')
    @include('layouts/headbar')
@endsection
@section('content')
    <div class="main-content">
        <div class="l-content"></div>
        <div class="m-content"></div>
        <div class="r-content">
            <div class="jAQ" id="i-put">
                <div class="bkK">
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
                                    <div class="GNi" onclick="jQuery.UbizOIWidget.w_change_passwd()">
                                        <div class="ax7 poK utooltip" title="{{ __("Change password") }}">
                                            <div class="asA">
                                                <div class="arP"></div>
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
                        <input type="hidden" id="txt_id" value="{{$account->id}}">
                        <div class="row z-mgl z-mgr">
                            <div class="col-sm-2 col-md-2 col-xl-2 z-pdl">
                                @include('components.upload_image', ['src'=>$account->avatar])
                            </div>
                            <div class="col-sm-5 col-md-5 col-xl-5">
                                @include('components.input',['control_id'=>'txt_code', 'type'=>'disabled', 'value'=>$account->code, 'i_focus'=>'', 'i_blur'=>'','width'=>'150', 'label'=>__('Code')])
                                @include('components.input',['control_id'=>'txt_name', 'value'=>$account->name, 'i_focus'=>'', 'i_blur'=>'','label'=>__('Name')])
                                @include('components.input',['control_id'=>'txt_rank', 'value'=>$account->rank, 'type'=>'disabled', 'i_focus'=>'', 'i_blur'=>'','label'=>__('Duty')])
                                @include('components.dropdown',['control_id'=>'txt_dep_id', 'value'=>$account->dep_id, 'type'=>'disabled', 'label'=>__('Department'), 'data'=> convertDataToDropdownOptions($departments, 'id', 'dep_name')])
                                @include('components.dropdown',['control_id'=>'txt_com_id', 'value'=>$account->com_id, 'type'=>'disabled','label'=>__('Company'), 'data'=> convertDataToDropdownOptions($companies, 'com_id', 'com_nm')])
                                @include('components.input',['control_id'=>'txt_phone', 'value'=>$account->phone, 'i_focus'=>'', 'i_blur'=>'','label'=>__('Phone')])
                                @include('components.input',['control_id'=>'txt_email', 'value'=>$account->email, 'type'=>'disabled', 'i_focus'=>'', 'i_blur'=>'','label'=>__('E-Mail')])
                            </div>
                            <div class="col-sm-5 col-md-5 col-xl-5 z-pdr">
                                @include('components.input',['control_id'=>'txt_address', 'value'=>$account->address, 'i_focus'=>'', 'i_blur'=>'','label'=>__('Address')])
                                @include('components.input',['control_id'=>'txt_join_date', 'value'=>date('Y/m/d', strtotime($account->join_date)), 'type'=>'disabled', 'i_focus'=>'', 'i_blur'=>'','class'=>'i-date', 'label'=>__('Join Date')])
                                @include('components.input',['control_id'=>'txt_salary', 'value'=>number_format($account->salary), 'type'=>'disabled', 'i_focus'=>'', 'i_blur'=>'','class'=>'i-numeric', 'label'=>__('Salary')])
                                @include('components.checkbox',['control_id'=>'txt_bhxh', 'value'=>$account->bhxh,'checked'=>($account->bhxh == '1' ? true : false), 'type'=>'disabled', 'width'=>'150', 'value'=>$account->bhxh, 'label'=>__('Social Insurance')])
                                @include('components.checkbox',['control_id'=>'txt_bhyt', 'value'=>$account->bhyt,'checked'=>($account->bhyt == '1' ? true : false), 'type'=>'disabled', 'width'=>'150', 'value'=>$account->bhyt, 'label'=>__('Health Insurance')])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="change-passwd-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Change password') }}</h5>
                    <img name="ajax-loader" src="{{ asset('images/ajax-loader.gif') }}"
                         style="display: none; height: 28px; margin-left: 10px">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('components.password',['control_id'=>'old_passwd', 'length'=>'8', 'width'=>'300', 'label'=>__('Current Password')])
                    @include('components.password',['control_id'=>'new_passwd', 'length'=>'8', 'width'=>'300','label'=>__('New Password')])
                    @include('components.password',['control_id'=>'ver_passwd', 'length'=>'8', 'width'=>'300','label'=>__('Verify Password')])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="jQuery.UbizOIWidget.w_change_passwd_execute()">OK</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('end-javascript')
    <script type="text/javascript" src="{{ asset('js/myaccount.js') }}"></script>
@endsection