<?php

namespace App\Observers;

use App\Models\CashEntry;
use App\Models\Payment;

/**
 * Kas masuk otomatis dari pembayaran terkonfirmasi (cash basis, PRD §5.7).
 */
class PaymentObserver
{
    public function created(Payment $payment): void
    {
        CashEntry::create([
            'tanggal'    => $payment->tanggal,
            'tipe'       => 'in',
            'kategori'   => 'Pembayaran Unit',
            'jumlah'     => $payment->jumlah,
            'keterangan' => 'Pembayaran '.optional($payment->invoice)->no_invoice,
            'ref_type'   => 'payment',
            'ref_id'     => $payment->id,
        ]);
    }

    public function deleted(Payment $payment): void
    {
        CashEntry::where('ref_type', 'payment')
            ->where('ref_id', $payment->id)
            ->delete();
    }
}
