<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Task Manager')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>
        :root {
            --cream: #EAE8D5;
            --cream-light: #F7F6EA;
            --green: #5F7A4B;
            --green-dark: #43533A;
            --sage: #9AAA8A;
        }

        body { background: var(--cream); color: var(--green-dark); }
        h1 { color: var(--green-dark); font-weight: 700; }

        .card-box { background: var(--cream-light); border: 1px solid #DDDBC6; border-radius: 12px; }

        .btn-primary { background: var(--green-dark); border-color: var(--green-dark); }
        .btn-primary:hover { background: var(--green); border-color: var(--green); }
        .btn-secondary { background: transparent; border-color: var(--sage); color: var(--green-dark); }

        .form-control, .form-select { background: var(--cream-light); border-color: #DDDBC6; }

        .table { margin: 0; --bs-table-bg: transparent; }
        .table thead th { background: var(--sage); color: white; font-size: 12px; text-transform: uppercase; padding: 12px 16px; }
        .table td { padding: 14px 16px; }

        .tag { background: var(--cream); padding: 3px 10px; border-radius: 6px; font-size: 13px; }
        .tag-work     { background: #DCE8F2; color: #3E6A8A; }
        .form-check-input { border: 2px solid #8A9189; background-color: white; }
        .form-check-input:checked { background-color: var(--green-dark); border-color: var(--green-dark); }
        .tag-school   { background: #F6E7C8; color: #8A6420; }
        .tag-personal { background: #F2DAD4; color: #9A4F40; }
    .toast { background: var(--green-dark); color: var(--cream-light); border-radius: 8px; font-size: 13px; width: auto; max-width: 240px; }
        .toast .toast-body { padding: 8px 12px; }
        .toast-danger { background: #A35A4F; }
        .btn-danger { background: #A35A4F; border-color: #A35A4F; }
        .btn-sm { font-size: 12px; padding: 3px 10px; }
        .btn-danger:hover { background: #8A463C; border-color: #8A463C; }
    .prio::before { content: ''; display: inline-block; width: 8px; height: 8px; border-radius: 50%; margin-right: 6px; background: currentColor; }
        .prio-low    { color: #6B8F5A; }
        .prio-medium { color: #C08A2E; }
        .prio-high   { color: #A35A4F; font-weight: 600; }
        .text-overdue { color: #A35A4F; font-weight: 600; }
        .badge-overdue { background: #A35A4F; color: white; padding: 2px 8px; border-radius: 6px; font-size: 11px; margin-left: 6px; }
        .task-link { cursor: pointer; }
        .task-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('tasks.index') }}" class="fs-5 fw-bold text-decoration-none" style="color: var(--green-dark);">Task Manager</a>

            <div class="d-flex align-items-center gap-3">
                <span class="small">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-secondary">Log out</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>