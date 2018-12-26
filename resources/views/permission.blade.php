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
                                        @foreach($departments as $department)
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
                                                            <span class="qYt">{{ $department->dep_name }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="oiw">
                                                        @foreach($department->users as $user)
                                                            <div class="klo">
                                                                <div class="pad">
                                                                    <i class="material-icons">
                                                                        account_box
                                                                    </i>
                                                                </div>
                                                                <div class="kao">
                                                                    <span class="qYt">{{ $user->name }}</span>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <div class="col twA" style="max-width: 250px">
                                <div class="mOa nicescroll" id="nicescroll-2">
                                    @foreach($screens as $screen)
                                        <div class="klo">
                                            <div class="pad">
                                                <i class="material-icons">
                                                    supervised_user_circle
                                                </i>
                                            </div>
                                            <div class="kao">
                                                <span class="qYt">{{ $screen->scr_name }}</span>
                                            </div>
                                        </div>
                                    @endforeach
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
                                        @foreach($functions as $function)
                                            <tr>
                                                <td>
                                                    <div class="klo">
                                                        <div class="pad">
                                                            <i class="material-icons">
                                                                supervised_user_circle
                                                            </i>
                                                        </div>
                                                        <div class="kao">
                                                            <span class="qYt">{{ $function->fn_name }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($function->user_allow == '1')
                                                        <i class="material-icons">
                                                            check_box
                                                        </i>
                                                    @else
                                                        <i class="material-icons">
                                                            check_box_outline_blank
                                                        </i>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($function->dep_allow == '1')
                                                        <i class="material-icons">
                                                            check_box
                                                        </i>
                                                    @else
                                                        <i class="material-icons">
                                                            check_box_outline_blank
                                                        </i>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
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