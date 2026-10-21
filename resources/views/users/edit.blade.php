<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit User - KoperasiKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background: #f1f5f9;
            color: #1e293b;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: #0d6efd;
        }

        .card {
            border: none;
            border-radius: 14px;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-dark">
    <div class="container">

        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            KoperasiKu
        </a>

        <div class="d-flex align-items-center gap-3">

            <span class="text-white">
                {{ auth()->user()->name }}
            </span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="btn btn-light btn-sm">
                    Logout
                </button>
            </form>

        </div>
    </div>
</nav>


<div class="container py-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h2 class="mb-1">Edit User</h2>

        <p class="text-muted mb-0">
            Ubah data pengguna.
        </p>
    </div>


    {{-- FORM CARD --}}
    <div class="card shadow-sm">

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">

                    <strong>Data belum bisa diperbarui:</strong>

                    <ul class="mb-0 mt-2">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>
            @endif


            <form action="{{ route('users.update', $user) }}"
                  method="POST">

                @csrf
                @method('PUT')


                {{-- NAMA --}}
                <div class="mb-3">

                    <label for="name" class="form-label">
                        Nama
                    </label>

                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control"
                           value="{{ old('name', $user->name) }}"
                           required>

                </div>


                {{-- EMAIL --}}
                <div class="mb-3">

                    <label for="email" class="form-label">
                        Email
                    </label>

                    <input type="email"
                           name="email"
                           id="email"
                           class="form-control"
                           value="{{ old('email', $user->email) }}"
                           required>

                </div>


                {{-- PASSWORD --}}
                <div class="mb-3">

                    <label for="password" class="form-label">
                        Password Baru
                    </label>

                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control">

                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengubah password.
                        Minimal 8 karakter jika diisi.
                    </small>

                </div>


                {{-- KONFIRMASI PASSWORD --}}
                <div class="mb-3">

                    <label for="password_confirmation"
                           class="form-label">
                        Konfirmasi Password Baru
                    </label>

                    <input type="password"
                           name="password_confirmation"
                           id="password_confirmation"
                           class="form-control">

                </div>


                {{-- ROLE --}}
                <div class="mb-3">

                    <label for="role" class="form-label">
                        Role
                    </label>

                    <select name="role"
                            id="role"
                            class="form-select"
                            required>

                        @foreach ([
                            'admin' => 'Admin',
                            'pengurus' => 'Pengurus',
                            'bendahara' => 'Bendahara',
                            'anggota' => 'Anggota'
                        ] as $value => $label)

                            <option value="{{ $value }}"
                                {{ old('role', $user->role) === $value ? 'selected' : '' }}>

                                {{ $label }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- STATUS --}}
                <div class="mb-3">

                    <label for="status" class="form-label">
                        Status
                    </label>

                    <select name="status"
                            id="status"
                            class="form-select"
                            required>

                        <option value="aktif"
                            {{ old('status', $user->status) === 'aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="nonaktif"
                            {{ old('status', $user->status) === 'nonaktif' ? 'selected' : '' }}>
                            Nonaktif
                        </option>

                    </select>

                </div>


                {{-- STATUS AKUN --}}
                <div class="mb-4">

                    <label for="is_active" class="form-label">
                        Status Akun
                    </label>

                    <select name="is_active"
                            id="is_active"
                            class="form-select"
                            required>

                        <option value="1"
                            {{ (string) old('is_active', (int) $user->is_active) === '1' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="0"
                            {{ (string) old('is_active', (int) $user->is_active) === '0' ? 'selected' : '' }}>
                            Nonaktif
                        </option>

                    </select>

                </div>


                {{-- BUTTON --}}
                <div class="d-flex justify-content-between">

                    <a href="{{ route('users.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-primary">
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>