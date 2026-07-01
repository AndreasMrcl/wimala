<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseType extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'luas_tanah',
        'luas_bangunan',
        'kamar_tidur',
        'kamar_mandi',
        'harga_dasar',
    ];

    protected $casts = [
        'harga_dasar' => 'decimal:2',
    ];

    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}
