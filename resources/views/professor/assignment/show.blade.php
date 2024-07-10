<!-- resources/views/professor/assignment/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $assignment->title }}</h1>
    <p>{{ $assignment->description }}</p>
    <p><strong>Weightage:</strong> {{ $assignment->weightage }}</p>
    <p><strong>Due Date:</strong> {{ $assignment->due_date }}</p>
    @if($assignment->file_path)
        <p><strong>File:</strong> <a href="{{ Storage::url($assignment->file_path) }}" target="_blank">{{ $fileName }}</a></p>
    @endif
</div>
@endsection
