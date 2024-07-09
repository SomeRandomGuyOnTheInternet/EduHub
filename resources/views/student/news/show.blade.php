@extends('layouts.app')

@section('title', 'News Details')

@section('content')
<div class="container mt-5">
    <h2>{{ $module->module_name }} - News Details</h2>
    <div class="card">
        <div class="card-header">
            <h3>{{ $newsItem->news_title }}</h3>
        </div>
        <div class="card-body">
            <p>{{ $newsItem->news_description }}</p>
        </div>
        <div class="card-footer">
            <small>
                @if ($newsItem->updated_at)
                    Updated at: {{ $newsItem->updated_at->format('h:iA, d M') }}
                @else
                    Created at: {{ $newsItem->created_at->format('h:iA, d M') }}
                @endif
            </small>
        </div>
    </div>
    <a href="{{ route('modules.student.news.index', ['module_id' => $module->module_id]) }}" class="btn btn-secondary mt-3">Back to News</a>
</div>
@endsection
