<x-app-layout>
    <x-slot name="title">
        {{ __('Learning Content') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quizzes for Module: ') }}{{ $module->module_name }}
        </h2>
    </x-slot>

    <div class="container mt-5">
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
                                <a href="{{ route('modules.student.quizzes.show', ['module_id' => $module->module_id, 'quiz' => $quiz->quiz_id]) }}" class="btn btn-info btn-sm start-button" data-quiz-date="{{ $quiz->quiz_date }}">Start</a>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const startButtons = document.querySelectorAll('.start-button');
            startButtons.forEach(button => {
                const quizDate = new Date(button.getAttribute('data-quiz-date'));
                const now = new Date();
                
                if (now < quizDate) {
                    button.classList.add('disabled');
                    button.setAttribute('disabled', 'true');
                    button.textContent = 'Starts at ' + quizDate.toLocaleString();
                } else {
                    button.classList.remove('disabled');
                    button.removeAttribute('disabled');
                }
            });

            setInterval(() => {
                startButtons.forEach(button => {
                    const quizDate = new Date(button.getAttribute('data-quiz-date'));
                    const now = new Date();
                    
                    if (now >= quizDate && button.hasAttribute('disabled')) {
                        button.classList.remove('disabled');
                        button.removeAttribute('disabled');
                        button.textContent = 'Start';
                    }
                });
            }, 1000); // Check every second to update the buttons
        });
    </script>
</x-app-layout>
