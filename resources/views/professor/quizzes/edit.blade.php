@extends('layouts.app')

@section('title', 'Learning Content')

@section('content')
<body>
    <div class="container mt-5">
        <h2>Edit Quiz for Module: {{ $module->module_name }}</h2>

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

        <form action="{{ route('modules.professor.quizzes.update', ['module_id' => $module->module_id, 'quiz' => $quiz->quiz_id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title*</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $quiz->quiz_title }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description*</label>
                <textarea class="form-control" id="description" name="description" required>{{ $quiz->quiz_description }}</textarea>
            </div>
            <div class="form-group">
                <label for="datetime">Date and Time*</label>
                <input type="datetime-local" class="form-control" id="datetime" name="datetime" value="{{ $quiz->quiz_date }}" required>
            </div>

            @foreach($quiz->questions as $index => $question)
                <div class="question-group">
                    <hr>
                    <div class="form-group">
                        <label for="question">Question {{ $index + 1 }}</label>
                        <input type="text" class="form-control" name="questions[{{ $index }}]" value="{{ $question->question }}" required>
                    </div>
                    <div class="form-group">
                        <label for="marks">Marks*</label>
                        <input type="number" class="form-control" name="marks[{{ $index }}]" value="{{ $question->marks }}" required>
                    </div>
                    <div class="form-group">
                        <label>Options</label>
                        <input type="text" class="form-control" name="options[{{ $index }}][]" value="{{ $question->option_a }}" required>
                        <input type="text" class="form-control" name="options[{{ $index }}][]" value="{{ $question->option_b }}" required>
                        <input type="text" class="form-control" name="options[{{ $index }}][]" value="{{ $question->option_c }}" required>
                        <input type="text" class="form-control" name="options[{{ $index }}][]" value="{{ $question->option_d }}" required>
                    </div>
                    <div class="form-group">
                        <label for="correct_option">Correct Option*</label>
                        <select class="form-control" name="correct_options[{{ $index }}]" required>
                            <option value="A" {{ $question->correct_option == 'A' ? 'selected' : '' }}>Option A</option>
                            <option value="B" {{ $question->correct_option == 'B' ? 'selected' : '' }}>Option B</option>
                            <option value="C" {{ $question->correct_option == 'C' ? 'selected' : '' }}>Option C</option>
                            <option value="D" {{ $question->correct_option == 'D' ? 'selected' : '' }}>Option D</option>
                        </select>
                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn btn-success">Update Quiz</button>
        </form>
    </div>
</body>
@endsection