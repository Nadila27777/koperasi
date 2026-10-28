<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AnggotaController extends Controller
{
    /**
     * Menampilkan daftar anggota dan fitur pencarian.
     */
    public function index(Request $request)
    {
        $anggota = Anggota::when($request->search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_anggota', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('no_telepon', 'like', "%{$search}%");
            });
        })->latest()->get();

        return view('Anggota.index', compact('anggota'));
    }

    /**
     * Menampilkan form tambah anggota.
     */
    public function create()
    {
        return view('Anggota.create');
    }

    /**
     * Menyimpan anggota baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|digits:16|unique:anggota,nik',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'jenis_kelamin' => [
                'required',
                Rule::in(['Laki-laki', 'Perempuan']),
            ],
            'no_telepon' => 'required|string|max:15',
            'tanggal_bergabung' => 'required|date',
            'status' => [
                'required',
                Rule::in(['Aktif', 'Nonaktif']),
            ],
        ]);

        // Cari nomor anggota yang belum digunakan.
        $nomorUrut = (Anggota::max('id') ?? 0) + 1;

        do {
            $nomor = 'AGT' . str_pad(
                (string) $nomorUrut,
                4,
                '0',
                STR_PAD_LEFT
            );

            $nomorUrut++;
        } while (Anggota::where('no_anggota', $nomor)->exists());

        $validated['no_anggota'] = $nomor;

        Anggota::create($validated);

        return redirect()->route('anggotas.index')
            ->with('success', 'Data anggota berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail anggota.
     */
    public function show(string $id)
    {
        $anggota = Anggota::findOrFail($id);

        return view('Anggota.show', compact('anggota'));
    }

    /**
     * Menampilkan form edit anggota.
     */
    public function edit(string $id)
    {
        $anggota = Anggota::findOrFail($id);

        return view('Anggota.edit', compact('anggota'));
    }

    /**
     * Memperbarui data anggota.
     */
    public function update(Request $request, string $id)
    {
        $anggota = Anggota::findOrFail($id);

        $validated = $request->validate([
            'nik' => [
                'required',
                'string',
                'digits:16',
                Rule::unique('anggota', 'nik')->ignore($anggota->id),
            ],
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'jenis_kelamin' => [
                'required',
                Rule::in(['Laki-laki', 'Perempuan']),
            ],
            'no_telepon' => 'required|string|max:15',
            'tanggal_bergabung' => 'required|date',
            'status' => [
                'required',
                Rule::in(['Aktif', 'Nonaktif']),
            ],
        ]);

        // Nomor anggota tidak diubah saat edit.
        $anggota->update($validated);

        return redirect()->route('anggotas.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Menghapus anggota.
     */
    public function destroy(string $id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('anggotas.index')
            ->with('success', 'Data anggota berhasil dihapus.');
    }
}
