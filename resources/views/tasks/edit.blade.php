@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <h1 class="h3 mb-3">Edit Task #{{ $id }}</h1>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
@endsection