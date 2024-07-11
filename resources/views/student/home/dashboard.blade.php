@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
            <div id="calendar" class="mb-4"></div>
            <div class="row">
                @foreach($events as $event)
                    @php
                        $eventStartDate = \Carbon\Carbon::parse($event->start);
                        $today = \Carbon\Carbon::today();
                    @endphp

                    @if ($eventStartDate->isFuture())
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $event->title }}</h5>
                                    <p class="card-text">Module: {{ $event->module_name }}</p>
                                    <p class="card-text">Start Date: {{ $event->start }}</p>
                                    @if($event->type === 'assignment')
                                        <span class="badge bg-warning text-dark">Assignment</span>
                                    @elseif($event->type === 'quiz')
                                        <span class="badge bg-info text-dark">Quiz</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var events = @json($events);

            var calendarEvents = events.map(function(event) {
                var title = event.title;
                var module_name = event.module_name;

                var eventData = {
                    title: title + ' (' + module_name + ')',
                    start: event.start,
                    end: event.end || event.start,
                    extendedProps: {}
                };

                if (event.type === 'assignment') {
                    eventData.color = '#f0ad4e';
                    eventData.classNames = 'assignment-event';
                } else if (event.type === 'quiz') {
                    eventData.color = '#5bc0de';
                    eventData.classNames = 'quiz-event';
                }

                return eventData;
            });

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                navLinks: true,
                selectable: true,
                selectMirror: true,
                editable: false,
                dayMaxEvents: true,
                events: calendarEvents,
                eventDisplay: 'block',
                eventTextColor: 'black'
            });

            calendar.render();
        });
    </script>
    <style>
        .fc-event-main-frame .fc-event-time {
            display: none !important;
        }
        .fc-event-title.assignment-event {
            background-color: #f0ad4e !important;
            border-color: #f0ad4e !important;
            color: black !important;
        }
        .fc-event-title.quiz-event {
            background-color: #5bc0de !important;
            border-color: #5bc0de !important;
            color: black !important;
        }
    </style>
@endsection