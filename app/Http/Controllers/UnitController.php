<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use App\Models\HouseType;
use App\Models\Unit;
use App\Support\DemoData;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UnitController extends Controller
{
    public function index()
    {
        $units      = Unit::with(['cluster', 'houseType'])->orderBy('kode')->get();
        $clusters   = Cluster::orderBy('nama')->get();
        $houseTypes = HouseType::orderBy('nama')->get();

        return view('unit', compact('units', 'clusters', 'houseTypes'));
    }

    public function show(Unit $unit)
    {
        $unit->load(['cluster', 'houseType']);

        // Riwayat status unit (lapisan inventory)
        $order = [
            'available'   => 'Tersedia',
            'booked'      => 'Dibooking',
            'sold'        => 'Terjual',
            'handed_over' => 'Serah terima',
            'completed'   => 'Selesai',
        ];
        $keys     = array_keys($order);
        $current  = array_search($unit->status, $keys, true);
        $timeline = [];
        foreach ($keys as $i => $key) {
            $state = $i < $current ? 'done' : ($i === $current ? 'active' : 'pending');
            $timeline[] = ['label' => $order[$key], 'state' => $state];
        }

        // Transaksi aktif unit ini (real). Dokumen masih placeholder (modul dokumen = F2).
        $trx       = $unit->activeSaleTransaction()->with(['buyer', 'currentStage'])->first();
        $bayar     = $trx ? ($trx->payment_method === 'kpr' ? 'KPR' : 'Cash') : '-';
        $statusMap = ['available' => 'available', 'booked' => 'booked', 'sold' => 'sold', 'handed_over' => 'handed', 'completed' => 'done'];
        $docs      = DemoData::unitDocs($statusMap[$unit->status] ?? 'available', $bayar);

        return view('unitShow', [
            'unit'     => $unit,
            'timeline' => $timeline,
            'trx'      => $trx,
            'docs'     => $docs,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data = $this->withInheritedDimensions($data);

        Unit::create($data);

        return redirect()->route('units.index')->with('success', 'Unit berhasil ditambahkan!');
    }

    public function update(Request $request, Unit $unit)
    {
        $data = $this->validateData($request, $unit);
        $data = $this->withInheritedDimensions($data);

        $unit->update($data);

        return redirect()->route('units.index')->with('success', 'Unit berhasil diperbarui!');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect()->route('units.index')->with('success', 'Unit berhasil dihapus!');
    }

    private function validateData(Request $request, ?Unit $unit = null): array
    {
        return $request->validate([
            'kode'          => ['required', 'string', 'max:50', Rule::unique('units', 'kode')->ignore($unit?->id)],
            'cluster_id'    => ['required', 'exists:clusters,id'],
            'house_type_id' => ['required', 'exists:house_types,id'],
            'blok'          => ['nullable', 'string', 'max:50'],
            'nomor'         => ['nullable', 'string', 'max:50'],
            'harga'         => ['required', 'numeric', 'min:0'],
            'delivery_type' => ['required', 'in:ready_stock,indent'],
            'status'        => ['required', 'in:available,booked,sold,handed_over,completed'],
        ]);
    }

    /**
     * Luas tanah/bangunan unit mengikuti tipe rumah yang dipilih.
     */
    private function withInheritedDimensions(array $data): array
    {
        $houseType = HouseType::find($data['house_type_id']);
        $data['luas_tanah']    = $houseType->luas_tanah;
        $data['luas_bangunan'] = $houseType->luas_bangunan;

        return $data;
    }
}
