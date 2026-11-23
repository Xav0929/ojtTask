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
    </style>
</head>
<body>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('tasks.index') }}" class="fs-5 fw-bold text-decoration-none" style="color: var(--green-dark);">Task Manager</a>
            
        </div>
    </div>

    <div class="container pb-5">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>