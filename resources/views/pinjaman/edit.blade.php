@extends('layouts.app')

@section('title', 'Edit Pinjaman')
@section('page-title', 'Edit Pinjaman')

@section('content')

<div class="card card-warning">

    <div class="card-header">
        <h3 class="card-title">Form Edit Pinjaman</h3>
    </div>

    <form action="{{ route('pinjaman.update', $pinjaman->id) }}" method="POST">
        @csrf
        @method('PUT')

        @include('pinjaman._form')

        <div class="card-footer">
            <button type="submit" class="btn btn-warning">
                <i class="fas fa-save"></i> Update
            </button>

            <a href="{{ route('pinjaman.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>
    </form>

</div>

@endsection
