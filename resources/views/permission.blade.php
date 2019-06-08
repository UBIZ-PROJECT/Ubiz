@extends('layouts.main')
@section('title',__("Permission Setting"))
@section('headbar-title', __("Permission Setting"))
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/headbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/permission.css') }}">
@endsection
@section('headbar')
@section('headbar-icon')
    <i class="material-icons cl-header">
        security
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
                                    <div class="GNi" onclick="jQuery.Permission.save()">
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
                            <div class="col lEF" style="max-width: 300px">
                                <i class="material-icons">
                                    business
                                </i>
                                <span>{{__('Department')}}</span>
                            </div>
                            <div class="col lEF" style="max-width: 300px">
                                <i class="material-icons">
                                    vibration
                                </i>
                                <span>{{__('Screen')}}</span>
                            </div>
                            <div class="col lEF" style="max-width: 100%px">
                                <i class="material-icons">
                                    extension
                                </i>
                                <span>{{__('Function')}}</span>
                            </div>
                        </div>
                        <div class="row kuk">
                            <div class="col twA" style="max-width: 300px">
                                <div class="mOa nicescroll" id="nicescroll-1">
                                    <div id="dep-ctn">
                                        <table>
                                            <?php $sel_class = "dep-sel";?>
                                            @foreach($departments as $department)
                                                <tbody>
                                                <tr class="fck clp">
                                                    <td>
                                                        <div dep_id="{{ $department->id }}"
                                                             onclick="jQuery.Permission.department_click({{ $department->id }}, this)"
                                                             class="dep klo {{ $sel_class }}">
                                                            <div class="leo">
                                                                <i onclick="jQuery.Permission.collapse_click(this, event)"
                                                                   class="material-icons">
                                                                    chevron_right
                                                                </i>
                                                                <i onclick="jQuery.Permission.expand_click(this, event)"
                                                                   class="material-icons">
                                                                    expand_more
                                                                </i>
                                                            </div>
                                                            <div class="pad">
                                                                <i class="material-icons">
                                                                    {{ $department->dep_icon }}
                                                                </i>
                                                            </div>
                                                            <div class="kao">
                                                                <span class="qYt">{{ $department->dep_name }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="oiw">
                                                            @foreach($department->users as $user)
                                                                <div usr_id="{{ $user->id }}"
                                                                     dep_id="{{ $user->dep_id }}"
                                                                     onclick="jQuery.Permission.user_click({{ $user->dep_id }},{{ $user->id }},this)"
                                                                     class="user klo">
                                                                    <div class="pad">
                                                                        <img src="{{ $user->avatar }}"/>
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
                                                <?php $sel_class = "";?>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col twA" style="max-width: 300px">
                                <div class="mOa nicescroll" id="nicescroll-2">
                                    <div id="scr-ctn">
                                        <?php $sel_class = "scr-sel";?>
                                        @foreach($screens as $screen)
                                            <div scr_id="{{ $screen->scr_id }}"
                                                 onclick="jQuery.Permission.screen_click({{ $screen->scr_id }}, this)"
                                                 class="scr klo {{ $sel_class }}">
                                                <div class="pad">
                                                    <i class="material-icons">
                                                        {{ $screen->scr_icon }}
                                                    </i>
                                                </div>
                                                <div class="kao">
                                                    <span class="qYt">{{ $screen->scr_name }}</span>
                                                </div>
                                            </div>
                                            <?php $sel_class = "";?>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col twA" style="max-width: 100%">
                                <div class="mOa nicescroll" id="nicescroll-3">
                                    <div id="fnc-ctn">
                                        <table class="ngv">
                                            <thead>
                                            <tr>
                                                <th class="cst-col-1">&nbsp</th>
                                                @if($for == 'user')
                                                    <th class="cst-col-2">
                                                        <span class="qYt">{{ __("Allow") }}</span>
                                                    </th>
                                                    <th class="cst-col-3">
                                                        <span class="qYt">{{ __("Inherited") }}</span>
                                                    </th>
                                                @else
                                                    <th class="cst-col-2">
                                                        <span class="qYt">{{ __("Allow") }}</span>
                                                    </th>
                                                    <th  class="cst-col-3"></th>
                                                @endif
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($permissions as $permission)
                                                <tr>
                                                    <td class="cst-col-1">
                                                        <div class="klk">
                                                            <div class="pad">
                                                                <i class="material-icons">
                                                                    {{ $permission->fnc_icon }}
                                                                </i>
                                                            </div>
                                                            <div class="kao">
                                                                <span class="qYt">{{ $permission->fnc_name }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    @if($for == 'user')
                                                        <td class="cst-col-2">
                                                            <input name="usr_allow" class="chk"
                                                                   pkey="{{ $permission->pkey }}"
                                                                   dep_id="{{ $permission->dep_id }}"
                                                                   scr_id="{{ $permission->scr_id }}"
                                                                   fnc_id="{{ $permission->fnc_id }}"
                                                                   usr_id="{{ $permission->usr_id }}"
                                                                   type="checkbox" {{ $permission->usr_allow == '1'? 'checked' : ''}}>
                                                        </td>
                                                        <td class="cst-col-3">
                                                            <input disabled name="dep_allow" class="chk"
                                                                   dep_id="{{ $permission->dep_id }}"
                                                                   scr_id="{{ $permission->scr_id }}"
                                                                   fnc_id="{{ $permission->fnc_id }}"
                                                                   type="checkbox" {{ $permission->dep_allow == '1'? 'checked' : ''}}>
                                                        </td>
                                                    @else
                                                        <td class="cst-col-2">
                                                            <input name="dep_allow" class="chk"
                                                                   pkey="{{ $permission->pkey }}"
                                                                   dep_id="{{ $permission->dep_id }}"
                                                                   scr_id="{{ $permission->scr_id }}"
                                                                   fnc_id="{{ $permission->fnc_id }}"
                                                                   type="checkbox" {{ $permission->dep_allow == '1'? 'checked' : ''}}>
                                                        </td>
                                                        <td class="cst-col-3"></td>
                                                    @endif

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
    </div>
@endsection
@section('end-javascript')
    <script type="text/javascript" src="{{ asset('js/permission.js') }}"></script>
@endsection