<?php

namespace App\Http\Controllers;

use App\Models\Simpanan;
use App\Models\Anggota;
use Illuminate\Http\Request;

class SimpananController extends Controller
{
    public function index()
    {
        $simpanan = Simpanan::with('anggota')->latest()->get();

        return view('simpanan.index', compact('simpanan'));
    }

    public function create()
    {
        $anggota = Anggota::orderBy('nama')->get();

        return view('simpanan.create', compact('anggota'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'jenis_simpanan' => 'required|in:Pokok,Wajib,Sukarela',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_simpanan' => 'required|date',
        ]);

        Simpanan::create($validated);

        return redirect()->route('simpanan.index')
            ->with('success', 'Data simpanan berhasil ditambahkan.');
    }
}
