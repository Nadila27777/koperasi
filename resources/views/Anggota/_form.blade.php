<div class="row">
    <div class="col-md-6 mb-3">
        <label for="nik" class="form-label">NIK</label>
        <input type="text" name="nik" id="nik"
            class="form-control @error('nik') is-invalid @enderror"
            value="{{ old('nik', $anggota->nik ?? '') }}"
            maxlength="16">
        @error('nik')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="nama" class="form-label">Nama Anggota</label>
        <input type="text" name="nama" id="nama"
            class="form-control @error('nama') is-invalid @enderror"
            value="{{ old('nama', $anggota->nama ?? '') }}" required>
        @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
            <option value="">-- Pilih Jenis Kelamin --</option>
            <option value="Laki-laki" @selected(old('jenis_kelamin', $anggota->jenis_kelamin ?? '') == 'Laki-laki')>Laki-laki</option>
            <option value="Perempuan" @selected(old('jenis_kelamin', $anggota->jenis_kelamin ?? '') == 'Perempuan')>Perempuan</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="no_telepon" class="form-label">No. HP</label>
        <input type="text" name="no_telepon" id="no_telepon"
            class="form-control"
            value="{{ old('no_telepon', $anggota->no_telepon ?? '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung</label>
        <input type="date" name="tanggal_bergabung" id="tanggal_bergabung"
            class="form-control"
            value="{{ old('tanggal_bergabung', isset($anggota) ? $anggota->tanggal_bergabung : '') }}"
            required>
    </div>

    <div class="col-md-6 mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select">
            <option value="Aktif" @selected(old('status', $anggota->status ?? 'Aktif') == 'Aktif')>Aktif</option>
            <option value="Nonaktif" @selected(old('status', $anggota->status ?? '') == 'Nonaktif')>Nonaktif</option>
        </select>
    </div>

    <div class="col-12 mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea name="alamat" id="alamat" class="form-control"
            rows="2" required>{{ old('alamat', $anggota->alamat ?? '') }}</textarea>
    </div>
</div>

<div class="d-flex justify-content-between">
    <a href="{{ route('anggotas.index') }}" class="btn btn-secondary">
        Kembali
    </a>
    <button type="submit" class="btn btn-primary">
        Simpan Data
    </button>
</div>
