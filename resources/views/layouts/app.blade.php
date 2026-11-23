<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Task Manager')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('tasks.index') }}">Task Manager</a>
          <div class="navbar-nav ms-auto gap-2">
                <a class="nav-link" href="{{ route('tasks.index') }}">Tasks</a>
                <a class="nav-link" href="{{ route('tasks.create') }}">New Task</a>
            </div>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <footer class="text-center text-muted py-4 mt-5">
        <small>&copy; {{ date('Y') }} Task Manager</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    @stack('scripts')
</body>
</html>