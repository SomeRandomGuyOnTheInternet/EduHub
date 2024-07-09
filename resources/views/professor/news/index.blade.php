@extends('layouts.app')

@section('title', 'News')

@section('content')
<div class="container mt-5">
    <h2>{{ $module->module_name }} - News</h2>

    @if (Auth::user()->user_type == 'professor')
        <a href="{{ route('modules.professor.news.create', ['module_id' => $module->module_id]) }}" class="btn btn-primary mb-4">Create News</a>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Time Created/Updated</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($newsItems as $news)
                <tr>
                    <td><a href="{{ route('modules.professor.news.show', ['module_id' => $module->module_id, 'news' => $news->news_id]) }}">{{ $news->news_title }}</a></td>
                    <td>{{ $news->news_description }}</td>
                    <td>
                        @if ($news->updated_at)
                            Updated at: {{ $news->updated_at->format('h:iA, d M') }}
                        @else
                            Created at: {{ $news->created_at->format('h:iA, d M') }}
                        @endif
                    </td>
                    <td>
                        @if (Auth::user()->user_type == 'professor')
                            <a href="{{ route('modules.professor.news.edit', ['module_id' => $module->module_id, 'news' => $news->news_id]) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('modules.professor.news.destroy', ['module_id' => $module->module_id, 'news' => $news->news_id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
