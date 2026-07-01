<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'ktp',
        'npwp',
        'telepon',
        'email',
        'alamat',
    ];

    public function saleTransactions()
    {
        return $this->hasMany(SaleTransaction::class);
    }
}
