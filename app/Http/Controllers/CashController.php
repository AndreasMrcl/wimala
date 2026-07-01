<?php

namespace App\Http\Controllers;

use App\Models\CashEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CashController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan'); // 'YYYY-MM' atau null = semua periode

        $query = CashEntry::query();
        if ($bulan) {
            [$tahun, $month] = explode('-', $bulan);
            $query->whereYear('tanggal', $tahun)->whereMonth('tanggal', $month);
        }
        $entries = $query->orderByDesc('tanggal')->orderByDesc('id')->get();

        // Rekap periode
        $masuk  = (float) $entries->where('tipe', 'in')->sum('jumlah');
        $keluar = (float) $entries->where('tipe', 'out')->sum('jumlah');

        // Saldo kas s/d akhir periode (running balance)
        $saldoQuery = CashEntry::query();
        if ($bulan) {
            $saldoQuery->whereDate('tanggal', '<=', Carbon::createFromFormat('Y-m', $bulan)->endOfMonth());
        }
        $saldo = (float) (clone $saldoQuery)->where('tipe', 'in')->sum('jumlah')
               - (float) (clone $saldoQuery)->where('tipe', 'out')->sum('jumlah');

        $months = CashEntry::selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as bulan")
            ->distinct()
            ->orderByDesc('bulan')
            ->pluck('bulan');

        return view('kas', compact('entries', 'masuk', 'keluar', 'saldo', 'bulan', 'months'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal'    => 'required|date',
            'tipe'       => 'required|in:in,out',
            'kategori'   => 'required|string|max:255',
            'jumlah'     => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        CashEntry::create($data);

        return redirect()->route('kas.index')->with('success', 'Catatan kas berhasil ditambahkan!');
    }

    public function destroy(CashEntry $cash)
    {
        if ($cash->isAuto()) {
            return redirect()->route('kas.index')
                ->with('error', 'Entri otomatis dari pembayaran tidak bisa dihapus manual.');
        }

        $cash->delete();

        return redirect()->route('kas.index')->with('success', 'Catatan kas dihapus!');
    }
}
