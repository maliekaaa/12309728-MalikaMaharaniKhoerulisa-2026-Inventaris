<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Inventaris Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #1A1953;
            height: 100vh;
        }

        .login-card {
            border-radius: 15px;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">

    <div class="card login-card shadow p-4" style="width: 350px;">

        <div class="text-center mb-3">
            <h4 class="fw-bold" style="color: #1A1953;">Login</h4>
            <p class="text-muted small">Inventory Management</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success py-2">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger py-2">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <!-- Label untuk email -->
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <!-- Label untuk password -->
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn"
                style="background-color: #1A1953; border: none; color: white; width: 100%;">
                Login
            </button>
        </form>

        <p class="small text-center mt-3 mb-0">
            Anda belum memiliki akun?
            <a href="{{ route('register') }}">Register</a>
        </p>
    </div>
</body>
</html>
