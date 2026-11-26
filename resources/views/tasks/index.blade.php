@extends('layouts.app')

@section('title', 'My Tasks')

@section('content')

    <style>
        .pagination .page-link { color: var(--green-dark); background: var(--cream-light); border-color: #DDDBC6; }
        .pagination .page-item.active .page-link { background: var(--green-dark); border-color: var(--green-dark); color: #fff; }
        .pagination .page-item.disabled .page-link { opacity: .5; }
    </style>

    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="appToast" class="toast border-0" role="alert" data-bs-delay="1500">
            <div class="toast-body" id="appToastBody"></div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h1 class="mb-1">My tasks</h1>
            <div>A clear list for a calmer week.</div>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal">
            + New task
        </button>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4"><div class="card-box p-3"><small>All tasks</small><div class="fs-3 fw-bold" id="statTotal">-</div></div></div>
        <div class="col-md-4"><div class="card-box p-3"><small>In progress</small><div class="fs-3 fw-bold" id="statPending">-</div></div></div>
        <div class="col-md-4"><div class="card-box p-3"><small>Completed</small><div class="fs-3 fw-bold" id="statDone">-</div></div></div>
    </div>

    <form id="filterForm" class="d-flex gap-2 mb-3">
        <input type="text" id="fSearch" class="form-control" placeholder="Search tasks...">
        <select id="fCategory" class="form-select w-auto"><option value="">All categories</option></select>
        <select id="fStatus" class="form-select w-auto">
            <option value="">Any status</option>
            <option value="pending">Pending</option>
            <option value="done">Done</option>
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <div class="card-box overflow-hidden">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        <div class="d-flex align-items-center gap-3">
                            <input type="checkbox" class="form-check-input" id="checkAll" title="Select all">
                            Task
                        </div>
                    </th>
                    <th>Category</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Due date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody id="taskBody">
                <tr><td colspan="6" class="text-center py-4">Loading tasks...</td></tr>
            </tbody>
        </table>
    </div>

    <nav class="mt-3"><ul class="pagination justify-content-end" id="pager"></ul></nav>

    {{-- Create modal --}}
    <div class="modal fade" id="createTaskModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="createForm" novalidate>
                    <div class="modal-header">
                        <h5 class="modal-title">New task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control">
                            <div class="invalid-feedback" data-error="title"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" class="form-control"></textarea>
                            <div class="invalid-feedback" data-error="description"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select category-select"><option value="">Select...</option></select>
                            <div class="invalid-feedback" data-error="category_id"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Due date</label>
                            <input type="date" name="due_date" class="form-control">
                            <div class="invalid-feedback" data-error="due_date"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Priority</label>
                            <select name="priority" class="form-select">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                            </select>
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

    {{-- Edit modal --}}
    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editForm" novalidate>
                    <input type="hidden" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control">
                            <div class="invalid-feedback" data-error="title"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select category-select"></select>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="pending">Pending</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Due date</label>
                                <input type="date" name="due_date" class="form-control">
                                <div class="invalid-feedback" data-error="due_date"></div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <label class="form-label">Priority</label>
                                <select name="priority" class="form-select">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
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

    {{-- Delete modal --}}
    <div class="modal fade" id="deleteTaskModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form id="deleteForm">
                    <input type="hidden" name="id">
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

    {{-- Details modal --}}
    <div class="modal fade" id="detailsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="dDescription" class="mb-4"></p>
                    <div class="row g-3">
                        <div class="col-6"><small class="d-block">Category</small><span id="dCategory"></span></div>
                        <div class="col-6"><small class="d-block">Priority</small><span id="dPriority"></span></div>
                        <div class="col-6"><small class="d-block">Status</small><span id="dStatus"></span></div>
                        <div class="col-6"><small class="d-block">Due date</small><span id="dDue"></span></div>
                        <div class="col-6"><small class="d-block">Created</small><span id="dCreated"></span></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // ---------- Axios setup ----------
    const api = axios.create({
        baseURL: '/api',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    });

    // Session expired: send the user back to login
    api.interceptors.response.use(r => r, err => {
        if (err.response && err.response.status === 401) window.location.href = '/login';
        return Promise.reject(err);
    });

    // ---------- State and helpers ----------
    let page = 1;
    let tasksById = {};
    const $ = id => document.getElementById(id);
    const today = new Date().toISOString().split('T')[0];

    const esc = s => String(s ?? '').replace(/[&<>"']/g, c =>
        ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const cap = s => s.charAt(0).toUpperCase() + s.slice(1);
    const fmt = d => d ? new Date(d + 'T00:00:00').toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' }) : '-';

    function toast(message, danger = false) {
        const el = $('appToast');
        el.classList.toggle('toast-danger', danger);
        $('appToastBody').textContent = message;
        bootstrap.Toast.getOrCreateInstance(el).show();
    }

    function hideModal(id) {
        bootstrap.Modal.getInstance($(id))?.hide();
    }

    function clearErrors(form) {
        form.querySelectorAll('.is-invalid').forEach(e => e.classList.remove('is-invalid'));
    }

    function showErrors(form, errors) {
        clearErrors(form);
        Object.keys(errors).forEach(field => {
            const box = form.querySelector(`[data-error="${field}"]`);
            if (box) {
                box.textContent = errors[field][0];
                box.previousElementSibling.classList.add('is-invalid');
            }
        });
    }

    function handleError(err, form) {
        if (err.response && err.response.status === 422 && form) {
            showErrors(form, err.response.data.errors);
        } else if (err.response && err.response.status === 403) {
            toast('You are not allowed to do that.', true);
        } else {
            toast('Something went wrong. Please try again.', true);
        }
    }

    // ---------- Load categories ----------
    async function loadCategories() {
        try {
            const res = await api.get('/categories');
            const options = res.data.data.map(c => `<option value="${c.id}">${esc(c.name)}</option>`).join('');
            $('fCategory').insertAdjacentHTML('beforeend', options);
            document.querySelectorAll('.category-select').forEach(s => s.insertAdjacentHTML('beforeend', options));
        } catch (e) {
            toast('Could not load categories.', true);
        }
    }

    // ---------- Load and render tasks ----------
    async function loadTasks() {
        $('taskBody').innerHTML = '<tr><td colspan="6" class="text-center py-4">Loading tasks...</td></tr>';
        try {
            const res = await api.get('/tasks', {
                params: {
                    page,
                    search: $('fSearch').value,
                    category: $('fCategory').value,
                    status: $('fStatus').value
                }
            });
            const tasks = res.data.data;
            const meta = res.data.meta;

            // If we deleted the last item on a page, go back one page
            if (tasks.length === 0 && page > 1) { page--; return loadTasks(); }

            tasksById = {};
            tasks.forEach(t => tasksById[t.id] = t);

            renderStats(res.data.stats);
            renderRows(tasks);
            renderPager(meta);
        } catch (e) {
            $('taskBody').innerHTML = '<tr><td colspan="6" class="text-center py-4 text-danger">Could not load tasks. Please refresh the page.</td></tr>';
        }
    }

    function renderStats(s) {
        $('statTotal').textContent = s.total;
        $('statPending').textContent = s.pending;
        $('statDone').textContent = s.done;
    }

    function renderRows(tasks) {
        $('checkAll').checked = tasks.length > 0 && tasks.every(t => t.status === 'done');
        $('checkAll').disabled = tasks.length === 0;

        if (tasks.length === 0) {
            $('taskBody').innerHTML = '<tr><td colspan="6" class="text-center py-4">No tasks found.</td></tr>';
            return;
        }

        $('taskBody').innerHTML = tasks.map(t => `
            <tr>
                <td>
                    <div class="d-flex align-items-start gap-3">
                        <input type="checkbox" class="form-check-input mt-1 row-check" data-id="${t.id}" ${t.status === 'done' ? 'checked' : ''}>
                        <div>
                            <div class="fw-semibold task-link ${t.status === 'done' ? 'text-decoration-line-through' : ''}"
                                 data-bs-toggle="modal" data-bs-target="#detailsModal" data-id="${t.id}">${esc(t.title)}</div>
                            <small>${esc(t.description)}</small>
                        </div>
                    </div>
                </td>
                <td><span class="tag tag-${esc(t.category.name.toLowerCase())}">${esc(t.category.name)}</span></td>
                <td><span class="prio prio-${t.priority}">${cap(t.priority)}</span></td>
                <td>${cap(t.status)}</td>
                <td class="${t.is_overdue ? 'text-overdue' : ''}">
                    ${fmt(t.due_date)}
                    ${t.is_overdue ? '<span class="badge-overdue">Overdue</span>' : ''}
                </td>
                <td class="text-end">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editTaskModal" data-id="${t.id}">Edit</button>
                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTaskModal" data-id="${t.id}">Delete</button>
                </td>
            </tr>`).join('');
    }

    function renderPager(meta) {
        if (meta.last_page <= 1) { $('pager').innerHTML = ''; return; }
        let html = `<li class="page-item ${meta.current_page === 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${meta.current_page - 1}">&laquo;</a></li>`;
        for (let i = 1; i <= meta.last_page; i++) {
            html += `<li class="page-item ${i === meta.current_page ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
        }
        html += `<li class="page-item ${meta.current_page === meta.last_page ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${meta.current_page + 1}">&raquo;</a></li>`;
        $('pager').innerHTML = html;
    }

    // ---------- Filters, pagination, checkboxes ----------
    $('filterForm').addEventListener('submit', e => { e.preventDefault(); page = 1; loadTasks(); });

    $('pager').addEventListener('click', e => {
        e.preventDefault();
        const link = e.target.closest('[data-page]');
        if (!link || link.parentElement.classList.contains('disabled')) return;
        page = Number(link.dataset.page);
        loadTasks();
    });

    $('taskBody').addEventListener('change', async e => {
        if (!e.target.classList.contains('row-check')) return;
        try {
            await api.patch(`/tasks/${e.target.dataset.id}/done`);
            toast('Task updated!');
            loadTasks();
        } catch (err) { handleError(err); loadTasks(); }
    });

    $('checkAll').addEventListener('change', async e => {
        const ids = Object.keys(tasksById);
        if (ids.length === 0) return;
        try {
            await api.patch('/tasks/done-all', { ids, status: e.target.checked ? 'done' : 'pending' });
            toast('Tasks updated!');
            loadTasks();
        } catch (err) { handleError(err); loadTasks(); }
    });

    // ---------- Create ----------
    $('createTaskModal').addEventListener('show.bs.modal', () => {
        const f = $('createForm');
        f.reset();
        clearErrors(f);
        f.due_date.min = today;
    });

    $('createForm').addEventListener('submit', async e => {
        e.preventDefault();
        const f = e.target;
        try {
            await api.post('/tasks', Object.fromEntries(new FormData(f)));
            hideModal('createTaskModal');
            toast('Task created!');
            page = 1;
            loadTasks();
        } catch (err) { handleError(err, f); }
    });

    // ---------- Edit ----------
    $('editTaskModal').addEventListener('show.bs.modal', e => {
        const t = tasksById[e.relatedTarget?.dataset.id];
        if (!t) return;
        const f = $('editForm');
        clearErrors(f);
        f.id.value = t.id;
        f.title.value = t.title;
        f.description.value = t.description ?? '';
        f.category_id.value = t.category_id;
        f.status.value = t.status;
        f.priority.value = t.priority;
        f.due_date.value = t.due_date ?? '';
        // Overdue tasks may keep their old date; others must pick today or later
        f.due_date.min = (t.due_date && t.due_date < today) ? t.due_date : today;
    });

    $('editForm').addEventListener('submit', async e => {
        e.preventDefault();
        const f = e.target;
        const data = Object.fromEntries(new FormData(f));
        try {
            await api.put(`/tasks/${data.id}`, data);
            hideModal('editTaskModal');
            toast('Task updated!');
            loadTasks();
        } catch (err) { handleError(err, f); }
    });

    // ---------- Delete ----------
    $('deleteTaskModal').addEventListener('show.bs.modal', e => {
        const t = tasksById[e.relatedTarget?.dataset.id];
        if (!t) return;
        $('deleteForm').id.value = t.id;
        $('deleteTitle').textContent = t.title;
    });

    $('deleteForm').addEventListener('submit', async e => {
        e.preventDefault();
        try {
            await api.delete(`/tasks/${e.target.id.value}`);
            hideModal('deleteTaskModal');
            toast('Task deleted!', true);
            loadTasks();
        } catch (err) { handleError(err); }
    });

    // ---------- Details ----------
    $('detailsModal').addEventListener('show.bs.modal', e => {
        const t = tasksById[e.relatedTarget?.dataset.id];
        if (!t) return;
        $('dTitle').textContent = t.title;
        $('dDescription').textContent = t.description || 'No description';
        $('dCategory').textContent = t.category.name;
        $('dPriority').textContent = cap(t.priority);
        $('dStatus').textContent = cap(t.status);
        $('dDue').textContent = t.due_date ? fmt(t.due_date) + (t.is_overdue ? ' (Overdue)' : '') : 'No due date';
        $('dCreated').textContent = fmt(t.created_at);
    });

    // ---------- Start ----------
    loadCategories().then(loadTasks);
</script>
@endpush