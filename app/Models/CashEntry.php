<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'tipe',
        'kategori',
        'jumlah',
        'keterangan',
        'ref_type',
        'ref_id',
    ];

    protected $casts = [
        'jumlah'  => 'decimal:2',
        'tanggal' => 'date',
    ];

    // Kategori untuk kas keluar (manual)
    public const KATEGORI_OUT = [
        'operasional' => 'Operasional',
        'konstruksi'  => 'Biaya Konstruksi',
        'marketing'   => 'Marketing',
        'komisi'      => 'Komisi Sales',
        'pajak'       => 'Pajak & Retribusi',
        'lainnya'     => 'Lainnya',
    ];

    /**
     * Entri otomatis (dari pembayaran) tidak boleh diubah/dihapus manual.
     */
    public function isAuto(): bool
    {
        return $this->ref_type !== null;
    }
}
