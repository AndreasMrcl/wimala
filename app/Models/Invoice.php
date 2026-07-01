<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_transaction_id',
        'no_invoice',
        'jenis_termin',
        'jumlah',
        'jatuh_tempo',
        'status',
    ];

    protected $casts = [
        'jumlah'      => 'decimal:2',
        'jatuh_tempo' => 'date',
    ];

    public const TERMIN_LABELS = [
        'booking_fee'    => 'Booking Fee',
        'dp'             => 'DP',
        'cicilan'        => 'Cicilan',
        'pelunasan'      => 'Pelunasan',
        'pencairan_bank' => 'Pencairan Bank',
    ];

    public function saleTransaction()
    {
        return $this->belongsTo(SaleTransaction::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function paidAmount(): float
    {
        return (float) $this->payments->sum('jumlah');
    }

    public function outstanding(): float
    {
        return max(0, (float) $this->jumlah - $this->paidAmount());
    }

    public function isPaid(): bool
    {
        return $this->paidAmount() >= (float) $this->jumlah;
    }

    public function isLate(): bool
    {
        return ! $this->isPaid() && $this->jatuh_tempo->lt(today());
    }

    /**
     * Status efektif untuk tampilan: paid / late / unpaid.
     */
    public function effectiveStatus(): string
    {
        return $this->isPaid() ? 'paid' : ($this->isLate() ? 'late' : 'unpaid');
    }

    public function terminLabel(): string
    {
        return self::TERMIN_LABELS[$this->jenis_termin] ?? $this->jenis_termin;
    }
}
