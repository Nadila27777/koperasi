<div class="row">
    <div class="col-md-6 mb-3">
        <label for="nama_anggota" class="form-label">Nama Anggota</label>
        <input type="text" name="nama_anggota" id="nama_anggota"
            class="form-control"
            value="{{ old('nama_anggota', isset($simpanan) ? ($simpanan->nama_anggota ?? $simpanan->anggota?->nama ?? '') : '') }}"
            placeholder="Ketik nama anggota"
            maxlength="255" required>
        <small class="text-muted">
            Bisa mengisi nama anggota baru yang belum terdaftar.
        </small>
    </div>

    <div class="col-md-6 mb-3">
        <label for="jenis_simpanan" class="form-label">Jenis Simpanan</label>
        <select name="jenis_simpanan" id="jenis_simpanan"
            class="form-control" required>
            <option value="">-- Pilih Jenis Simpanan --</option>
            @foreach (['Pokok', 'Wajib', 'Sukarela'] as $jenis)
                <option value="{{ $jenis }}"
                    @selected(old('jenis_simpanan', $simpanan->jenis_simpanan ?? '') == $jenis)>
                    {{ $jenis }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="jumlah" class="form-label">Nominal Simpanan (Rp)</label>
        <input type="number" name="jumlah" id="jumlah"
            class="form-control" min="1" step="1"
            placeholder="Contoh: 100000"
            value="{{ old('jumlah', $simpanan->jumlah ?? '') }}"
            required>
    </div>

    <div class="col-md-6 mb-3">
        <label for="tanggal_simpanan" class="form-label">Tanggal Transaksi</label>
        <input type="date" name="tanggal_simpanan" id="tanggal_simpanan"
            class="form-control"
            value="{{ old('tanggal_simpanan', !empty($simpanan->tanggal_simpanan) ? \Carbon\Carbon::parse($simpanan->tanggal_simpanan)->format('Y-m-d') : date('Y-m-d')) }}"
            required>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
    <a href="{{ route('simpanans.index') }}" class="btn btn-secondary">
        Kembali
    </a>
    <button type="submit" class="btn btn-primary px-4">
        Simpan Transaksi
    </button>
</div>
