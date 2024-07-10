@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $assignment->title }}</h1>
    <p>{{ $assignment->description }}</p>
    <p><strong>Weightage:</strong> {{ $assignment->weightage }}</p>
    <p><strong>Due Date:</strong> {{ $assignment->due_date }}</p>

    <livewire:professor.assignment-download :assignment_id="$assignment->assignment_id" />
    <livewire:professor.assignment-grade :assignment_id="$assignment->assignment_id" />
</div>
@endsection
