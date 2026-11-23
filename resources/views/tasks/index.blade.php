@extends('layouts.app')

@section('title', 'All Tasks')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">All tasks</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal">
    + New task
</button>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex gap-2 mb-3">
        <input type="text" class="form-control" placeholder="Search your tasks...">
        <select class="form-select w-auto">
            <option>All categories</option>
            <option>Work</option>
            <option>School</option>
            <option>Personal</option>
        </select>
        <select class="form-select w-auto">
            <option>Any status</option>
            <option>Pending</option>
            <option>Done</option>
        </select>
    </div>

    <table class="table bg-white">
        <thead>
            <tr>
                <th>Task</th>
                <th>Category</th>
                <th>Status</th>
                <th>Due date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tasks as $task)
                <tr>
                    <td>{{ $task['title'] }}</td>
                    <td>{{ $task['category'] }}</td>
                    <td>{{ $task['status'] }}</td>
                    <td>{{ $task['due'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No tasks yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <!-- Create Task Modal -->
<div class="modal fade" id="createTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">New task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
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

                    <div class="row">
                        <div class="col-6">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="done">Done</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="due_date" class="form-label">Due date</label>
                            <input type="date" id="due_date" name="due_date" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Task</button>
                </div>
            </form>

        </div>
    </div>
</div>
@if ($errors->any())
    <script>
        window.addEventListener('load', function () {
            new bootstrap.Modal(document.getElementById('createTaskModal')).show();
        });
    </script>
@endif
@endsection
