@extends('layouts.app')

@section('title', 'Detail Simpanan')
@section('page-title', 'Detail Simpanan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Informasi Transaksi</h3>
    </div>

    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nama Anggota</dt>
            <dd class="col-sm-9">
                {{ $simpanan->nama_anggota ?: ($simpanan->anggota?->nama ?? '-') }}

                @if (!$simpanan->anggota_id)
                    <small class="text-muted d-block">Belum terdaftar sebagai anggota</small>
                @endif
            </dd>

            <dt class="col-sm-3">Jenis Simpanan</dt>
            <dd class="col-sm-9">{{ $simpanan->jenis_simpanan }}</dd>

            <dt class="col-sm-3">Nominal</dt>
            <dd class="col-sm-9">
                Rp {{ number_format((float) $simpanan->jumlah, 0, ',', '.') }}
            </dd>

            <dt class="col-sm-3">Tanggal Transaksi</dt>
            <dd class="col-sm-9">
                {{ \Carbon\Carbon::parse($simpanan->tanggal_simpanan)->format('d-m-Y') }}
            </dd>
        </dl>

        <a href="{{ route('simpanans.index') }}" class="btn btn-secondary">
            Kembali
        </a>

        <a href="{{ route('simpanans.edit', $simpanan->id) }}"
           class="btn btn-warning">
            Edit Transaksi
        </a>
    </div>
</div>
@endsection
