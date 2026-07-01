<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function index()
    {
        $buyers = Buyer::orderBy('nama')->get();

        return view('buyer', compact('buyers'));
    }

    public function store(Request $request)
    {
        Buyer::create($this->validateData($request));

        return redirect()->route('buyers.index')->with('success', 'Pembeli berhasil ditambahkan!');
    }

    public function update(Request $request, Buyer $buyer)
    {
        $buyer->update($this->validateData($request));

        return redirect()->route('buyers.index')->with('success', 'Pembeli berhasil diperbarui!');
    }

    public function destroy(Buyer $buyer)
    {
        if ($buyer->saleTransactions()->exists()) {
            return redirect()->route('buyers.index')
                ->with('error', 'Pembeli tidak bisa dihapus karena masih memiliki transaksi.');
        }

        $buyer->delete();

        return redirect()->route('buyers.index')->with('success', 'Pembeli berhasil dihapus!');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nama'    => 'required|string|max:255',
            'ktp'     => 'nullable|string|max:32',
            'npwp'    => 'nullable|string|max:32',
            'telepon' => 'nullable|string|max:32',
            'email'   => 'nullable|email|max:255',
            'alamat'  => 'nullable|string|max:1000',
        ]);
    }
}
