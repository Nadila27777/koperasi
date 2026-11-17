@extends('layouts.app')

@section('title', 'Data Angsuran')
@section('page-title', 'Data Angsuran')

@section('content')

<div class="container-fluid">

    {{-- Tombol Tambah Angsuran --}}
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('angsurans.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Angsuran
            </a>
        </div>
    </div>

    {{-- Ringkasan Pembayaran --}}
    <div class="row">
        @foreach($ringkasanPinjaman as $id => $ringkasan)
            <div class="col-md-4 mb-3">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            Pinjaman #{{ $id }}
                        </h3>
                    </div>

                    <div class="card-body">
                        <p>
                            Total Kewajiban:
                            <strong>
                                Rp {{ number_format($ringkasan['total_kewajiban'], 0, ',', '.') }}
                            </strong>
                        </p>

                        <p>
                            Total Dibayar:
                            <strong>
                                Rp {{ number_format($ringkasan['total_bayar'], 0, ',', '.') }}
                            </strong>
                        </p>

                        <p>
                            Sisa Pembayaran:
                            <strong>
                                Rp {{ number_format($ringkasan['sisa'], 0, ',', '.') }}
                            </strong>
                        </p>

                        @if($ringkasan['status_pembayaran'] == 'Lunas')
                            <span class="badge badge-success">
                                Lunas
                            </span>
                        @else
                            <span class="badge badge-warning">
                                Belum Lunas
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Riwayat Pembayaran --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Riwayat Pembayaran Angsuran
            </h3>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Anggota</th>
                        <th>ID Pinjaman</th>
                        <th>Tanggal Bayar</th>
                        <th>Jumlah Bayar</th>
                        <th>Total Dibayar</th>
                        <th>Sisa</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($angsurans as $key => $angsuran)

                        @php
                            $ringkasan = $ringkasanPinjaman[$angsuran->pinjaman_id] ?? null;
                        @endphp

                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td>
                                {{ $angsuran->pinjaman->anggota->nama ?? '-' }}
                            </td>

                            <td>
                                {{ $angsuran->pinjaman_id }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($angsuran->tanggal_bayar)->format('d-m-Y') }}
                            </td>

                            <td>
                                Rp {{ number_format($angsuran->jumlah_bayar, 0, ',', '.') }}
                            </td>

                            <td>
                                Rp {{ number_format($ringkasan['total_bayar'] ?? 0, 0, ',', '.') }}
                            </td>

                            <td>
                                Rp {{ number_format($ringkasan['sisa'] ?? 0, 0, ',', '.') }}
                            </td>

                            <td>
                                @if(($ringkasan['status_pembayaran'] ?? '') == 'Lunas')
                                    <span class="badge badge-success">
                                        Lunas
                                    </span>
                                @else
                                    <span class="badge badge-warning">
                                        Belum Lunas
                                    </span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('angsurans.edit', $angsuran->id) }}"
                                   class="btn btn-warning btn-sm"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('angsurans.destroy', $angsuran->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus angsuran ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="9" class="text-center">
                                Belum ada data angsuran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
