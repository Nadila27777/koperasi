<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Catat Simpanan - KoperasiKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background: #f1f5f9;
            font-family: Arial, sans-serif;
            color: #1e293b;
        }

        .navbar {
            background: #0d6efd;
        }

        .form-card {
            max-width: 750px;
            margin: 40px auto;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .form-header {
            background: #0d6efd;
            color: white;
            padding: 25px 30px;
        }

        .form-body {
            padding: 30px;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            padding: 12px;
            border-radius: 8px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
        }

        @media (max-width: 576px) {
            .form-card {
                margin: 20px auto;
            }

            .form-body {
                padding: 20px;
            }

            .form-header {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<nav class="navbar navbar-dark">
    <div class="container">
        <a class="navbar-brand fw-bold"
           href="{{ route('anggota.index') }}">
            KoperasiKu
        </a>

        <a href="{{ route('simpanan.index') }}"
           class="btn btn-light btn-sm">
            Daftar Simpanan
        </a>
    </div>
</nav>

<div class="container">

    <div class="card form-card">

        <div class="form-header">
            <h3 class="mb-2">Catat Simpanan</h3>
            <p class="mb-0">
                Masukkan data simpanan anggota koperasi.
            </p>
        </div>

        <div class="form-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Data belum bisa disimpan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('simpanan.store') }}" method="POST">
                @csrf

                {{-- NAMA ANGGOTA --}}
                <div class="mb-4">
                    <label for="anggota_id" class="form-label">
                        Nama Anggota
                    </label>

                    <select name="anggota_id"
                            id="anggota_id"
                            class="form-select"
                            required>

                        <option value="">Pilih anggota</option>

                        @foreach ($anggota as $item)
                            <option value="{{ $item->id }}"
                                {{ old('anggota_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }} (ID: {{ $item->id }})
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- JENIS SIMPANAN --}}
                <div class="mb-4">
                    <label for="jenis_simpanan" class="form-label">
                        Jenis Simpanan
                    </label>

                    <select name="jenis_simpanan"
                            id="jenis_simpanan"
                            class="form-select"
                            required>

                        <option value="">Pilih jenis simpanan</option>

                        <option value="Pokok"
                            {{ old('jenis_simpanan') == 'Pokok' ? 'selected' : '' }}>
                            Simpanan Pokok
                        </option>

                        <option value="Wajib"
                            {{ old('jenis_simpanan') == 'Wajib' ? 'selected' : '' }}>
                            Simpanan Wajib
                        </option>

                        <option value="Sukarela"
                            {{ old('jenis_simpanan') == 'Sukarela' ? 'selected' : '' }}>
                            Simpanan Sukarela
                        </option>

                    </select>
                </div>

                {{-- NOMINAL --}}
                <div class="mb-4">
                    <label for="jumlah" class="form-label">
                        Nominal (Rp)
                    </label>

                    <input type="number"
                           name="jumlah"
                           id="jumlah"
                           class="form-control"
                           min="1"
                           step="0.01"
                           placeholder="Contoh: 100000"
                           value="{{ old('jumlah') }}"
                           required>
                </div>

                {{-- TANGGAL TRANSAKSI --}}
                <div class="mb-4">
                    <label for="tanggal_simpanan" class="form-label">
                        Tanggal Transaksi
                    </label>

                    <input type="date"
                           name="tanggal_simpanan"
                           id="tanggal_simpanan"
                           class="form-control"
                           value="{{ old('tanggal_simpanan', date('Y-m-d')) }}"
                           required>
                </div>

                <hr class="my-4">

                {{-- TOMBOL --}}
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                    <a href="{{ route('simpanan.index') }}"
                       class="btn btn-outline-secondary">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Simpan Simpanan
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

</body>
</html>
