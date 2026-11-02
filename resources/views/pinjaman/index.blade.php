@extends('layouts.app')

@section('title', 'Data Pinjaman')
@section('page-title', 'Data Pinjaman')

@section('content')

<div class="row">

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $total }}</h3>
                <p>Total Pinjaman</p>
            </div>
            <div class="icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $diajukan }}</h3>
                <p>Menunggu Persetujuan</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $disetujui }}</h3>
                <p>Disetujui</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $dicairkan }}</h3>
                <p>Sudah Dicairkan</p>
            </div>
            <div class="icon">
                <i class="fas fa-wallet"></i>
            </div>
        </div>
    </div>

</div>

<div class="card">

    <div class="card-header">
        <h3 class="card-title">Daftar Pengajuan Pinjaman</h3>

        <div class="card-tools">
            <a href="{{ route('pinjaman.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Pinjaman
            </a>
        </div>
    </div>

    <div class="card-body">

        <form method="GET" action="{{ route('pinjaman.index') }}" class="form-inline mb-3">

            <input
                type="text"
                name="search"
                class="form-control mr-2 mb-2"
                placeholder="Cari nama anggota..."
                value="{{ request('search') }}"
            >

            <select name="status" class="form-control mr-2 mb-2">
                <option value="">Semua Status</option>
                <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                <option value="dicairkan" {{ request('status') == 'dicairkan' ? 'selected' : '' }}>Dicairkan</option>
                <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>

            <button type="submit" class="btn btn-secondary mb-2">
                <i class="fas fa-search"></i> Cari
            </button>

            <a href="{{ route('pinjaman.index') }}" class="btn btn-default mb-2 ml-2">
                Reset
            </a>

        </form>

        <div class="table-responsive">

            <table class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Anggota</th>
                        <th>Jumlah Pengajuan</th>
                        <th>Jumlah Disetujui</th>
                        <th>Bunga (%)</th>
                        <th>Tenor</th>
                        <th>Status</th>
                        <th width="22%">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($pinjaman as $item)

                        <tr>
                            <td>
                                {{ $loop->iteration + ($pinjaman->currentPage() - 1) * $pinjaman->perPage() }}
                            </td>

                            <td>
                                {{ $item->anggota->nama ?? '-' }}
                            </td>

                            <td>
                                Rp {{ number_format($item->jumlah_pengajuan, 0, ',', '.') }}
                            </td>

                            <td>
                                @if($item->jumlah_disetujui !== null)
                                    Rp {{ number_format($item->jumlah_disetujui, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                {{ $item->bunga_persen }}%
                            </td>

                            <td>
                                {{ $item->tenor_bulan }} bulan
                            </td>

                            <td>
                                @php
                                    $warna = [
                                        'diajukan' => 'warning',
                                        'disetujui' => 'success',
                                        'ditolak' => 'danger',
                                        'dicairkan' => 'primary',
                                        'lunas' => 'info',
                                        'dibatalkan' => 'secondary'
                                    ];
                                @endphp

                                <span class="badge badge-{{ $warna[$item->status] ?? 'secondary' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('pinjaman.show', $item->id) }}"
                                   class="btn btn-info btn-xs"
                                   title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if($item->status == 'diajukan')

                                    <a href="{{ route('pinjaman.edit', $item->id) }}"
                                       class="btn btn-warning btn-xs"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('pinjaman.destroy', $item->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-xs" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </form>

                                @endif
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center">
                                Belum ada data pinjaman.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">
            {{ $pinjaman->links() }}
        </div>

    </div>

</div>

@endsection
