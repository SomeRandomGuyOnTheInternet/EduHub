@extends('layouts.app')

@section('title', 'Learning Content')

@section('content')
<body>
    
    <div class="container mt-5">
        <h2>Quizzes for Module: {{ $module->module_name }}</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Active quizzes --}}
        <h3>Active Quizzes</h3>
        @if($quizzes->isEmpty())
            <p>No active quizzes found for this module.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizzes as $quiz)
                        <tr>
                            <td>{{ $quiz->quiz_title }}</td>
                            <td>{{ $quiz->quiz_description }}</td>
                            <td>{{ $quiz->quiz_date }}</td>
                            <td>
                                <a href="{{ route('modules.student.quizzes.show', ['module_id' => $module->module_id, 'quiz' => $quiz->quiz_id]) }}" class="btn btn-info btn-sm">Start</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        {{-- Completed quizzes --}}
        <h3>Completed Quizzes</h3>
        @if($completedQuizzes->isEmpty())
            <p>No completed quizzes found for this module.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Attempt Date</th>
                        <th>Score</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($completedQuizzes as $attempt)
                        <tr>
                            <td>{{ $attempt->quiz->quiz_title }}</td>
                            <td>{{ $attempt->created_at }}</td>
                            <td>{{ $attempt->score }}</td>
                            <td>{{ $attempt->grade }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
</body>
</html>
@endsection