
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4>Detail Angsuran</h4>
        </div>

        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th width="35%">Nama Anggota</th>
                    <td>{{ $angsuran->pinjaman->anggota->nama ?? '-' }}</td>
                </tr>

                <tr>
                    <th>ID Pinjaman</th>
                    <td>{{ $angsuran->pinjaman_id }}</td>
                </tr>

                <tr>
                    <th>Jumlah Pinjaman</th>
                    <td>
                        Rp {{ number_format($angsuran->pinjaman->jumlah_disetujui ?? 0, 0, ',', '.') }}
                    </td>
                </tr>

                <tr>
                    <th>Tanggal Pembayaran</th>
                    <td>{{ $angsuran->tanggal_bayar }}</td>
                </tr>

                <tr>
                    <th>Jumlah Angsuran</th>
                    <td>
                        Rp {{ number_format($angsuran->jumlah_bayar, 0, ',', '.') }}
                    </td>
                </tr>
            </table>

            <a href="{{ route('angsurans.index') }}" class="btn btn-secondary">
                Kembali
            </a>

            <a href="{{ route('angsurans.edit', $angsuran->id) }}" class="btn btn-warning">
                Edit Angsuran
            </a>

        </div>
    </div>
</div>
@endsection
