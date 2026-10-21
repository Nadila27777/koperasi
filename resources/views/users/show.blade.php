<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail User - KoperasiKu</title>

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

        .detail-label {
            font-weight: bold;
            color: #334155;
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
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">Detail User</h2>

            <p class="text-muted mb-0">
                Informasi lengkap pengguna.
            </p>
        </div>

        <a href="{{ route('users.index') }}"
           class="btn btn-secondary">
            Kembali
        </a>

    </div>


    {{-- DETAIL CARD --}}
    <div class="card shadow-sm">

        <div class="card-body">

            {{-- NAMA --}}
            <div class="row mb-3">
                <div class="col-md-3 detail-label">
                    Nama
                </div>

                <div class="col-md-9">
                    {{ $user->name }}
                </div>
            </div>


            {{-- EMAIL --}}
            <div class="row mb-3">
                <div class="col-md-3 detail-label">
                    Email
                </div>

                <div class="col-md-9">
                    {{ $user->email }}
                </div>
            </div>


            {{-- ROLE --}}
            <div class="row mb-3">
                <div class="col-md-3 detail-label">
                    Role
                </div>

                <div class="col-md-9">

                    @switch($user->role)

                        @case('admin')
                            <span class="badge bg-danger">
                                Admin
                            </span>
                            @break

                        @case('pengurus')
                            <span class="badge bg-primary">
                                Pengurus
                            </span>
                            @break

                        @case('bendahara')
                            <span class="badge bg-warning text-dark">
                                Bendahara
                            </span>
                            @break

                        @case('anggota')
                            <span class="badge bg-info text-dark">
                                Anggota
                            </span>
                            @break

                        @default
                            <span class="badge bg-secondary">
                                {{ $user->role ?? 'Belum ditentukan' }}
                            </span>

                    @endswitch

                </div>
            </div>


            {{-- STATUS --}}
            <div class="row mb-3">
                <div class="col-md-3 detail-label">
                    Status
                </div>

                <div class="col-md-9">

                    @if ($user->status === 'aktif')

                        <span class="badge bg-success">
                            Aktif
                        </span>

                    @else

                        <span class="badge bg-secondary">
                            Nonaktif
                        </span>

                    @endif

                </div>
            </div>


            {{-- STATUS AKUN --}}
            <div class="row mb-3">
                <div class="col-md-3 detail-label">
                    Status Akun
                </div>

                <div class="col-md-9">

                    @if ($user->is_active)

                        <span class="badge bg-success">
                            Aktif
                        </span>

                    @else

                        <span class="badge bg-danger">
                            Nonaktif
                        </span>

                    @endif

                </div>
            </div>


            {{-- DIBUAT --}}
            <div class="row mb-3">
                <div class="col-md-3 detail-label">
                    Dibuat
                </div>

                <div class="col-md-9">
                    {{ $user->created_at?->format('d-m-Y H:i') ?? '-' }}
                </div>
            </div>


            {{-- TERAKHIR DIUBAH --}}
            <div class="row">
                <div class="col-md-3 detail-label">
                    Terakhir Diubah
                </div>

                <div class="col-md-9">
                    {{ $user->updated_at?->format('d-m-Y H:i') ?? '-' }}
                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>