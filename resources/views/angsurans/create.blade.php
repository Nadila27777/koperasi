
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4>Tambah Angsuran</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('angsurans.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Pilih Pinjaman</label>
                    <select name="pinjaman_id" class="form-control" required>
                        <option value="">-- Pilih Pinjaman --</option>

                        @foreach($pinjamans as $pinjaman)
                            <option value="{{ $pinjaman->id }}"
                                {{ old('pinjaman_id') == $pinjaman->id ? 'selected' : '' }}>
                                {{ $pinjaman->anggota->nama ?? 'Anggota' }}
                                - Rp {{ number_format($pinjaman->jumlah_disetujui, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('pinjaman_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Pembayaran</label>
                    <input type="date" name="tanggal_bayar"
                        class="form-control" value="{{ old('tanggal_bayar', date('Y-m-d')) }}" required>
                    @error('tanggal_bayar')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Pembayaran (Rp)</label>
                    <input type="number" name="jumlah_bayar"
                        class="form-control" min="1" step="0.01"
                        value="{{ old('jumlah_bayar') }}" required>
                    @error('jumlah_bayar')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan Angsuran
                </button>

                <a href="{{ route('angsurans.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
