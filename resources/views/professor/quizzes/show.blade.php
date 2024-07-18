<x-layouts>
    <x-slot name="title">
        {{ __('Learning Content') }}
    </x-slot>

    @livewire('professor.sidebar', ['currentPage' => ProfessorSidebarLink::ModuleQuiz, 'currentModule' => $module_id])

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quiz: ') }}{{ $quiz->quiz_title }}
        </h2>
    </x-slot>

    <div class="container-fluid p-0">
        @livewire('professor.module-header', ['currentPage' => "Quiz", 'currentModuleId' => $module_id])
        <p><strong>Module:</strong> {{ $module->module_name }}</p>
        <p><strong>Description:</strong> {{ $quiz->quiz_description }}</p>
        <p><strong>Date:</strong> {{ $quiz->quiz_date }}</p>

        <h3>Questions</h3>
        @foreach($quiz->questions as $index => $question)
            <div class="question-group">
                <hr>
                <h4>Question {{ $index + 1 }}</h4>
                <p>{{ $question->question }}</p>
                <ul>
                    <li>{{ $question->option_a }}</li>
                    <li>{{ $question->option_b }}</li>
                    <li>{{ $question->option_c }}</li>
                    <li>{{ $question->option_d }}</li>
                </ul>
                <p><strong>Correct Option:</strong> {{ $question->correct_option }}</p>
                <p><strong>Marks:</strong> {{ $question->marks }}</p>
            </div>
        @endforeach
    </div>
</x-layouts>
