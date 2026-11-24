@extends('layouts.app')

@section('title', 'My Tasks')

@section('content')

    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h1 class="mb-1">My tasks</h1>
            <div>A clear list for a calmer week.</div>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal">
            + New task
        </button>
    </div>

    @if (session('success'))
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="successToast" class="toast align-items-center border-0 {{ session('type') === 'danger' ? 'toast-danger' : '' }}" role="alert" data-bs-delay="1500">
                <div class="toast-body">{{ session('success') }}</div>
            </div>
        </div>
        <script>
            window.addEventListener('load', function () {
                new bootstrap.Toast(document.getElementById('successToast')).show();
            });
        </script>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card-box p-3">
                <small>All tasks</small>
                <div class="fs-3 fw-bold">{{ $total }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-box p-3">
                <small>In progress</small>
                <div class="fs-3 fw-bold">{{ $pending }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-box p-3">
                <small>Completed</small>
                <div class="fs-3 fw-bold">{{ $done }}</div>
            </div>
        </div>
    </div>

    <form action="{{ route('tasks.index') }}" method="GET" class="d-flex gap-2 mb-3">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search tasks...">

        <select name="category" class="form-select w-auto">
            <option value="">All categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>

        <select name="status" class="form-select w-auto">
            <option value="">Any status</option>
            <option value="pending" @selected(request('status') == 'pending')>Pending</option>
            <option value="done" @selected(request('status') == 'done')>Done</option>
        </select>

        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <!-- Task table -->
    <div class="card-box overflow-hidden">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        <div class="d-flex align-items-center gap-3">
                            @if ($tasks->count())
                                @php $allDone = $tasks->getCollection()->every(fn ($t) => $t->status === 'done'); @endphp
                                <form action="{{ route('tasks.doneAll') }}" method="POST" title="Select all">
                                    @csrf
                                    @method('PATCH')
                                    @foreach ($tasks as $t)
                                        <input type="hidden" name="ids[]" value="{{ $t->id }}">
                                    @endforeach
                                    <input type="hidden" name="status" value="{{ $allDone ? 'pending' : 'done' }}">
                                    <input type="checkbox" class="form-check-input" onchange="this.form.submit()" @checked($allDone)>
                                </form>
                            @endif
                            Task
                        </div>
                    </th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Due date</th>
                    <th class="text-end">Actions</th>
                    
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $task)
                    <tr>
                        <td>
                            <div class="d-flex align-items-start gap-3">
                                <form action="{{ route('tasks.done', $task) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="checkbox" class="form-check-input mt-1" onchange="this.form.submit()" @checked($task->status === 'done')>
                                </form>
                                <div>
                                    <div class="fw-semibold {{ $task->status === 'done' ? 'text-decoration-line-through' : '' }}">{{ $task->title }}</div>
                            <small>{{ $task->description }}</small>
                                </div>
                            </div>
                        </td>
                        <td><span class="tag tag-{{ strtolower($task->category->name) }}">{{ $task->category->name }}</span></td>
                        <td>{{ ucfirst($task->status) }}</td>
                        <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : '-' }}</td>
                        <td class="text-end">
                            <button type="button" class="btn btn-sm btn-secondary"
                                    data-bs-toggle="modal" data-bs-target="#editTaskModal"
                                    data-id="{{ $task->id }}"
                                    data-title="{{ $task->title }}"
                                    data-description="{{ $task->description }}"
                                    data-category="{{ $task->category_id }}"
                                    data-status="{{ $task->status }}"
                                    data-due="{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '' }}">Edit</button>
                            <button type="button" class="btn btn-sm btn-danger"
                                    data-bs-toggle="modal" data-bs-target="#deleteTaskModal"
                                    data-id="{{ $task->id }}"
                                    data-title="{{ $task->title }}">Delete</button>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">No tasks found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $tasks->links() }}
    </div>

    <div class="modal fade" id="createTaskModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
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
                            <select id="category" name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">Select...</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due date</label>
                            <input type="date" id="due_date" name="due_date" class="form-control">
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
                @if (old('edit_id'))
                    editForm.action = "{{ url('tasks') }}/{{ old('edit_id') }}";
                    document.getElementById('edit_id').value          = @json(old('edit_id'));
                    document.getElementById('edit_title').value       = @json(old('title'));
                    document.getElementById('edit_description').value = @json(old('description'));
                    document.getElementById('edit_category').value    = @json(old('category_id'));
                    document.getElementById('edit_status').value      = @json(old('status'));
                    document.getElementById('edit_due').value         = @json(old('due_date'));
                    new bootstrap.Modal(editModal).show();
                @else
                    new bootstrap.Modal(document.getElementById('createTaskModal')).show();
                @endif
            });
        </script>
    @endif

    <div class="modal fade" id="deleteTaskModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')

                    <div class="modal-body text-center p-4">
                        <h5 class="mb-2">Delete task?</h5>
                        <p class="mb-4">"<span id="deleteTitle"></span>" will be removed permanently.</p>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('deleteTaskModal').addEventListener('show.bs.modal', function (e) {
            const b = e.relatedTarget;
            document.getElementById('deleteForm').action = "{{ url('tasks') }}/" + b.dataset.id;
            document.getElementById('deleteTitle').textContent = b.dataset.title;
        });
    </script>

    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="edit_id" id="edit_id">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_title" class="form-label">Title</label>
                            <input type="text" id="edit_title" name="title"
                                   class="form-control @if (old('edit_id')) @error('title') is-invalid @enderror @endif">
                            @if (old('edit_id'))
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea id="edit_description" name="description" rows="3" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="edit_category" class="form-label">Category</label>
                            <select id="edit_category" name="category_id" class="form-select">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <label for="edit_status" class="form-label">Status</label>
                                <select id="edit_status" name="status" class="form-select">
                                    <option value="pending">Pending</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="edit_due" class="form-label">Due date</label>
                                <input type="date" id="edit_due" name="due_date" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const editModal = document.getElementById('editTaskModal');
        const editForm  = document.getElementById('editForm');

        // Fill the form from the clicked row's data
        editModal.addEventListener('show.bs.modal', function (e) {
            const b = e.relatedTarget;
            if (!b) return;
            editForm.action = "{{ url('tasks') }}/" + b.dataset.id;
            document.getElementById('edit_id').value          = b.dataset.id;
            document.getElementById('edit_title').value       = b.dataset.title;
            document.getElementById('edit_description').value = b.dataset.description;
            document.getElementById('edit_category').value    = b.dataset.category;
            document.getElementById('edit_status').value      = b.dataset.status;
            document.getElementById('edit_due').value         = b.dataset.due;
        });
    </script>

@endsection