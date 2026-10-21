<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Simpanan | KoperasiKu</title>

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
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

            <div>
                <h1 class="fw-bold mb-1">
                    Simpanan
                </h1>

                <p class="text-secondary mb-0">
                    Pencatatan simpanan pokok, wajib, dan sukarela anggota.
                </p>
            </div>

            <a
                href="{{ route('simpanan.create') }}"
                class="btn btn-primary"
            >
                + Catat Simpanan
            </a>

        </div>


        <!-- Notifikasi berhasil -->
        @if(session('success'))

            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert"
            >
                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Tutup"
                ></button>

            </div>

        @endif


        <!-- Notifikasi error -->
        @if($errors->any())

            <div class="alert alert-danger">

                <strong>Terjadi kesalahan:</strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <!-- Tabel Simpanan -->
        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-primary">

                            <tr>
                                <th>No.</th>
                                <th>Nama Anggota</th>
                                <th>Jenis Simpanan</th>
                                <th>Nominal</th>
                                <th>Tanggal Transaksi</th>
                            </tr>

                        </thead>


                        <tbody>

                            @forelse($simpanan as $item)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>


                                    <td class="fw-semibold">
                                        {{ $item->anggota?->nama ?? '-' }}
                                    </td>


                                    <td>

                                        @if($item->jenis_simpanan === 'Pokok')

                                            <span class="badge text-bg-primary">
                                                Simpanan Pokok
                                            </span>

                                        @elseif($item->jenis_simpanan === 'Wajib')

                                            <span class="badge text-bg-success">
                                                Simpanan Wajib
                                            </span>

                                        @elseif($item->jenis_simpanan === 'Sukarela')

                                            <span class="badge text-bg-info">
                                                Simpanan Sukarela
                                            </span>

                                        @else

                                            {{ $item->jenis_simpanan }}

                                        @endif

                                    </td>


                                    <td class="text-nowrap">
                                        Rp
                                        {{ number_format((float) $item->jumlah, 0, ',', '.') }}
                                    </td>


                                    <td>
                                        {{ \Carbon\Carbon::parse($item->tanggal_simpanan)->format('d-m-Y') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="5"
                                        class="text-center text-secondary py-4"
                                    >

                                        <div class="mb-2">
                                            <strong>
                                                Belum ada data simpanan.
                                            </strong>
                                        </div>

                                        Silakan klik tombol
                                        <strong>Catat Simpanan</strong>
                                        untuk menambahkan transaksi.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                <!-- Total -->
                <div class="text-muted small mt-3">
                    Total transaksi:
                    {{ $simpanan->count() }}
                    data
                </div>

            </div>

        </div>


        <!-- Kembali -->
        <div class="mt-3">

            <a
                href="{{ route('anggota.index') }}"
                class="btn btn-outline-secondary btn-sm"
            >
                &larr; Kembali ke Daftar Anggota
            </a>

        </div>

    </main>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>

</body>
</html>
