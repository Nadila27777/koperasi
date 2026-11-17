
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4>Edit Angsuran</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('angsurans.update', $angsuran->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Pilih Pinjaman</label>
                    <select name="pinjaman_id" class="form-control" required>
                        @foreach($pinjamans as $pinjaman)
                            <option value="{{ $pinjaman->id }}"
                                {{ old('pinjaman_id', $angsuran->pinjaman_id) == $pinjaman->id ? 'selected' : '' }}>
                                {{ $pinjaman->anggota->nama ?? 'Anggota' }}
                                - Rp {{ number_format($pinjaman->jumlah_disetujui, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Pembayaran</label>
                    <input type="date" name="tanggal_bayar"
                        class="form-control"
                        value="{{ old('tanggal_bayar', $angsuran->tanggal_bayar) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Pembayaran (Rp)</label>
                    <input type="number" name="jumlah_bayar"
                        class="form-control" min="1" step="0.01"
                        value="{{ old('jumlah_bayar', $angsuran->jumlah_bayar) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('angsurans.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
