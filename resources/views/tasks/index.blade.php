@extends('layouts.app')

@section('title', 'All Tasks')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Tasks</h1>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ New Task</a>
    </div>

    <p class="text-muted">Task list will go here.</p>
@endsection