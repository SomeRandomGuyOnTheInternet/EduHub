<x-app-layout>
    <x-slot name="title">
        {{ __('Calendar') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calendar') }}
        </h2>
    </x-slot>

    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Include FullCalendar core styles CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.7.2/main.min.css" rel="stylesheet">

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Include FullCalendar core JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.7.2/main.min.js"></script>

    <div class="container mt-5">
        <div id="calendar"></div>
        <h1>Hello</h1>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: {!! json_encode($events) !!}
            });

            calendar.render();
        });
    </script>
</x-app-layout>
