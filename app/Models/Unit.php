<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'cluster_id',
        'house_type_id',
        'kode',
        'blok',
        'nomor',
        'luas_tanah',
        'luas_bangunan',
        'harga',
        'delivery_type',
        'status',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    /**
     * Label status unit (lapisan inventory).
     */
    public const STATUS_LABELS = [
        'available'   => 'Tersedia',
        'booked'      => 'Dibooking',
        'sold'        => 'Terjual',
        'handed_over' => 'Serah terima',
        'completed'   => 'Selesai',
    ];

    public function cluster()
    {
        return $this->belongsTo(Cluster::class);
    }

    public function houseType()
    {
        return $this->belongsTo(HouseType::class);
    }

    public function saleTransactions()
    {
        return $this->hasMany(SaleTransaction::class);
    }

    public function activeSaleTransaction()
    {
        return $this->hasOne(SaleTransaction::class)->where('status', 'active');
    }

    public function getRouteKeyName(): string
    {
        return 'kode';
    }
}
