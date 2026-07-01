<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\SaleTransaction;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['saleTransaction.unit', 'saleTransaction.buyer', 'payments'])
            ->latest()
            ->get();

        // Ringkasan keuangan (PRD §5.6)
        $totalTertagih   = (float) $invoices->sum('jumlah');
        $totalTerbayar   = $invoices->sum(fn ($i) => $i->paidAmount());
        $belumJatuhTempo = $invoices->reject(fn ($i) => $i->isPaid() || $i->isLate())->sum(fn ($i) => $i->outstanding());
        $terlambat       = $invoices->filter(fn ($i) => $i->isLate())->sum(fn ($i) => $i->outstanding());

        $transactions = SaleTransaction::with(['unit', 'buyer'])->where('status', 'active')->get();

        return view('invoice', compact(
            'invoices', 'totalTertagih', 'totalTerbayar', 'belumJatuhTempo', 'terlambat', 'transactions'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sale_transaction_id' => 'required|exists:sale_transactions,id',
            'jenis_termin'        => 'required|in:booking_fee,dp,cicilan,pelunasan,pencairan_bank',
            'jumlah'              => 'required|numeric|min:0',
            'jatuh_tempo'         => 'required|date',
        ]);

        $data['no_invoice'] = $this->generateNumber();
        $data['status']     = 'unpaid';

        Invoice::create($data);

        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dibuat!');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['saleTransaction.unit', 'saleTransaction.buyer', 'payments.confirmedBy']);

        return view('invoiceShow', compact('invoice'));
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dihapus!');
    }

    private function generateNumber(): string
    {
        return 'INV-'.now()->format('ym').'-'.str_pad((string) (Invoice::count() + 1), 4, '0', STR_PAD_LEFT);
    }
}
