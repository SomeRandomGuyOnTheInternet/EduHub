<x-app-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-grey dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
            <br>
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
                                <h5 class="card-title">
                                    @if($event->type === 'meeting')
                                        Meeting
                                    @else
                                        {{ $event->title }}
                                    @endif
                                </h5>
                                <p class="card-text">Module: {{ $event->module_name }}</p>
                                <p class="card-text">Start Date: {{ $event->start }}</p>
                                @if($event->type === 'assignment')
                                    <span class="badge bg-warning text-dark">Assignment</span>
                                    <br><br><br>
                                @elseif($event->type === 'quiz')
                                    <span class="badge bg-info text-dark">Quiz</span>
                                    <br><br><br>
                                @elseif($event->type === 'meeting')
                                    <p class="card-text">Professor: {{ $event->professor_name }}</p>
                                    <p class="card-text">Timeslot: {{ $event->timeslot }}</p>
                                    <span class="badge bg-success text-dark">Meeting</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var events = @json($events);

            var calendarEvents = events.map(function(event) {
                var eventData = {
                    title: event.type === 'meeting' ? 'Meeting' : event.title,
                    start: event.start,
                    end: event.end || event.start,
                    extendedProps: {
                        module_name: event.module_name
                    }
                };

                if (event.type === 'assignment') {
                    eventData.color = '#f0ad4e';
                    eventData.classNames = 'assignment-event';
                } else if (event.type === 'quiz') {
                    eventData.color = '#5bc0de';
                    eventData.classNames = 'quiz-event';
                } else if (event.type === 'meeting') {
                    eventData.color = '#5cb85c';
                    eventData.classNames = 'meeting-event';
                    eventData.extendedProps.professor_name = event.professor_name;
                    eventData.extendedProps.timeslot = event.timeslot;
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
                eventTextColor: 'black',
                eventContent: function(arg) {
                    var title = arg.event.title;
                    var module_name = arg.event.extendedProps.module_name;
                    var content = `<div>${title}</div><div style="font-size: 1em; color: #555;">${module_name}</div>`;
                    
                    if (arg.event.extendedProps.professor_name) {
                        content += `<div style="font-size: 1em; color: #555;">${arg.event.extendedProps.professor_name}</div>`;
                    }
                    
                    if (arg.event.extendedProps.timeslot) {
                        content += `<div style="font-size: 1em; color: #555;">${arg.event.extendedProps.timeslot}</div>`;
                    }

                    var eventContent = document.createElement('div');
                    eventContent.innerHTML = content;
                    return { domNodes: [eventContent] };
                }
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
        .fc-event-main {
            white-space: pre-line; /* Ensures line breaks are rendered */
        }
    </style>
</x-app-layout>
