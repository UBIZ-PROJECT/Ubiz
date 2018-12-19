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
                    <div class="aqB nicescroll" id="nicescroll-oput">
                        <div class="yTP">
                            <table class="aKk">
                                <thead>
                                <tr class="aAA" style="user-select: none;">
                                    <td class="aRz" role="heading" style="user-select: none; width: 300px">
                                        <i class="material-icons">
                                            business
                                        </i>
                                        <span>{{__('Department')}}</span>
                                    </td>
                                    <td class="aRz" role="heading" style="user-select: none; width: 300px">
                                        <i class="material-icons">
                                            vibration
                                        </i>
                                        <span>{{__('Screen')}}</span>
                                    </td>
                                    <td class="aRz" role="heading" style="user-select: none; width: 300px">
                                        <i class="material-icons">
                                            extension
                                        </i>
                                        <span>{{__('Function')}}</span>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="aAA" style="user-select: none;">
                                    <td class="aRz" role="heading" style="user-select: none; width: 300px">
                                        <div class="tRE">
                                            <div class="lEF">
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
                                                        extension
                                                    </i>
                                                </div>
                                                <div class="kao">
                                                    <span class="qYt">AA</span>
                                                </div>

                                            </div>
                                            <div class="lEF suB">
                                                <div class="leo">
                                                </div>
                                                <div class="pad">
                                                    <i class="material-icons">
                                                        extension
                                                    </i>
                                                </div>
                                                <div class="kao">
                                                    <span class="qYt">AA</span>
                                                </div>
                                            </div>
                                            <div class="lEF suB">
                                                <div class="leo">
                                                </div>
                                                <div class="pad">
                                                    <i class="material-icons">
                                                        extension
                                                    </i>
                                                </div>
                                                <div class="kao">
                                                    <span class="qYt">AA</span>
                                                </div>
                                            </div>
                                            <div class="lEF suB">
                                                <div class="leo">
                                                </div>
                                                <div class="pad">
                                                    <i class="material-icons">
                                                        extension
                                                    </i>
                                                </div>
                                                <div class="kao">
                                                    <span class="qYt">AA</span>
                                                </div>
                                            </div>
                                            <div class="lEF suB">
                                                <div class="leo">
                                                </div>
                                                <div class="pad">
                                                    <i class="material-icons">
                                                        extension
                                                    </i>
                                                </div>
                                                <div class="kao">
                                                    <span class="qYt">AA</span>
                                                </div>
                                            </div>
                                            <div class="lEF suB">
                                                <div class="leo">
                                                </div>
                                                <div class="pad">
                                                    <i class="material-icons">
                                                        extension
                                                    </i>
                                                </div>
                                                <div class="kao">
                                                    <span class="qYt">AA</span>
                                                </div>
                                            </div>
                                            <div class="lEF">
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
                                                        extension
                                                    </i>
                                                </div>
                                                <div class="kao">
                                                    <span class="qYt">AA</span>
                                                </div>

                                            </div>
                                        </div>
                                    </td>
                                    <td class="aRz" role="heading" style="user-select: none; width: 300px">

                                    </td>
                                    <td class="aRz" role="heading" style="user-select: none; width: 300px">

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
@endsection
@section('end-javascript')
    <script type="text/javascript" src="{{ asset('js/permission.js') }}"></script>
@endsection