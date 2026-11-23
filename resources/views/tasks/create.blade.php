@extends('layouts.app')

@section('title', 'Create Task')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Create Task</h1>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">&larr; Back to Tasks</a>
    </div>

    <form action="{{ route('tasks.store') }}" method="POST" class="bg-white border rounded p-4">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}"
                   class="form-control @error('title') is-invalid @enderror">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select id="category" name="category" class="form-select @error('category') is-invalid @enderror">
                <option value="">Select...</option>
                <option value="Work">Work</option>
                <option value="School">School</option>
                <option value="Personal">Personal</option>
            </select>
            @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-select">
                <option value="pending">Pending</option>
                <option value="done">Done</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Due date</label>
            <input type="date" id="due_date" name="due_date" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save Task</button>
    </form>

@endsection