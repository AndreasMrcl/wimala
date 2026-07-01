<?php

namespace App\Http\Controllers;

use App\Models\HouseType;
use Illuminate\Http\Request;

class TipeController extends Controller
{
    public function index()
    {
        $tipe = HouseType::orderBy('nama')->get();

        return view('tipe', compact('tipe'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        HouseType::create($data);

        return redirect()->route('tipe.index')->with('success', 'Tipe rumah berhasil ditambahkan!');
    }

    public function update(Request $request, HouseType $tipe)
    {
        $data = $this->validateData($request);

        $tipe->update($data);

        return redirect()->route('tipe.index')->with('success', 'Tipe rumah berhasil diperbarui!');
    }

    public function destroy(HouseType $tipe)
    {
        if ($tipe->units()->exists()) {
            return redirect()->route('tipe.index')
                ->with('error', 'Tipe tidak bisa dihapus karena masih dipakai oleh unit.');
        }

        $tipe->delete();

        return redirect()->route('tipe.index')->with('success', 'Tipe rumah berhasil dihapus!');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nama'          => 'required|string|max:255',
            'luas_tanah'    => 'required|integer|min:0',
            'luas_bangunan' => 'required|integer|min:0',
            'kamar_tidur'   => 'required|integer|min:0',
            'kamar_mandi'   => 'required|integer|min:0',
            'harga_dasar'   => 'required|numeric|min:0',
        ]);
    }
}
