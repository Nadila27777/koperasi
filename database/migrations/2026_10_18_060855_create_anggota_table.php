<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::latest()->get();

        return view('anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'tanggal_bergabung' => 'required|date',
        ]);

        Anggota::create($validated);

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Data anggota berhasil ditambahkan.');
    }

    public function show(Anggota $anggota)
    {
        return view('anggota.show', compact('anggota'));
    }

    public function edit(Anggota $anggota)
    {
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'tanggal_bergabung' => 'required|date',
        ]);

        $anggota->update($validated);

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Anggota $anggota)
    {
        $anggota->delete();

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Data anggota berhasil dihapus.');
    }
}
