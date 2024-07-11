<x-app-layout>
    <x-slot name="title">
        {{ __('Assignment Details') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $assignment->title }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <h1>{{ $assignment->title }}</h1>
        <p>{{ $assignment->description }}</p>
        <p><strong>Weightage:</strong> {{ $assignment->weightage }}</p>
        <p><strong>Due Date:</strong> {{ $assignment->due_date }}</p>
        @if($assignment->file_path)
            <p><strong>File:</strong> <a href="{{ Storage::url($assignment->file_path) }}" target="_blank">{{ $fileName }}</a></p>
        @endif
    </div>
</x-app-layout>
