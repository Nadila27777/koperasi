@extends('layouts.app')

@section('title', 'Detail Pinjaman')
@section('page-title', 'Detail Pinjaman')

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
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

<div class="card card-info">

    <div class="card-header">
        <h3 class="card-title">Informasi Pengajuan Pinjaman</h3>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="30%">Nama Anggota</th>
                <td>{{ $pinjaman->anggota->nama ?? '-' }}</td>
            </tr>

            <tr>
                <th>Jumlah Pengajuan</th>
                <td>
                    Rp {{ number_format($pinjaman->jumlah_pengajuan, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <th>Jumlah Disetujui</th>
                <td>
                    @if($pinjaman->jumlah_disetujui !== null)
                        Rp {{ number_format($pinjaman->jumlah_disetujui, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>

            <tr>
                <th>Bunga</th>
                <td>{{ $pinjaman->bunga_persen }}%</td>
            </tr>

            <tr>
                <th>Tenor</th>
                <td>{{ $pinjaman->tenor_bulan }} bulan</td>
            </tr>

            <tr>
                <th>Tujuan</th>
                <td>{{ $pinjaman->tujuan }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    <span class="badge badge-info">
                        {{ ucfirst($pinjaman->status) }}
                    </span>
                </td>
            </tr>

            <tr>
                <th>Disetujui Oleh</th>
                <td>{{ $pinjaman->pengurus->name ?? '-' }}</td>
            </tr>

            <tr>
                <th>Tanggal Persetujuan</th>
                <td>
                    {{ $pinjaman->approved_at?->format('d-m-Y H:i') ?? '-' }}
                </td>
            </tr>

        </table>

    </div>

    <div class="card-footer">

        @if($pinjaman->status == 'diajukan')

            <form action="{{ route('pinjaman.approve', $pinjaman->id) }}"
                  method="POST"
                  class="mb-3">

                @csrf

                <div class="form-group">
                    <label>Jumlah yang Disetujui (Rp)</label>

                    <input
                        type="number"
                        name="jumlah_disetujui"
                        class="form-control"
                        value="{{ old('jumlah_disetujui', $pinjaman->jumlah_pengajuan) }}"
                        min="1"
                        max="{{ $pinjaman->jumlah_pengajuan }}"
                        step="0.01"
                        required
                    >

                    <small class="text-muted">
                        Maksimal sebesar jumlah pengajuan:
                        Rp {{ number_format($pinjaman->jumlah_pengajuan, 0, ',', '.') }}
                    </small>
                </div>

                <button type="submit"
                        class="btn btn-success"
                        onclick="return confirm('Setujui pinjaman dengan nominal tersebut?')">
                    <i class="fas fa-check"></i> Setujui Pinjaman
                </button>

            </form>

            <form action="{{ route('pinjaman.reject', $pinjaman->id) }}"
                  method="POST"
                  class="d-inline">

                @csrf

                <button type="submit"
                        class="btn btn-danger"
                        onclick="return confirm('Tolak pengajuan pinjaman ini?')">
                    <i class="fas fa-times"></i> Tolak
                </button>

            </form>

        @endif

        @if($pinjaman->status == 'disetujui')

            <form action="{{ route('pinjaman.disburse', $pinjaman->id) }}"
                  method="POST"
                  class="d-inline">

                @csrf

                <button type="submit"
                        class="btn btn-primary"
                        onclick="return confirm('Cairkan pinjaman ini?')">
                    <i class="fas fa-money-bill"></i> Cairkan Pinjaman
                </button>

            </form>

        @endif

        @if($pinjaman->status == 'dicairkan')

            <form action="{{ route('pinjaman.paid', $pinjaman->id) }}"
                  method="POST"
                  class="d-inline">

                @csrf

                <button type="submit"
                        class="btn btn-success"
                        onclick="return confirm('Tandai pinjaman ini sebagai lunas?')">
                    <i class="fas fa-check-circle"></i> Tandai Lunas
                </button>

            </form>

        @endif

        <a href="{{ route('pinjaman.index') }}" class="btn btn-secondary">
            Kembali
        </a>

    </div>

</div>

@endsection
