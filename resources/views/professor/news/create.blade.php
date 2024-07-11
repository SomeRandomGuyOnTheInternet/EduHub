<x-app-layout>
    <x-slot name="title">
        {{ __('Create News') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create News for Module: ') }}{{ $module->module_name }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <form action="{{ route('modules.professor.news.store', ['module_id' => $module->module_id]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="news_title">News Title</label>
                <input type="text" class="form-control" id="news_title" name="news_title" required>
            </div>
            <div class="form-group">
                <label for="news_description">News Description</label>
                <textarea class="form-control" id="news_description" name="news_description" required></textarea>
            </div>
            <input type="hidden" name="module_id" value="{{ $module->module_id }}">
            <button type="submit" class="btn btn-success">Create News</button>
        </form>
    </div>
</x-app-layout>
