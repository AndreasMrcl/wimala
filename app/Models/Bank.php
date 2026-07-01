<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kontak',
        'suku_bunga_acuan',
    ];

    protected $casts = [
        'suku_bunga_acuan' => 'decimal:2',
    ];
}
