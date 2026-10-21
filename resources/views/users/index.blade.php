<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Manajemen User | KoperasiKu</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm">
        <div class="container-fluid px-4">

            <a
                class="navbar-brand fw-bold text-primary"
                href="{{ route('anggota.index') }}"
            >
                KoperasiKu
            </a>

            <div class="navbar-nav ms-4">

                <a
                    class="nav-link text-secondary"
                    href="{{ route('anggota.index') }}"
                >
                    Daftar Anggota
                </a>

                <a
                    class="nav-link text-secondary"
                    href="{{ route('simpanan.index') }}"
                >
                    Simpanan
                </a>

                <a
                    class="nav-link text-secondary"
                    href="{{ route('users.index') }}"
                >
                    Manajemen User
                </a>

            </div>

        </div>
    </nav>


    <!-- Konten -->
    <main class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h1 class="fw-bold mb-1">
                    Manajemen User
                </h1>

                <p class="text-secondary mb-0">
                    Kelola data pengguna koperasi.
                </p>
            </div>

            <a
                href="{{ route('users.create') }}"
                class="btn btn-primary"
            >
                + Tambah User
            </a>

        </div>


        <!-- Notifikasi -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        <!-- Search -->
        <form
            action="{{ route('users.index') }}"
            method="GET"
            class="mb-4"
        >

            <div class="row g-2">

                <div class="col-md-6">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari nama atau email..."
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="col-md-3">
                    <select
                        name="role"
                        class="form-select"
                    >
                        <option value="">Semua role</option>

                        <option
                            value="admin"
                            {{ request('role') == 'admin' ? 'selected' : '' }}
                        >
                            Admin
                        </option>

                        <option
                            value="pengurus"
                            {{ request('role') == 'pengurus' ? 'selected' : '' }}
                        >
                            Pengurus
                        </option>

                        <option
                            value="bendahara"
                            {{ request('role') == 'bendahara' ? 'selected' : '' }}
                        >
                            Bendahara
                        </option>

                        <option
                            value="anggota"
                            {{ request('role') == 'anggota' ? 'selected' : '' }}
                        >
                            Anggota
                        </option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Cari
                    </button>

                    <a
                        href="{{ route('users.index') }}"
                        class="btn btn-secondary"
                    >
                        Reset
                    </a>

                </div>

            </div>

        </form>


        <!-- Tabel -->
        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-primary">
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Status Akun</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($users as $user)

                                <tr>

                                    <td>
                                        {{ $users->firstItem() + $loop->index }}
                                    </td>

                                    <td class="fw-semibold">
                                        {{ $user->name }}
                                    </td>

                                    <td>
                                        {{ $user->email }}
                                    </td>

                                    <td>

                                        @if($user->role === 'admin')
                                            <span class="badge text-bg-primary">
                                                Admin
                                            </span>

                                        @elseif($user->role === 'pengurus')
                                            <span class="badge text-bg-success">
                                                Pengurus
                                            </span>

                                        @elseif($user->role === 'bendahara')
                                            <span class="badge text-bg-warning">
                                                Bendahara
                                            </span>

                                        @else
                                            <span class="badge text-bg-secondary">
                                                Anggota
                                            </span>
                                        @endif

                                    </td>

                                    <td>

                                        @if($user->status === 'aktif')
                                            <span class="badge text-bg-success">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="badge text-bg-danger">
                                                Nonaktif
                                            </span>
                                        @endif

                                    </td>

                                    <td>

                                        @if($user->is_active)
                                            <span class="badge text-bg-success">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="badge text-bg-danger">
                                                Nonaktif
                                            </span>
                                        @endif

                                    </td>

                                    <td class="text-nowrap">

                                        <a
                                            href="{{ route('users.show', $user) }}"
                                            class="btn btn-sm btn-info text-white"
                                        >
                                            Detail
                                        </a>

                                        <a
                                            href="{{ route('users.edit', $user) }}"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Edit
                                        </a>

                                        @if(auth()->id() !== $user->id)

                                            <form
                                                action="{{ route('users.destroy', $user) }}"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus user ini?')"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-danger"
                                                >
                                                    Hapus
                                                </button>

                                            </form>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td
                                        colspan="7"
                                        class="text-center text-secondary py-4"
                                    >
                                        Belum ada data user.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-3">
                    {{ $users->links() }}
                </div>

            </div>

        </div>

    </main>

</body>
</html>
