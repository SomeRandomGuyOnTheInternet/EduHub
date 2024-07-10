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
            <div id="calendar"></div>
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
                var module_name = event.module_name; // Fetch module name

                var eventData = {
                    title: title + ' (' + module_name + ')', // Combine title and module name
                    start: event.start,
                    end: event.end,
                    extendedProps: {}
                };

                // Determine if the event is an assignment or quiz and adjust accordingly
                if (event.assignment_id) {
                    // Assignment
                    eventData.color = '#f0ad4e'; // Optional: Set color for assignments
                    eventData.classNames = 'assignment-event'; // Assign a CSS class for assignments
                } 
                
                if (event.quiz_id) {
                    // Quiz
                    eventData.color = '#5bc0de'; // Optional: Set color for quizzes
                    eventData.classNames = 'quiz-event'; // Assign a CSS class for quizzes
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
                eventDisplay: 'block', // Ensure events are displayed as blocks
                eventTextColor: 'black' // Set text color for events
            });

            calendar.render();
        });
    </script>
    <style>
        /* Override FullCalendar default styles */
        .fc-event-main-frame .fc-event-time {
            display: none !important; /* Hide event time */
        }
    
        /* Style assignments */
        .fc-event-title.assignment-event {
            background-color: #f0ad4e !important; /* Set background color for assignments */
            border-color: #f0ad4e !important; /* Set border color for assignments */
            color: black !important; /* Set text color for assignments */
        }
    
        /* Style quizzes */
        .fc-event-title.quiz-event {
            background-color: #5bc0de !important; /* Set background color for quizzes */
            border-color: #5bc0de !important; /* Set border color for quizzes */
            color: black !important; /* Set text color for quizzes */
        }
    </style>
@endsection