@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Create Task</h1>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">&larr; Back to Tasks</a>
    </div>

    <p class="text-muted">Form will go here.</p>
@endsection