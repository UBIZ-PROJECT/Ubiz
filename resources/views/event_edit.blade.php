@extends('layouts.main')
@section('title',__("Events Calendar"))
@section('headbar-title', __("Events Calendar"))
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/headbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/air-datepicker/css/datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/event.css') }}">
@endsection
@section('headbar')
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
                                    <span class="dG">Lịch làm việc</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="m-content"></div>
        <div class="r-content">
            <div class="jAQ" id="i-put">
                <div class="bkK">
                    <div class="aeH">
                        <div class="aqK">
                            <div class="aqL">
                                <div class="GtF">
                                    <div class="goback" onclick="go_back_to_output()">
                                        <div class="ax7 poK utooltip" title="{{ __("Back") }}">
                                            <div class="asA">
                                                <div class="arB"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="save">
                                        <div class="ax7 poK utooltip" title="{{ __("Save") }}">
                                            <div class="asA">
                                                <div class="arS"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="refresh">
                                        <div class="ax7 poK utooltip" title="{{ __("Refresh") }}">
                                            <div class="asA">
                                                <div class="arR"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="delete">
                                        <div class="ax7 poK utooltip" title="{{ __("Delete") }}">
                                            <div class="asA">
                                                <div class="asX"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="jAQ">
                    <div class="aqI" id="nicescroll-iput">
                        <div class="row">
                            <input type="hidden" id="event-id" value="0">
                            <div class="col-md-6 col-lg-6">
                                <input type="text" style="width: 500px" class="form-control light-color" value="{{ $event['title'] }}" id="event-title" placeholder="{{ __('Add title') }}">
                            </div>
                        </div>
                        <hr>
                        <div class="row margin-bottom-15">
                            <div class="col-12">
                                <input type="text" readonly style="width: 140px" class="form-control light-color d-inline-flex text-center start-date" id="event-start-date">
                                <select readonly class="form-control light-color d-inline-flex justify-content-center w-auto"
                                        id="event-start-time">
                                    <option value="12:00am">12:00SA</option>
                                    <option value="12:30am">12:30SA</option>
                                    <option value="12:30am">1:00SA</option>
                                    <option value="1:30am">1:30SA</option>
                                    <option value="2:00am">2:00SA</option>
                                    <option value="2:30am">2:30SA</option>
                                    <option value="3:00am">3:00SA</option>
                                    <option value="3:30am">3:30SA</option>
                                    <option value="4:00am">4:00SA</option>
                                    <option value="4:30am">4:30SA</option>
                                    <option value="5:00am">5:00SA</option>
                                    <option value="5:30am">5:30SA</option>
                                    <option value="6:00am">6:00SA</option>
                                    <option value="6:30am">6:30SA</option>
                                    <option value="7:00am">7:00SA</option>
                                    <option value="7:30am">7:30SA</option>
                                    <option value="8:00am">8:00SA</option>
                                    <option value="8:30am">8:30SA</option>
                                    <option value="9:00am">9:00SA</option>
                                    <option value="9:30am">9:30SA</option>
                                    <option value="10:00am">10:00SA</option>
                                    <option value="10:30am">10:30SA</option>
                                    <option value="11:00am">11:00SA</option>
                                    <option value="11:30am">11:30SA</option>
                                    <option value="12:00pm">12:00CH</option>
                                    <option value="12:30pm">12:30CH</option>
                                    <option value="1:00pm">1:00CH</option>
                                    <option value="1:30pm">1:30CH</option>
                                    <option value="2:00pm">2:00CH</option>
                                    <option value="2:30pm">2:30CH</option>
                                    <option value="3:00pm">3:00CH</option>
                                    <option value="3:30pm">3:30CH</option>
                                    <option value="4:00pm">4:00CH</option>
                                    <option value="4:30pm">4:30CH</option>
                                    <option value="5:00pm">5:00CH</option>
                                    <option value="5:30pm">5:30CH</option>
                                    <option value="6:00pm">6:00CH</option>
                                    <option value="6:30pm">6:30CH</option>
                                    <option value="7:00pm">7:00CH</option>
                                    <option value="7:30pm">7:30CH</option>
                                    <option value="8:00pm">8:00CH</option>
                                    <option value="8:30pm">8:30CH</option>
                                    <option value="9:00pm">9:00CH</option>
                                    <option value="9:30pm">9:30CH</option>
                                    <option value="10:00pm">10:00CH</option>
                                    <option value="10:30pm">10:30CH</option>
                                    <option value="11:00pm">11:00CH</option>
                                    <option value="11:30pm">11:30CH</option>
                                </select>
                                <span class="d-inline-flex">&nbsp;{{ __('to') }}&nbsp;</span>
                                <select readonly class="form-control light-color d-inline-flex justify-content-center w-auto" id="event-end-time">
                                    <option value="12:00am">12:00SA</option>
                                    <option value="12:30am">12:30SA</option>
                                    <option value="12:30am">1:00SA</option>
                                    <option value="1:30am">1:30SA</option>
                                    <option value="2:00am">2:00SA</option>
                                    <option value="2:30am">2:30SA</option>
                                    <option value="3:00am">3:00SA</option>
                                    <option value="3:30am">3:30SA</option>
                                    <option value="4:00am">4:00SA</option>
                                    <option value="4:30am">4:30SA</option>
                                    <option value="5:00am">5:00SA</option>
                                    <option value="5:30am">5:30SA</option>
                                    <option value="6:00am">6:00SA</option>
                                    <option value="6:30am">6:30SA</option>
                                    <option value="7:00am">7:00SA</option>
                                    <option value="7:30am">7:30SA</option>
                                    <option value="8:00am">8:00SA</option>
                                    <option value="8:30am">8:30SA</option>
                                    <option value="9:00am">9:00SA</option>
                                    <option value="9:30am">9:30SA</option>
                                    <option value="10:00am">10:00SA</option>
                                    <option value="10:30am">10:30SA</option>
                                    <option value="11:00am">11:00SA</option>
                                    <option value="11:30am">11:30SA</option>
                                    <option value="12:00pm">12:00CH</option>
                                    <option value="12:30pm">12:30CH</option>
                                    <option value="1:00pm">1:00CH</option>
                                    <option value="1:30pm">1:30CH</option>
                                    <option value="2:00pm">2:00CH</option>
                                    <option value="2:30pm">2:30CH</option>
                                    <option value="3:00pm">3:00CH</option>
                                    <option value="3:30pm">3:30CH</option>
                                    <option value="4:00pm">4:00CH</option>
                                    <option value="4:30pm">4:30CH</option>
                                    <option value="5:00pm">5:00CH</option>
                                    <option value="5:30pm">5:30CH</option>
                                    <option value="6:00pm">6:00CH</option>
                                    <option value="6:30pm">6:30CH</option>
                                    <option value="7:00pm">7:00CH</option>
                                    <option value="7:30pm">7:30CH</option>
                                    <option value="8:00pm">8:00CH</option>
                                    <option value="8:30pm">8:30CH</option>
                                    <option value="9:00pm">9:00CH</option>
                                    <option value="9:30pm">9:30CH</option>
                                    <option value="10:00pm">10:00CH</option>
                                    <option value="10:30pm">10:30CH</option>
                                    <option value="11:00pm">11:00CH</option>
                                    <option value="11:30pm">11:30CH</option>
                                </select>
                                <input type="text" readonly style="width: 140px" class="form-control light-color d-inline-flex text-center end-date" id="event-end-date">
                            </div>
                        </div>
                        <div class="row margin-bottom-15">
                            <div class="col-12">
                                <table>
                                    <tbody>
                                    <tr style="line-height: 1px">
                                        <td>
                                            <input type="checkbox" onchange="event_all_day_change(this)" id="event-all-day" style="width: 15px; height: 15px">
                                        </td>
                                        <td>
                                            <span class="d-inline-flex">{{ __('All day') }}</span>
                                            {{--<select readonly class="form-control light-color d-inline-flex justify-content-center w-auto">--}}
                                            {{--<option>Does not repeat</option>--}}
                                            {{--<option>Daily</option>--}}
                                            {{--<option>Weekly on Monday</option>--}}
                                            {{--<option>Monthly on the third Monday</option>--}}
                                            {{--<option>Annually on July 20</option>--}}
                                            {{--<option>Every weekday (Monday to Friday)</option>--}}
                                            {{--</select>--}}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row margin-bottom-15">
                            <div class="col-md-8 col-lg-8">
                                <span class="text-primary">{{ __('Detail') }}</span>
                                <hr class="z-mgt">
                                <table>
                                    <tbody>
                                    <tr>
                                        <td style="height: 45px">
                                            <i class="fas fa-map-marker-alt text-primary mgr-10"></i>
                                        </td>
                                        <td>
                                            <input type="text" style="width: 500px" class="form-control light-color" id="event-location">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height: 45px">
                                            <i class="far fa-bell text-primary mgr-10"></i>
                                        </td>
                                        <td>
                                            <select readonly class="form-control light-color d-inline-flex justify-content-center w-auto">
                                                <option>Email</option>
                                            </select>
                                            {{--<input type="number" style="width: 70px" class="form-control light-color d-inline-flex" value="30">--}}
                                            {{--<select readonly class="form-control light-color d-inline-flex justify-content-center w-auto">--}}
                                            {{--<option>{{ __('Minutes') }}</option>--}}
                                            {{--<option>{{ __('Hours') }}</option>--}}
                                            {{--<option>{{ __('Days') }}</option>--}}
                                            {{--<option>{{ __('Weeks') }}</option>--}}
                                            {{--</select>--}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height: 45px">
                                            <i class="fas fa-tags text-primary mgr-10"></i>
                                        </td>
                                        <td>
                                            <span class="d-inline-flex" id="event-email"></span>
                                            <div id="event-tag-dropdown" class="btn-group">
                                                <button class="btn btn-sm light-color" type="button">
                                                    <i tag_id="" id="event-tag" class="fas fa-circle" title=""></i>
                                                </button>
                                                <button type="button" class="btn btn-sm light-color dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu z-pdt z-pdb">
                                                    @foreach($tags as $key => $tag)
                                                        <a tag_id="{{ $tag->id }}" tag_title="{{ $tag->title }}"
                                                           tag_color="{{ $tag->color }}"
                                                           class="dropdown-item media pdl-5"
                                                           onclick="epic_select_tag(this)" href="#">
                                                            <div style="width: 20px; height: 20px; line-height: 20px" class="mr-3">
                                                                <i class="fas fa-circle {{ $tag->color }}"></i>
                                                            </div>
                                                            <div class="media-body" style="height: 20px; line-height: 20px">
                                                                <h6 class="mt-0 mb-1">{{ $tag->title }}</h6>
                                                            </div>
                                                        </a>
                                                        @if($key < (sizeof($tags) - 1))
                                                            <div class="dropdown-divider z-mgt z-mgb"></div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;">
                                            <i class="fas fa-align-left text-primary mgr-10"></i>
                                        </td>
                                        <td>
                                            <textarea id="event_desc" class="form-control" name="txt_desc"></textarea>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="dropdown event-pic">
                                    <span class="text-primary">{{ __('Person in charge') }}</span>
                                    <i id="btn-assign" class="fas fa-cog float-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                                    <div class="dropdown-menu dropdown-menu-right z-pdt z-pdb margin-bottom-15 mgt-10"></div>
                                </div>
                                <hr class="z-mgt">
                                <ul class="list-group assigned-list list-group-flush margin-bottom-30" style="width: 300px"></ul>
                                <span>{{ __('Person in charge permission:') }}</span>
                                <table>
                                    <tbody>
                                    <tr style="line-height: 1px">
                                        <td style="height: 30px">
                                            <input id="event_pic_edit" type="checkbox" class="mgr-10 light-color" style="width: 15px; height: 15px">
                                        </td>
                                        <td>
                                            <span>{{ __('Edit') }}</span>
                                        </td>
                                    </tr>
                                    <tr style="line-height: 1px">
                                        <td style="height: 30px">
                                            <input id="event_pic_assign" type="checkbox" class="mgr-10" style="width: 15px; height: 15px">
                                        </td>
                                        <td>
                                            <span>{{ __('Add person in charge') }}</span>
                                        </td>
                                    </tr>
                                    <tr style="line-height: 1px">
                                        <td style="height: 30px">
                                            <input id="event_pic_see_list" type="checkbox" class="mgr-10" style="width: 15px; height: 15px">
                                        </td>
                                        <td>
                                            <span>{{ __('See the list of people in charge') }}</span>
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
@endsection
@section('end-javascript')
    <script>
        var pic_list = {!! json_encode(getAllUsers()) !!};
    </script>
    <script type="text/javascript" src="{{ asset('dist/air-datepicker/js/datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/event_edit.js') }}"></script>
@endsection