<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'buyer_id',
        'marketing_id',
        'payment_method',
        'bank_id',
        'current_stage_code',
        'status',
        'cancelled_reason',
    ];

    public const PAYMENT_LABELS = [
        'cash_keras'    => 'Cash keras',
        'cash_bertahap' => 'Cash bertahap',
        'kpr'           => 'KPR',
    ];

    public function isKpr(): bool
    {
        return $this->payment_method === 'kpr';
    }

    public function paymentLabel(): string
    {
        return self::PAYMENT_LABELS[$this->payment_method] ?? $this->payment_method;
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    public function marketing()
    {
        return $this->belongsTo(Marketing::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function currentStage()
    {
        return $this->belongsTo(PipelineStage::class, 'current_stage_code', 'stage_code');
    }

    public function stageLogs()
    {
        return $this->hasMany(TransactionStageLog::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
