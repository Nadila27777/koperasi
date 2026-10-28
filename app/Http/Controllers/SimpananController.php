<?php

namespace App\Http\Controllers;

use App\Models\Simpanan;
use App\Models\Anggota;
use Illuminate\Http\Request;

class SimpananController extends Controller
{
    public function index()
    {
        $simpanan = Simpanan::with('anggota')
            ->latest()
            ->get();

        return view('Simpanan.index', compact('simpanan'));
    }

    public function create()
    {
        return view('Simpanan.create', [
            'simpanan' => new Simpanan(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_anggota' => 'required|string|max:255',
            'jenis_simpanan' => 'required|in:Pokok,Wajib,Sukarela',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_simpanan' => 'required|date',
        ]);

        // Jika nama sudah terdaftar, hubungkan ke data anggota.
        $anggota = Anggota::where('nama', $validated['nama_anggota'])
            ->first();

        $validated['anggota_id'] = $anggota?->id;

        Simpanan::create($validated);

        return redirect()
            ->route('simpanans.index')
            ->with('success', 'Data simpanan berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $simpanan = Simpanan::with('anggota')->findOrFail($id);

        return view('Simpanan.show', compact('simpanan'));
    }

    public function edit(string $id)
    {
        $simpanan = Simpanan::with('anggota')->findOrFail($id);

        return view('Simpanan.edit', compact('simpanan'));
    }

    public function update(Request $request, string $id)
    {
        $simpanan = Simpanan::with('anggota')->findOrFail($id);

        $validated = $request->validate([
            'nama_anggota' => 'required|string|max:255',
            'jenis_simpanan' => 'required|in:Pokok,Wajib,Sukarela',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_simpanan' => 'required|date',
        ]);

        $anggota = Anggota::where('nama', $validated['nama_anggota'])
            ->first();

        $validated['anggota_id'] = $anggota?->id;

        $simpanan->update($validated);

        return redirect()
            ->route('simpanans.index')
            ->with('success', 'Data simpanan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $simpanan = Simpanan::findOrFail($id);
        $simpanan->delete();

        return redirect()
            ->route('simpanans.index')
            ->with('success', 'Data simpanan berhasil dihapus.');
    }
}
