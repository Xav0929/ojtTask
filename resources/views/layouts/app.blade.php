<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Task Manager')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

   <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.9/dist/axios.min.js"></script>
    @stack('scripts')
</body>
</html>