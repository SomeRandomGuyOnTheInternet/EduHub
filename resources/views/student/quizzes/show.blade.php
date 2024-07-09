@extends('layouts.app')

@section('title', 'Learning Content')

@section('content')
<body>
    <div class="container mt-5">
        <h2>Attempt Quiz: {{ $quiz->quiz_title }}</h2>
        <form action="{{ route('modules.student.quizzes.attempt', ['module_id' => $module->module_id, 'id' => $quiz->quiz_id]) }}" method="POST">
            @csrf
            @foreach ($quiz->questions as $index => $question)
            <div class="form-group">
                <label for="question">{{ $index + 1 }}. {{ $question->question }}</label>
                <input type="hidden" name="questions[]" value="{{ $question->quiz_questions_id }}">
                <div>
                    <input type="radio" name="answers[{{ $index }}]" value="A" required> {{ $question->option_a }}
                </div>
                <div>
                    <input type="radio" name="answers[{{ $index }}]" value="B" required> {{ $question->option_b }}
                </div>
                <div>
                    <input type="radio" name="answers[{{ $index }}]" value="C" required> {{ $question->option_c }}
                </div>
                <div>
                    <input type="radio" name="answers[{{ $index }}]" value="D" required> {{ $question->option_d }}
                </div>
            </div>
            @endforeach
            <button type="submit" class="btn btn-success">Submit Quiz</button>
        </form>
    </div>
</body>
</html>
@endsection