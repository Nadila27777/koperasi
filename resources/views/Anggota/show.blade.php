@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Detail Anggota</h3>
        <a href="{{ route('anggotas.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            Informasi Anggota
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>No. Anggota</strong>
                    <p>{{ $anggota->no_anggota ?? '-' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>NIK</strong>
                    <p>{{ $anggota->nik ?? '-' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Nama</strong>
                    <p>{{ $anggota->nama }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Jenis Kelamin</strong>
                    <p>{{ $anggota->jenis_kelamin ?? '-' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>No. HP</strong>
                    <p>{{ $anggota->no_telepon }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Tanggal Bergabung</strong>
                    <p>{{ $anggota->tanggal_bergabung }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Status</strong>
                    <p>{{ $anggota->status ?? 'Aktif' }}</p>
                </div>

                <div class="col-12 mb-3">
                    <strong>Alamat</strong>
                    <p>{{ $anggota->alamat }}</p>
                </div>
            </div>

            <a href="{{ route('anggotas.edit', $anggota->id) }}"
                class="btn btn-warning">Edit Anggota</a>
        </div>
    </div>
</div>
@endsection
