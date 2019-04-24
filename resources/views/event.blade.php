@extends('layouts.main')
@section('title',__("Order"))
@section('headbar-title', __("Order"))
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/headbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/fullcalendar-4.0.2/packages/core/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/fullcalendar-4.0.2/packages/daygrid/main.css') }}">
    <script type="text/javascript" src="{{ asset('dist/fullcalendar-4.0.2/packages/core/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/fullcalendar-4.0.2/packages/interaction/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/fullcalendar-4.0.2/packages/daygrid/main.js') }}"></script>
@endsection
@section('headbar')
@include('layouts/headbar')
@endsection
@section('content')
    <style>
        #calendar-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .fc-header-toolbar {
            /*
            the calendar will be butting up against the edges,
            but let's scoot in the header's buttons
            */
            padding-top: 1em;
            padding-left: 1em;
            padding-right: 1em;
        }

    </style>
    <div class="main-content">
        <div id='calendar-container'>
            <div id='calendar'></div>
        </div>
    </div>
@endsection
@section('end-javascript')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                height: 'parent',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                defaultView: 'dayGridMonth',
                defaultDate: '2019-04-12',
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: [
                    {
                        title: 'All Day Event',
                        start: '2019-04-01',
                    },
                    {
                        title: 'Long Event',
                        start: '2019-04-07',
                        end: '2019-04-10'
                    },
                    {
                        groupId: 999,
                        title: 'Repeating Event',
                        start: '2019-04-09T16:00:00'
                    },
                    {
                        groupId: 999,
                        title: 'Repeating Event',
                        start: '2019-04-16T16:00:00'
                    },
                    {
                        title: 'Conference',
                        start: '2019-04-11',
                        end: '2019-04-13'
                    },
                    {
                        title: 'Meeting',
                        start: '2019-04-12T10:30:00',
                        end: '2019-04-12T12:30:00'
                    },
                    {
                        title: 'Lunch',
                        start: '2019-04-12T12:00:00'
                    },
                    {
                        title: 'Meeting',
                        start: '2019-04-12T14:30:00'
                    },
                    {
                        title: 'Happy Hour',
                        start: '2019-04-12T17:30:00'
                    },
                    {
                        title: 'Dinner',
                        start: '2019-04-12T20:00:00'
                    },
                    {
                        title: 'Birthday Party',
                        start: '2019-04-13T07:00:00'
                    },
                    {
                        title: 'Click for Google',
                        url: 'http://google.com/',
                        start: '2019-04-28'
                    }
                ]
            });

            calendar.render();
        });

    </script>
@endsection