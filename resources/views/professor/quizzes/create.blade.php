<x-app-layout>
    <x-slot name="title">
        {{ __('Learning Content') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Quiz') }}
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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('modules.professor.quizzes.store', ['module_id' => $module_id]) }}" method="POST">
            @csrf
            <input type="hidden" name="module_id" value="{{ $module_id }}">
            <div class="form-group">
                <label for="title">Title*</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description*</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="datetime">Date and Time*</label>
                <input type="datetime-local" class="form-control" id="datetime" name="datetime" required>
            </div>

            <div id="questions-container">
                <div class="question-group">
                    <div class="form-group">
                        <label for="question">Question 1</label>
                        <input type="text" class="form-control" name="questions[]" required>
                    </div>
                    <div class="form-group">
                        <label for="marks">Marks*</label>
                        <input type="number" class="form-control" name="marks[]" required>
                    </div>
                    <div class="form-group">
                        <label>Options</label>
                        <input type="text" class="form-control" name="options[0][]" placeholder="Option A" required>
                        <input type="text" class="form-control" name="options[0][]" placeholder="Option B" required>
                        <input type="text" class="form-control" name="options[0][]" placeholder="Option C" required>
                        <input type="text" class="form-control" name="options[0][]" placeholder="Option D" required>
                    </div>
                    <div class="form-group">
                        <label for="correct_option">Correct Option*</label>
                        <select class="form-control" name="correct_options[]" required>
                            <option value="A">Option A</option>
                            <option value="B">Option B</option>
                            <option value="C">Option C</option>
                            <option value="D">Option D</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="addQuestionBtn">Add New Question</button>
            <button type="submit" class="btn btn-success">Publish Quiz</button>
        </form>
    </div>

    <script>
        document.getElementById('addQuestionBtn').addEventListener('click', function () {
            const questionsContainer = document.getElementById('questions-container');
            const questionCount = document.querySelectorAll('.question-group').length;
            const newQuestion = document.createElement('div');
            newQuestion.classList.add('question-group');
            newQuestion.innerHTML = `
                <hr>
                <div class="form-group">
                    <label for="question">Question ${questionCount + 1}</label>
                    <input type="text" class="form-control" name="questions[]" required>
                </div>
                <div class="form-group">
                    <label for="marks">Marks*</label>
                    <input type="number" class="form-control" name="marks[]" required>
                </div>
                <div class="form-group">
                    <label>Options</label>
                    <input type="text" class="form-control" name="options[${questionCount}][]" placeholder="Option A" required>
                    <input type="text" class="form-control" name="options[${questionCount}][]" placeholder="Option B" required>
                    <input type="text" class="form-control" name="options[${questionCount}][]" placeholder="Option C" required>
                    <input type="text" class="form-control" name="options[${questionCount}][]" placeholder="Option D" required>
                </div>
                <div class="form-group">
                    <label for="correct_option">Correct Option*</label>
                    <select class="form-control" name="correct_options[]" required>
                        <option value="A">Option A</option>
                        <option value="B">Option B</option>
                        <option value="C">Option C</option>
                        <option value="D">Option D</option>
                    </select>
                </div>
            `;
            questionsContainer.appendChild(newQuestion);
        });
    </script>
</x-app-layout>
