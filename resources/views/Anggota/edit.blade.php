<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota | KoperasiKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary px-4">
    <a class="navbar-brand fw-bold" href="{{ route('anggota.index') }}">KoperasiKu</a>
    <span class="text-white">Edit Anggota</span>
</nav>

<div class="container mt-4">
    <div class="card border-0 shadow-sm mx-auto" style="max-width: 700px;">
        <div class="card-body p-4">
            <h2 class="mb-1">Edit Anggota</h2>
            <p class="text-muted">Perbarui informasi anggota koperasi.</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('anggota.update', $anggota->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control"
                           value="{{ old('nama', $anggota->nama) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control"
                              rows="3" required>{{ old('alamat', $anggota->alamat) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="text" name="no_telepon" class="form-control"
                           value="{{ old('no_telepon', $anggota->no_telepon) }}"
                           maxlength="15" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Tanggal Bergabung</label>
                    <input type="date" name="tanggal_bergabung" class="form-control"
                           value="{{ old('tanggal_bergabung', $anggota->tanggal_bergabung) }}"
                           required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('anggota.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
