@extends('layouts.main')
@section('title',__("Events Calendar"))
@section('headbar-title', __("Events Calendar"))
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/headbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/air-datepicker/css/datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/fullcalendar-4.0.2/packages/core/main.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/fullcalendar-4.0.2/packages/bootstrap/main.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/fullcalendar-4.0.2/packages/daygrid/main.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/fullcalendar-4.0.2/packages/timegrid/main.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/fullcalendar-4.0.2/packages/list/main.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/event.css') }}">
@endsection
@section('headbar')
    @section('headbar-icon')
        <i class="fas fa-calendar-day fa-2x"></i>
    @endsection
    @include('layouts/headbar')
@endsection
@section('content')
    <div class="main-content">

        <div class="l-content">
            <div class="zY">
                <div class="yP" onclick="">{{ __("Add new") }}</div>
            </div>
            <div id="nicescroll-sidebar" class="zX nicescroll">
                <div class="my-datepicker"></div>

                <div class="tag">

                    <div id="event-tag-head" class="tag-head row z-mgl z-mgr tag-show">
                        <div class="col text-left z-pdl z-pdr">
                            <h5>{{ __('Tag') }}</h5>
                        </div>
                        <div class="col text-right z-pdl z-pdr">
                            <i class="fas fa-angle-up"></i>
                            <i class="fas fa-angle-down"></i>
                        </div>
                    </div>
                    <div id="event-tag-body" class="tag-body collapse show">
                        <table>
                            <tbody>
                            @foreach($tags as $tag)
                                <tr>
                                    <td>
                                        <input type="checkbox" value="{{ $tag->id }}" style="width: 15px; height: 15px"/>
                                    </td>
                                    <td>
                                        <i class="fas fa-circle {{ $tag->color }}"></i>
                                    </td>
                                    <td>
                                        {{ $tag->title }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-content"></div>
        <div class="r-content">
            <div id='calendar-container'>
                <div id='calendar'></div>
            </div>
        </div>
        @include('event_modal')
    </div>
@endsection
@section('end-javascript')
    <script type="text/javascript" src="{{ asset('dist/rrule/rrule.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/moment-timezone/moment-timezone.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/air-datepicker/js/datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/fullcalendar-4.0.2/packages/core/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/fullcalendar-4.0.2/packages/core/locales-all.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/fullcalendar-4.0.2/packages/bootstrap/main.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/fullcalendar-4.0.2/packages/interaction/main.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/fullcalendar-4.0.2/packages/daygrid/main.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/fullcalendar-4.0.2/packages/timegrid/main.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/fullcalendar-4.0.2/packages/list/main.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/fullcalendar-4.0.2/packages/moment/main.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/fullcalendar-4.0.2/packages/moment-timezone/main.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/fullcalendar-4.0.2/packages/rrule/main.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/event.js') }}"></script>
@endsection