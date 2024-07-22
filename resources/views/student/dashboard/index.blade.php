<x-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>

    @livewire('student.sidebar', ['currentPage' => StudentSidebarLink::Dashboard])

    <div class="viewport-container container-fluid p-0">
        @livewire('student.module-header', ['currentPage' => 'Dashboard'])
        <div class="p-4">
            <ul class="nav nav-pills gap-2 p-1 small bg-body-secondary rounded-5 mb-3" style="width: fit-content;" id="dashboard-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-5" id="pills-calendar-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-calendar" type="button" role="tab" aria-controls="pills-calendar"
                        aria-selected="false">Kalendar</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-5" id="pills-announcements-tab" data-bs-toggle="pill" data-bs-target="#pills-announcements"
                        type="button" role="tab" aria-controls="pills-announcements" aria-selected="true">Announcements</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-calendar" role="tabpanel" aria-labelledby="pills-calendar-tab"
                    tabindex="0">
                    <div id="calendar" class="mb-4"></div>
                </div>
                <div class="tab-pane fade" id="pills-announcements" role="tabpanel" aria-labelledby="pills-announcements-tab"
                    tabindex="0">
                    <div class="row">
                        {{-- Sort events by days left ascending --}}
                        @php
                            $sortedEvents = $events->sortBy(function ($event) {
                                $eventStartDate = \Carbon\Carbon::parse($event->start);
                                $today = \Carbon\Carbon::today();
                                return $today->diffInDays($eventStartDate);
                            });
                        @endphp
    
                        {{-- Iterate over sorted events --}}
                        @foreach ($sortedEvents as $event)
                            @php
                                $eventStartDate = \Carbon\Carbon::parse($event->start);
                                $today = \Carbon\Carbon::today();
                                $daysUntilEvent = $today->diffInDays($eventStartDate);
                                $eventIsToday = $eventStartDate->isSameDay($today);
                            @endphp
                            @if ($eventStartDate->isToday() || ($eventStartDate->isFuture() && $daysUntilEvent <= 7))
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card rounded shadow border">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                @if ($event->type === 'meeting')
                                                    Meeting
                                                @else
                                                    {{ $event->title }}
                                                @endif
                                            </h5>
                                            <p class="card-text">{{ $event->module_name }}</p>
                                            <p class="card-text">{{ $event->start }}</p>
                                            @if ($event->type === 'assignment')
                                                <span class="badge bg-warning text-dark">Assignment</span>
                                            @elseif($event->type === 'quiz')
                                                <span class="badge bg-info text-dark">Quiz</span>
                                            @elseif($event->type === 'meeting')
                                                <p class="card-text">Professor: {{ $event->professor_name }}</p>
                                                <p class="card-text">Timeslot: {{ $event->timeslot }}</p>
                                                <span class="badge bg-success text-dark">Meeting</span>
                                            @endif
    
                                            @if ($eventIsToday)
                                                <p class="card-text"><strong>TODAY</strong></p>
                                            @else
                                                <p class="card-text">{{ $daysUntilEvent }}
                                                    day{{ $daysUntilEvent != 1 ? 's' : '' }} until event</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>                    
                </div>
            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
    <script>
        const headerDescription = document.getElementById('header-description');

        document.addEventListener('DOMContentLoaded', function() {
            updateHeaderDescription("Calendar");
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
                selectMirror: true,
                editable: false,
                dayMaxEvents: true,
                events: calendarEvents,
                eventDisplay: 'block',
                eventTextColor: 'black',
                eventContent: function(arg) {
                    var title = arg.event.title;
                    var module_name = arg.event.extendedProps.module_name;
                    var content =
                        `<div>${title}</div><div style="font-size: 1em; color: #555;">${module_name}</div>`;

                    if (arg.event.extendedProps.professor_name) {
                        content +=
                            `<div style="font-size: 1em; color: #555;">${arg.event.extendedProps.professor_name}</div>`;
                    }

                    if (arg.event.extendedProps.timeslot) {
                        content +=
                            `<div style="font-size: 1em; color: #555;">${arg.event.extendedProps.timeslot}</div>`;
                    }

                    var eventContent = document.createElement('div');
                    eventContent.innerHTML = content;
                    return {
                        domNodes: [eventContent]
                    };
                }
            });

            calendar.render();
        });

        $('#pills-calendar-tab').click(function() {
            updateHeaderDescription('Calendar');
        });

        $('#pills-announcements-tab').click(function() {
            updateHeaderDescription('Announcements');
        });

        function updateHeaderDescription(description) {
            headerDescription.innerText = description;
        }
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
            white-space: pre-line;
            /* Ensures line breaks are rendered */
        }
    </style>
</x-layout>
