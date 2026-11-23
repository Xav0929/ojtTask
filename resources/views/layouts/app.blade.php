<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Task Manager')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>
        body { background: #F7F6F2; }
        .sidebar { width: 220px; min-height: 100vh; background: white; border-right: 1px solid #ECEAE3; }
        .btn-primary { background: #1F5C45; border-color: #1F5C45; }
        .btn-primary:hover { background: #174836; border-color: #174836; }
    </style>
</head>
<body>

    <div class="d-flex">

        <!-- Sidebar -->
        <div class="sidebar p-3">
            <h5 class="mb-4">Task Manager</h5>

            <p class="text-muted small mb-1">WORKSPACE</p>
            <a href="{{ route('tasks.index') }}" class="d-block py-1 text-dark text-decoration-none">All tasks</a>

            <p class="text-muted small mb-1 mt-4">CATEGORIES</p>
            <div class="py-1">Work</div>
            <div class="py-1">School</div>
            <div class="py-1">Personal</div>
        </div>

        <!-- Page content -->
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>