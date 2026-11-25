<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in | Task Manager</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>
        :root {
            --cream: #EAE8D5;
            --cream-light: #F7F6EA;
            --green: #5F7A4B;
            --green-dark: #43533A;
            --sage: #9AAA8A;
        }
        body { background: var(--cream); color: var(--green-dark); font-family: 'DM Sans', sans-serif; min-height: 100vh; }
        .brand-icon { width: 96px; height: 96px; object-fit: contain; margin: -20px 0; }
        .eyebrow { font-size: 11px; letter-spacing: 1.2px; font-weight: 700; color: var(--green); text-transform: uppercase; }
        .hero-title { font-size: 64px; font-weight: 700; line-height: 1.05; letter-spacing: -2px; }
        .hero-text { color: #6B7A5F; max-width: 440px; }
        .login-card { background: var(--cream-light); border: 1px solid #DDDBC6; border-radius: 16px; padding: 32px; transform: rotate(1deg); box-shadow: 0 12px 30px rgba(67, 83, 58, .12); }
        .form-control { background: white; border: 1px solid #DDDBC6; border-radius: 9px; padding: 10px 12px; }
        .form-control:focus { border-color: var(--green); box-shadow: 0 0 0 3px rgba(95, 122, 75, .2); }
        .btn-primary { background: var(--green-dark); border-color: var(--green-dark); border-radius: 9px; padding: 10px; font-weight: 500; }
        .btn-primary:hover { background: var(--green); border-color: var(--green); }
        .form-check-input { border: 2px solid #8A9189; }
        .form-check-input:checked { background-color: var(--green-dark); border-color: var(--green-dark); }
        .hint { font-size: 12px; color: #6B7A5F; }
        .toggle-pass { position: absolute; top: 50%; right: 12px; transform: translateY(-50%); background: none; border: 0; font-size: 13px; font-weight: 500; color: var(--green-dark); cursor: pointer; }
        @media (max-width: 991px) { .hero-title { font-size: 44px; } .login-card { transform: none; } }
    </style>
</head>
<body>

    <div class="container py-4">
        <div class="d-flex align-items-center gap-2 mb-5">
          <img src="{{ asset('assets/logo.png') }}" alt="Task Manager Logo" class="brand-icon">
            <span class="fs-5 fw-semibold">Task Manager</span>
        </div>

        <div class="row align-items-center g-5">
            <!-- Hero -->
            <div class="col-lg-6" style="margin-top: -60px;">
                <div class="eyebrow mb-3">A little more organized</div>
                <h1 class="hero-title mb-4">Make Time for what matters.</h1>
                <p class="hero-text">
                    A simple Task Manager for Home,school, work, and everything else on your list.
                    See what needs doing, keep your week clear, and move one task at a time.
                </p>
            </div>

            <!-- Login form -->
            <div class="col-lg-5 offset-lg-1">
                <div class="login-card">
                    <h2 class="h4 fw-bold mb-1">Welcome back</h2>
                    <p class="hint mb-4">Sign in to see your tasks.</p>

                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror" autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="position-relative">
                                <input type="password" id="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror">
                                <button type="button" class="toggle-pass" data-target="password">Show</button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-4">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                    </form>

                    <p class="hint mt-4 mb-0">No account yet? <a href="{{ route('register') }}" style="color: var(--green-dark); font-weight: 500;">Create one</a></p>
                </div>
            </div>
        </div>
    </div>

<script>
    document.querySelectorAll('.toggle-pass').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const input = document.getElementById(btn.dataset.target);
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.textContent = show ? 'Hide' : 'Show';
        });
    });
</script>
</body>
</html>