@extends('layouts.app')

@section('title', 'Dashboard')


<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Include FullCalendar core JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.7.2/main.min.js"></script>
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div id="calendar"></div>
    </div>

    <style>
        /* Example CSS for calendar styling */
        #calendar {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: {!! json_encode($events) !!} // Ensure $events contains valid data
            });

            calendar.render();
        });
    </script>
@endsection
