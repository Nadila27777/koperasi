<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AngsuranController extends Controller
{
    /**
     * Menghitung total kewajiban pinjaman.
     * Rumus sementara: pokok + bunga satu kali.
     */
    private function totalKewajiban(Pinjaman $pinjaman): float
    {
        $pokok = (float) (
            $pinjaman->jumlah_disetujui
            ?? $pinjaman->jumlah_pengajuan
        );

        $bunga = (float) ($pinjaman->bunga_persen ?? 0);

        return round($pokok + ($pokok * $bunga / 100), 2);
    }

    /**
     * Memperbarui status berdasarkan total pembayaran.
     */
    private function perbaruiStatus(Pinjaman $pinjaman): void
    {
        // Jangan mengubah status pengajuan, penolakan, atau pembatalan.
        if (!in_array($pinjaman->status, ['dicairkan', 'lunas'])) {
            return;
        }

        $totalBayar = (float) Angsuran::where(
            'pinjaman_id',
            $pinjaman->id
        )->sum('jumlah_bayar');

        $totalKewajiban = $this->totalKewajiban($pinjaman);

        if ($totalBayar >= $totalKewajiban) {
            $pinjaman->status = 'lunas';
            $pinjaman->lunas_at = $pinjaman->lunas_at ?? now();
        } else {
            $pinjaman->status = 'dicairkan';
            $pinjaman->lunas_at = null;
        }

        $pinjaman->save();
    }

    public function index()
    {
        $angsurans = Angsuran::with('pinjaman.anggota')
            ->latest()
            ->get();

        $pinjamans = Pinjaman::with('angsurans')
            ->get()
            ->keyBy('id');

        $ringkasanPinjaman = [];

        foreach ($pinjamans as $pinjaman) {
            $totalBayar = (float) $pinjaman->angsurans->sum('jumlah_bayar');
            $totalKewajiban = $this->totalKewajiban($pinjaman);

            $ringkasanPinjaman[$pinjaman->id] = [
                'total_kewajiban' => $totalKewajiban,
                'total_bayar' => $totalBayar,
                'sisa' => max(0, round($totalKewajiban - $totalBayar, 2)),
                'status_pembayaran' => $totalBayar >= $totalKewajiban
                    ? 'Lunas'
                    : 'Belum Lunas',
            ];
        }

        return view('angsurans.index', compact(
            'angsurans',
            'ringkasanPinjaman'
        ));
    }

    public function create()
    {
        $pinjamans = Pinjaman::with('anggota')
            ->whereIn('status', ['dicairkan', 'lunas'])
            ->get();

        return view('angsurans.create', compact('pinjamans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pinjaman_id' => 'required|exists:pinjamans,id',
            'tanggal_bayar' => 'required|date',
            'jumlah_bayar' => 'required|numeric|min:1',
        ]);

        DB::transaction(function () use ($validated) {
            $pinjaman = Pinjaman::whereKey($validated['pinjaman_id'])
                ->lockForUpdate()
                ->firstOrFail();

            // Perbaiki status lunas yang ternyata belum lunas.
            $this->perbaruiStatus($pinjaman);
            $pinjaman->refresh();

            if (!in_array($pinjaman->status, ['dicairkan', 'lunas'])) {
                throw ValidationException::withMessages([
                    'pinjaman_id' => 'Pinjaman belum dicairkan atau tidak dapat menerima angsuran.',
                ]);
            }

            $totalBayar = (float) Angsuran::where(
                'pinjaman_id',
                $pinjaman->id
            )->sum('jumlah_bayar');

            $sisa = round(
                $this->totalKewajiban($pinjaman) - $totalBayar,
                2
            );

            if ((float) $validated['jumlah_bayar'] > $sisa) {
                throw ValidationException::withMessages([
                    'jumlah_bayar' => 'Pembayaran melebihi sisa kewajiban. Sisa pembayaran: Rp '
                        . number_format(max(0, $sisa), 0, ',', '.'),
                ]);
            }

            Angsuran::create($validated);

            $this->perbaruiStatus($pinjaman);
        });

        return redirect()
            ->route('angsurans.index')
            ->with('success', 'Angsuran berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $angsuran = Angsuran::with('pinjaman.anggota')
            ->findOrFail($id);

        return view('angsurans.show', compact('angsuran'));
    }

    public function edit(string $id)
    {
        $angsuran = Angsuran::findOrFail($id);

        $pinjamans = Pinjaman::with('anggota')
            ->whereIn('status', ['dicairkan', 'lunas'])
            ->get();

        return view('angsurans.edit', compact(
            'angsuran',
            'pinjamans'
        ));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'pinjaman_id' => 'required|exists:pinjamans,id',
            'tanggal_bayar' => 'required|date',
            'jumlah_bayar' => 'required|numeric|min:1',
        ]);

        DB::transaction(function () use ($validated, $id) {
            $angsuran = Angsuran::whereKey($id)
                ->lockForUpdate()
                ->firstOrFail();

            $pinjamanLamaId = $angsuran->pinjaman_id;

            $pinjamanBaru = Pinjaman::whereKey($validated['pinjaman_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $this->perbaruiStatus($pinjamanBaru);
            $pinjamanBaru->refresh();

            if (!in_array($pinjamanBaru->status, ['dicairkan', 'lunas'])) {
                throw ValidationException::withMessages([
                    'pinjaman_id' => 'Pinjaman belum dicairkan atau tidak dapat menerima angsuran.',
                ]);
            }

            $totalBayarLain = (float) Angsuran::where(
                'pinjaman_id',
                $pinjamanBaru->id
            )
                ->where('id', '!=', $angsuran->id)
                ->sum('jumlah_bayar');

            $sisa = round(
                $this->totalKewajiban($pinjamanBaru) - $totalBayarLain,
                2
            );

            if ((float) $validated['jumlah_bayar'] > $sisa) {
                throw ValidationException::withMessages([
                    'jumlah_bayar' => 'Pembayaran melebihi sisa kewajiban. Sisa pembayaran: Rp '
                        . number_format(max(0, $sisa), 0, ',', '.'),
                ]);
            }

            $angsuran->update($validated);

            $this->perbaruiStatus($pinjamanBaru);

            if ($pinjamanLamaId != $pinjamanBaru->id) {
                $pinjamanLama = Pinjaman::whereKey($pinjamanLamaId)
                    ->lockForUpdate()
                    ->first();

                if ($pinjamanLama) {
                    $this->perbaruiStatus($pinjamanLama);
                }
            }
        });

        return redirect()
            ->route('angsurans.index')
            ->with('success', 'Angsuran berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {
            $angsuran = Angsuran::whereKey($id)
                ->lockForUpdate()
                ->firstOrFail();

            $pinjaman = Pinjaman::whereKey($angsuran->pinjaman_id)
                ->lockForUpdate()
                ->first();

            $angsuran->delete();

            if ($pinjaman) {
                $this->perbaruiStatus($pinjaman);
            }
        });

        return redirect()
            ->route('angsurans.index')
            ->with('success', 'Angsuran berhasil dihapus.');
    }
}
