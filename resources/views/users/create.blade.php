@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <h2>Tambah User</h2>
        <p class="text-muted">Tambahkan akun pengguna baru.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Data belum bisa disimpan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" id="name"
                           class="form-control"
                           value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email"
                           class="form-control"
                           value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password"
                           class="form-control" required>
                    <small class="text-muted">Minimal 8 karakter.</small>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">
                        Konfirmasi Password
                    </label>
                    <input type="password"
                           name="password_confirmation"
                           id="password_confirmation"
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="">Pilih Role</option>
                        @foreach ([
                            'admin' => 'Admin',
                            'pengurus' => 'Pengurus',
                            'bendahara' => 'Bendahara',
                            'anggota' => 'Anggota'
                        ] as $value => $label)
                            <option value="{{ $value }}"
                                {{ old('role') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status"
                            class="form-select" required>
                        <option value="aktif"
                            {{ old('status', 'aktif') === 'aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="nonaktif"
                            {{ old('status') === 'nonaktif' ? 'selected' : '' }}>
                            Nonaktif
                        </option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="is_active" class="form-label">
                        Status Akun
                    </label>
                    <select name="is_active" id="is_active"
                            class="form-select" required>
                        <option value="1"
                            {{ old('is_active', '1') == '1' ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="0"
                            {{ old('is_active') === '0' ? 'selected' : '' }}>
                            Nonaktif
                        </option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('users.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Simpan User
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
