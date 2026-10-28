<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Anggota | KoperasiKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            font-size: 14px;
        }

        .page-title {
            font-size: 25px;
            font-weight: 400;
            margin-bottom: 18px;
        }

        .card {
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }

        .card-header {
            background: #fff;
            font-weight: 600;
            padding: 12px 16px;
        }

        .table th {
            background: #f4f6f9;
            white-space: nowrap;
            font-size: 12px;
        }

        .table td {
            font-size: 12px;
            vertical-align: middle;
        }

        .sidebar {
            width: 230px;
            min-height: 100vh;
            background: #343a40;
            color: #fff;
            position: fixed;
            inset: 0 auto 0 0;
        }

        .brand {
            padding: 17px;
            text-align: center;
            font-size: 19px;
            font-weight: bold;
            border-bottom: 1px solid #4b545c;
        }

        .sidebar a {
            display: block;
            color: #c2c7d0;
            text-decoration: none;
            padding: 12px 18px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #007bff;
            color: white;
        }

        .main {
            margin-left: 230px;
            min-height: 100vh;
        }

        .topbar {
            background: #fff;
            padding: 14px 22px;
            border-bottom: 1px solid #dee2e6;
        }

        .content {
            padding: 24px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 175px;
            }

            .main {
                margin-left: 175px;
            }

            .content {
                padding: 12px;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="brand">
            <i class="fa-solid fa-building-columns"></i> KoperasiKu
        </div>

        <div class="py-3 px-3 border-bottom">
            <i class="fa-solid fa-circle-user me-2"></i>
            <strong>Administrator</strong>
            <div class="small ms-4">Admin</div>
        </div>

        <nav class="mt-2">
            <a href="{{ route('dashboard') }}">
                <i class="fa-solid fa-gauge me-2"></i> Dashboard
            </a>

            <a href="{{ route('anggotas.index') }}" class="active">
                <i class="fa-solid fa-users me-2"></i> Data Anggota
            </a>

            <a href="{{ route('simpanans.index') }}">
                <i class="fa-solid fa-wallet me-2"></i> Simpanan
            </a>

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('users.index') }}">
                    <i class="fa-solid fa-user-gear me-2"></i> Manajemen User
                </a>
            @endif
        </nav>
    </aside>

    <!-- Konten utama -->
    <div class="main">

        <header class="topbar d-flex justify-content-between align-items-center">
            <span><i class="fa-solid fa-bars"></i></span>

            <div>
                <i class="fa-solid fa-user-circle me-1"></i>
                {{ auth()->user()->name ?? 'Administrator' }}

                <form action="{{ route('logout') }}" method="POST" class="d-inline ms-3">
                    @csrf
                    <button class="btn btn-danger btn-sm" type="submit">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </header>

        <main class="content">

            <h1 class="page-title">Data Anggota</h1>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fa-solid fa-users me-2"></i>
                        Daftar Anggota Koperasi
                    </span>

                    <a href="{{ route('anggotas.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-plus me-1"></i> Tambah Anggota
                    </a>
                </div>

                <div class="card-body">

                    <form action="{{ route('anggotas.index') }}" method="GET" class="mb-4">
                        <div class="row align-items-center g-2">
                            <div class="col-md-1">
                                <label for="search" class="form-label mb-0">Cari Anggota</label>
                            </div>

                            <div class="col-md-5">
                                <input
                                    type="text"
                                    id="search"
                                    name="search"
                                    class="form-control form-control-sm"
                                    placeholder="Nomor anggota, NIK, nama, atau No. HP..."
                                    value="{{ request('search') }}"
                                >
                            </div>

                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-magnifying-glass"></i> Cari
                                </button>
                            </div>

                            <div class="col-auto">
                                <a href="{{ route('anggotas.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fa-solid fa-rotate-left"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>No. Anggota</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>No. HP</th>
                                    <th>Tanggal Bergabung</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($anggota as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->no_anggota ?? '-' }}</td>
                                        <td>{{ $item->nik ?? '-' }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->jenis_kelamin ?? '-' }}</td>
                                        <td>{{ $item->no_telepon }}</td>
                                        <td>{{ $item->tanggal_bergabung }}</td>
                                        <td>
                                            @if(($item->status ?? 'Aktif') === 'Aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">
                                            <a href="{{ route('anggotas.show', $item->id) }}"
                                               class="btn btn-info btn-sm text-white"
                                               title="Detail">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            <a href="{{ route('anggotas.edit', $item->id) }}"
                                               class="btn btn-warning btn-sm"
                                               title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <form action="{{ route('anggotas.destroy', $item->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            Belum ada data anggota.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="text-muted small">
                        Menampilkan {{ $anggota->count() }} data anggota.
                    </div>

                </div>
            </div>

        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
