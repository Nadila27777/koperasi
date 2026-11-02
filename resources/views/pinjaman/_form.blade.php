<div class="card-body">

    <div class="form-group">
        <label>Nama Anggota</label>

        <select name="anggota_id"
                class="form-control @error('anggota_id') is-invalid @enderror"
                required>
            <option value="">-- Pilih Anggota --</option>

            @foreach($anggota as $item)
                <option value="{{ $item->id }}"
                    {{ old('anggota_id', $pinjaman->anggota_id ?? '') == $item->id ? 'selected' : '' }}>
                    {{ $item->nama }}
                </option>
            @endforeach
        </select>

        @error('anggota_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Jumlah Pengajuan (Rp)</label>

        <input type="number"
               name="jumlah_pengajuan"
               class="form-control @error('jumlah_pengajuan') is-invalid @enderror"
               value="{{ old('jumlah_pengajuan', $pinjaman->jumlah_pengajuan ?? '') }}"
               min="1"
               step="0.01"
               required>

        @error('jumlah_pengajuan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Bunga per Tahun (%)</label>

        <input type="number"
               name="bunga_persen"
               class="form-control @error('bunga_persen') is-invalid @enderror"
               value="{{ old('bunga_persen', $pinjaman->bunga_persen ?? 0) }}"
               min="0"
               max="100"
               step="0.01"
               required>

        @error('bunga_persen')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Tenor (Bulan)</label>

        <input type="number"
               name="tenor_bulan"
               class="form-control @error('tenor_bulan') is-invalid @enderror"
               value="{{ old('tenor_bulan', $pinjaman->tenor_bulan ?? '') }}"
               min="1"
               max="120"
               required>

        @error('tenor_bulan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Tujuan Pinjaman</label>

        <textarea name="tujuan"
                  class="form-control @error('tujuan') is-invalid @enderror"
                  rows="4"
                  required>{{ old('tujuan', $pinjaman->tujuan ?? '') }}</textarea>

        @error('tujuan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>
