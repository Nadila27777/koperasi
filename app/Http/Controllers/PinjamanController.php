<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PinjamanController extends Controller
{
    /**
     * Menampilkan daftar pinjaman.
     */
    public function index(Request $request)
    {
        $query = Pinjaman::with(['anggota', 'pengurus']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('anggota', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pinjaman = $query->latest()->paginate(10)->withQueryString();

        $total = Pinjaman::count();
        $diajukan = Pinjaman::where('status', 'diajukan')->count();
        $disetujui = Pinjaman::where('status', 'disetujui')->count();
        $dicairkan = Pinjaman::where('status', 'dicairkan')->count();

        return view('pinjaman.index', compact(
            'pinjaman',
            'total',
            'diajukan',
            'disetujui',
            'dicairkan'
        ));
    }

    /**
     * Menampilkan form pengajuan pinjaman.
     */
    public function create()
    {
        $anggota = Anggota::orderBy('nama')->get();

        return view('pinjaman.create', compact('anggota'));
    }

    /**
     * Menyimpan pengajuan pinjaman.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'jumlah_pengajuan' => 'required|numeric|min:1',
            'bunga_persen' => 'required|numeric|min:0|max:100',
            'tenor_bulan' => 'required|integer|min:1|max:120',
            'tujuan' => 'required|string|max:2000',
        ]);

        $validated['status'] = 'diajukan';

        $pinjaman = new Pinjaman($validated);
        $pinjaman->tanggal_pinjaman = now()->toDateString();
        $pinjaman->save();

        return redirect()
            ->route('pinjaman.index')
            ->with('success', 'Pengajuan pinjaman berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail pinjaman.
     */
    public function show(Pinjaman $pinjaman)
    {
        $pinjaman->load(['anggota', 'pengurus']);

        return view('pinjaman.show', compact('pinjaman'));
    }

    /**
     * Menampilkan form edit pinjaman.
     */
    public function edit(Pinjaman $pinjaman)
    {
        if ($pinjaman->status !== 'diajukan') {
            return redirect()
                ->route('pinjaman.index')
                ->with('error', 'Pinjaman hanya bisa diedit jika masih diajukan.');
        }

        $anggota = Anggota::orderBy('nama')->get();

        return view('pinjaman.edit', compact('pinjaman', 'anggota'));
    }

    /**
     * Memperbarui pengajuan pinjaman.
     */
    public function update(Request $request, Pinjaman $pinjaman)
    {
        if ($pinjaman->status !== 'diajukan') {
            return redirect()
                ->route('pinjaman.index')
                ->with('error', 'Pinjaman tidak bisa diubah karena sudah diproses.');
        }

        $validated = $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'jumlah_pengajuan' => 'required|numeric|min:1',
            'bunga_persen' => 'required|numeric|min:0|max:100',
            'tenor_bulan' => 'required|integer|min:1|max:120',
            'tujuan' => 'required|string|max:2000',
        ]);

        $pinjaman->update($validated);

        return redirect()
            ->route('pinjaman.index')
            ->with('success', 'Pengajuan pinjaman berhasil diperbarui.');
    }

    /**
     * Menghapus pengajuan pinjaman.
     */
    public function destroy(Pinjaman $pinjaman)
    {
        if ($pinjaman->status !== 'diajukan') {
            return redirect()
                ->route('pinjaman.index')
                ->with('error', 'Pinjaman yang sudah diproses tidak dapat dihapus.');
        }

        $pinjaman->delete();

        return redirect()
            ->route('pinjaman.index')
            ->with('success', 'Pengajuan pinjaman berhasil dihapus.');
    }

    /**
     * Menyetujui pengajuan pinjaman.
     */
    public function approve(Request $request, Pinjaman $pinjaman)
    {
        if ($pinjaman->status !== 'diajukan') {
            return back()->with('error', 'Pengajuan pinjaman ini sudah diproses.');
        }

        $validated = $request->validate([
            'jumlah_disetujui' => 'nullable|numeric|min:1|max:' . $pinjaman->jumlah_pengajuan,
        ]);

        DB::transaction(function () use ($pinjaman, $validated) {
            $pinjaman = Pinjaman::whereKey($pinjaman->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($pinjaman->status !== 'diajukan') {
                return;
            }

            $pinjaman->jumlah_disetujui =
                $validated['jumlah_disetujui'] ?? $pinjaman->jumlah_pengajuan;

            $pinjaman->status = 'disetujui';
            $pinjaman->approved_by = Auth::id();
            $pinjaman->approved_at = now();
            $pinjaman->save();
        });

        return back()->with('success', 'Pengajuan pinjaman berhasil disetujui.');
    }

    /**
     * Menolak pengajuan pinjaman.
     */
    public function reject(Request $request, Pinjaman $pinjaman)
    {
        if ($pinjaman->status !== 'diajukan') {
            return back()->with('error', 'Pengajuan pinjaman ini sudah diproses.');
        }

        $pinjaman->status = 'ditolak';
        $pinjaman->approved_by = Auth::id();
        $pinjaman->approved_at = now();
        $pinjaman->catatan_persetujuan = $request->input(
            'catatan_persetujuan',
            'Pengajuan pinjaman ditolak.'
        );
        $pinjaman->save();

        return back()->with('success', 'Pengajuan pinjaman berhasil ditolak.');
    }

    /**
     * Mencairkan pinjaman yang sudah disetujui.
     */
    public function disburse(Pinjaman $pinjaman)
    {
        if ($pinjaman->status !== 'disetujui') {
            return back()->with('error', 'Hanya pinjaman yang disetujui yang dapat dicairkan.');
        }

        $pinjaman->status = 'dicairkan';
        $pinjaman->disbursed_at = now();
        $pinjaman->save();

        return back()->with('success', 'Pinjaman berhasil dicairkan.');
    }

    /**
     * Menandai pinjaman sebagai lunas.
     */
    public function markPaid(Pinjaman $pinjaman)
    {
        if ($pinjaman->status !== 'dicairkan') {
            return back()->with('error', 'Hanya pinjaman yang sudah dicairkan yang dapat ditandai lunas.');
        }

        $pinjaman->status = 'lunas';
        $pinjaman->lunas_at = now();
        $pinjaman->save();

        return back()->with('success', 'Pinjaman berhasil ditandai lunas.');
    }

    /**
     * Membatalkan pengajuan pinjaman.
     */
    public function cancel(Pinjaman $pinjaman)
    {
        if (!in_array($pinjaman->status, ['diajukan', 'disetujui'])) {
            return back()->with('error', 'Pinjaman ini tidak dapat dibatalkan.');
        }

        $pinjaman->status = 'dibatalkan';
        $pinjaman->save();

        return back()->with('success', 'Pengajuan pinjaman berhasil dibatalkan.');
    }
}
