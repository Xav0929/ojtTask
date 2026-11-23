@extends('layouts.app')

@section('title', 'Task Details')

@section('content')
    <h1 class="h3 mb-3">Task #{{ $id }}</h1>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
@endsection