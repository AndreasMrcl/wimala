<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionStageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_transaction_id',
        'stage_code',
        'status',
        'kpr_sub_status',
        'started_at',
        'completed_at',
        'pic_user_id',
        'notes',
    ];

    protected $casts = [
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function saleTransaction()
    {
        return $this->belongsTo(SaleTransaction::class);
    }

    public function stage()
    {
        return $this->belongsTo(PipelineStage::class, 'stage_code', 'stage_code');
    }
}
