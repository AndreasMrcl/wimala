<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'invoice_id'     => 'required|exists:invoices,id',
            'tanggal'        => 'required|date',
            'jumlah'         => 'required|numeric|min:1',
            'metode'         => 'required|in:transfer,tunai',
            'bukti_transfer' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $invoice = Invoice::findOrFail($data['invoice_id']);

        if ($request->hasFile('bukti_transfer')) {
            $data['bukti_transfer'] = $request->file('bukti_transfer')->store('bukti', 'public');
        }

        // Konfirmasi manual: pencatat pembayaran = yang mengonfirmasi
        $data['confirmed_by'] = auth()->id();

        Payment::create($data);

        $this->syncStatus($invoice);

        return redirect()->route('invoices.show', $invoice)->with('success', 'Pembayaran berhasil dicatat!');
    }

    public function destroy(Payment $payment)
    {
        $invoice = $payment->invoice;

        if ($payment->bukti_transfer) {
            Storage::disk('public')->delete($payment->bukti_transfer);
        }

        $payment->delete();

        $this->syncStatus($invoice);

        return redirect()->route('invoices.show', $invoice)->with('success', 'Pembayaran dihapus.');
    }

    private function syncStatus(Invoice $invoice): void
    {
        $invoice->load('payments');
        $invoice->update(['status' => $invoice->isPaid() ? 'paid' : 'unpaid']);
    }
}
