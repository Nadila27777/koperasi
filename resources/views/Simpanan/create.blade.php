@extends('layouts.app')

@section('title', 'Catat Simpanan')
@section('page-title', 'Catat Simpanan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Simpanan Baru</h3>
    </div>

    <form action="{{ route('simpanans.store') }}" method="POST">
        @csrf

        <div class="card-body">
            @include('Simpanan._form')
        </div>
    </form>
</div>
@endsection
