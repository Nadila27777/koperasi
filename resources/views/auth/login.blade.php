<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KoperasiKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: linear-gradient(135deg, #eaf2ff, #f8fafc);
            font-family: Arial, sans-serif;
        }
        .login-card {
            width: 100%;
            max-width: 430px;
            border: 0;
            border-radius: 18px;
            box-shadow: 0 15px 40px rgba(15, 23, 42, .12);
            overflow: hidden;
        }
        .login-header {
            background: #0d6efd;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .login-body { padding: 30px; }
        .form-control {
            padding: 12px;
            border-radius: 9px;
        }
        .btn-login {
            padding: 12px;
            border-radius: 9px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="card login-card">
        <div class="login-header">
            <h2 class="fw-bold mb-2">KoperasiKu</h2>
            <p class="mb-0">Silakan masuk ke akun Anda</p>
        </div>

        <div class="login-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        autocomplete="username"
                        required
                        autofocus
                    >
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary btn-login w-100">
                    Login
                </button>
            </form>

            <p class="text-center text-secondary small mt-4 mb-0">
                Sistem Informasi KoperasiKu
            </p>
        </div>
    </div>
</body>
</html>
