<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Daftar Anggota | KoperasiKu</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm">
        <div class="container-fluid px-4">

            <!-- Nama Koperasi -->
            <a
                class="navbar-brand fw-bold text-primary"
                href="{{ route('anggota.index') }}"
            >
                KoperasiKu
            </a>

            <!-- Menu -->
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

        <!-- Judul -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h1 class="fw-bold mb-1">
                    Daftar Anggota
                </h1>

                <p class="text-secondary mb-0">
                    Kelola data anggota koperasi.
                </p>
            </div>

            <a
                href="{{ route('anggota.create') }}"
                class="btn btn-primary"
            >
                + Tambah Anggota
            </a>

        </div>


        <!-- Pesan sukses -->
        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif


        <!-- Tabel Anggota -->
        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-primary">

                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No. Telepon</th>
                                <th>Tanggal Bergabung</th>
                                <th>Aksi</th>
                            </tr>

                        </thead>


                        <tbody>

                            @forelse($anggota as $item)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="fw-semibold">
                                        {{ $item->nama }}
                                    </td>

                                    <td>
                                        {{ $item->alamat }}
                                    </td>

                                    <td>
                                        {{ $item->no_telepon }}
                                    </td>

                                    <td>
                                        {{ $item->tanggal_bergabung }}
                                    </td>

                                    <td>

                                        <a
                                            href="{{ route('anggota.edit', $item->id) }}"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Edit
                                        </a>


                                        <form
                                            action="{{ route('anggota.destroy', $item->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus anggota ini?')"
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

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="text-center text-secondary py-4"
                                    >
                                        Belum ada data anggota.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </main>

</body>
</html>
