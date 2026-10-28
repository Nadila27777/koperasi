@extends('layouts.app')

@section('title', 'Edit Simpanan')
@section('page-title', 'Edit Simpanan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Transaksi</h3>
    </div>

    <form action="{{ route('simpanans.update', $simpanan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-body">
            @include('Simpanan._form')
        </div>
    </form>
</div>
@endsection
