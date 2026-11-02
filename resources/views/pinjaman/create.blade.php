@extends('layouts.app')

@section('title', 'Tambah Pinjaman')
@section('page-title', 'Tambah Pinjaman')

@section('content')

<div class="card card-primary">

    <div class="card-header">
        <h3 class="card-title">Form Pengajuan Pinjaman</h3>
    </div>

    <form action="{{ route('pinjaman.store') }}" method="POST">
        @csrf

        @include('pinjaman._form')

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>

            <a href="{{ route('pinjaman.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>
    </form>

</div>

@endsection
