<x-app-layout>
    <x-slot name="title">
        {{ __('Edit News') }}
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit News for Module: ') }}{{ $module->module_name }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <form action="{{ route('modules.professor.news.update', ['module_id' => $module->module_id, 'news' => $newsItem->news_id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="news_title">News Title</label>
                <input type="text" class="form-control" id="news_title" name="news_title" value="{{ $newsItem->news_title }}" required>
            </div>
            <div class="form-group">
                <label for="news_description">News Description</label>
                <textarea class="form-control" id="news_description" name="news_description" required>{{ $newsItem->news_description }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Update News</button>
        </form>
    </div>
</x-app-layout>
