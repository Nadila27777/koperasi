<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin - KoperasiKu</title>

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

        .welcome {
            background: linear-gradient(120deg, #0d6efd, #084298);
            color: white;
            padding: 30px;
            border-radius: 16px;
        }

        .stat-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 5px 18px rgba(15, 23, 42, .06);
            height: 100%;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
        }

        .menu-card {
            display: block;
            height: 100%;
            padding: 24px;
            background: white;
            color: #1e293b;
            text-decoration: none;
            border-radius: 14px;
            box-shadow: 0 5px 18px rgba(15, 23, 42, .06);
            transition: transform .2s, box-shadow .2s;
        }

        .menu-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 24px rgba(15, 23, 42, .1);
        }

        .menu-icon {
            font-size: 30px;
            margin-bottom: 12px;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-dark">
    <div class="container">

        <a class="navbar-brand fw-bold"
           href="{{ route('dashboard') }}">
            KoperasiKu
        </a>

        <div class="d-flex align-items-center gap-3">

            <span class="text-white d-none d-sm-inline">
                {{ auth()->user()->name }}
            </span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit"
                        class="btn btn-light btn-sm">
                    Logout
                </button>
            </form>

        </div>
    </div>
</nav>


<div class="container py-4 py-md-5">

    <div class="welcome mb-4">

        <p class="mb-2">
            SISTEM INFORMASI KOPERASI
        </p>

        <h2 class="fw-bold">
            Selamat datang, {{ auth()->user()->name }}!
        </h2>

        <p class="mb-0">
            Anda masuk sebagai
            <strong>{{ ucfirst(auth()->user()->role) }}</strong>.
            Kelola data koperasi melalui menu di bawah ini.
        </p>

    </div>


    <h4 class="fw-bold mb-3">
        Ringkasan Data
    </h4>


    <div class="row g-3 mb-5">

        <div class="col-12 col-md-6">

            <div class="card stat-card">

                <div class="card-body p-4">

                    <div class="text-secondary mb-2">
                        Total Anggota
                    </div>

                    <div class="stat-number text-primary">
                        {{ \App\Models\Anggota::count() }}
                    </div>

                    <div class="small text-secondary mt-2">
                        Anggota terdaftar di koperasi
                    </div>

                </div>

            </div>

        </div>


        <div class="col-12 col-md-6">

            <div class="card stat-card">

                <div class="card-body p-4">

                    <div class="text-secondary mb-2">
                        Transaksi Simpanan
                    </div>

                    <div class="stat-number text-success">
                        {{ \App\Models\Simpanan::count() }}
                    </div>

                    <div class="small text-secondary mt-2">
                        Total catatan transaksi simpanan
                    </div>

                </div>

            </div>

        </div>

    </div>


    <h4 class="fw-bold mb-3">
        Menu Pengelolaan
    </h4>


    <div class="row g-3">

        {{-- DATA ANGGOTA --}}
        <div class="col-12 col-md-4">

            <a href="{{ route('anggota.index') }}"
               class="menu-card">

                <div class="menu-icon">
                    👥
                </div>

                <h5 class="fw-bold">
                    Data Anggota
                </h5>

                <p class="text-secondary mb-0">
                    Lihat dan kelola data anggota koperasi.
                </p>

            </a>

        </div>


        {{-- DATA SIMPANAN --}}
        <div class="col-12 col-md-4">

            <a href="{{ route('simpanan.index') }}"
               class="menu-card">

                <div class="menu-icon">
                    💰
                </div>

                <h5 class="fw-bold">
                    Data Simpanan
                </h5>

                <p class="text-secondary mb-0">
                    Catat dan lihat transaksi simpanan anggota.
                </p>

            </a>

        </div>


        {{-- MANAJEMEN USER --}}
        <div class="col-12 col-md-4">

            <a href="{{ route('users.index') }}"
               class="menu-card">

                <div class="menu-icon">
                    👤
                </div>

                <h5 class="fw-bold">
                    Manajemen User
                </h5>

                <p class="text-secondary mb-0">
                    Kelola akun pengguna, role, dan status