@extends('layouts.app')

@section('title', 'Data Simpanan')
@section('page-title', 'Data Simpanan')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Riwayat Simpanan</h3>

        <a href="{{ route('simpanans.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Catat Simpanan
        </a>
    </div>

    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $simpanan->count() }}</h3>
                        <p>Total Transaksi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 class="text-white">
                            Rp {{ number_format($simpanan->sum('jumlah'), 0, ',', '.') }}
                        </h3>
                        <p>Total Nominal Simpanan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 55px">No.</th>
                        <th>Nama Anggota</th>
                        <th>Jenis Simpanan</th>
                        <th>Nominal</th>
                        <th>Tanggal Transaksi</th>
                        <th style="width: 200px">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($simpanan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $item->nama_anggota ?: ($item->anggota?->nama ?? '-') }}

                                @if (!$item->anggota_id)
                                    <br>
                                    <small class="text-muted">Belum terdaftar sebagai anggota</small>
                                @endif
                            </td>

                            <td>
                                @if ($item->jenis_simpanan === 'Pokok')
                                    <span class="badge badge-primary">Pokok</span>
                                @elseif ($item->jenis_simpanan === 'Wajib')
                                    <span class="badge badge-success">Wajib</span>
                                @else
                                    <span class="badge badge-info">Sukarela</span>
                                @endif
                            </td>

                            <td>
                                Rp {{ number_format((float) $item->jumlah, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_simpanan)->format('d-m-Y') }}
                            </td>

                            <td>
                                <a href="{{ route('simpanans.show', $item->id) }}"
                                   class="btn btn-info btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('simpanans.edit', $item->id) }}"
                                   class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('simpanans.destroy', $item->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Belum ada transaksi simpanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
