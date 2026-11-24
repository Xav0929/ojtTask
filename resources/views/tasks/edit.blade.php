@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit task</h1>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">&larr; Back</a>
    </div>

    <form action="{{ route('tasks.update', $task) }}" method="POST" class="card-box p-4">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}"
                   class="form-control @error('title') is-invalid @enderror">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" rows="3" class="form-control">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select id="category_id" name="category_id" class="form-select">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $task->category_id) == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="pending" @selected(old('status', $task->status) == 'pending')>Pending</option>
                    <option value="done" @selected(old('status', $task->status) == 'done')>Done</option>
                </select>
            </div>
            <div class="col-6">
                <label for="due_date" class="form-label">Due date</label>
                <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $task->due_date) }}" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save changes</button>
    </form>

@endsection