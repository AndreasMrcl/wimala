<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PipelineStage extends Model
{
    protected $primaryKey = 'stage_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'stage_code',
        'sequence',
        'name',
        'applicable_rule',
        'unit_status_trigger',
    ];

    public function logs()
    {
        return $this->hasMany(TransactionStageLog::class, 'stage_code', 'stage_code');
    }
}
