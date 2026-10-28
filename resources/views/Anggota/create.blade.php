@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Tambah Anggota</h3>
        <a href="{{ route('anggotas.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">Form Tambah Anggota</div>
        <div class="card-body">
            <form action="{{ route('anggotas.store') }}" method="POST">
                @csrf
                @include('Anggota._form')
            </form>
        </div>
    </div>
</div>
@endsection
