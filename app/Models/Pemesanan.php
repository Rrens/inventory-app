<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemesanan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pemesanans';
    protected $fillable = [
        'pemesanan_id',
        'supplier_id',
        'barang_id',
        'store_for',
        'order_cost',
        'price_total',
        'is_verify',
        'order_date',
        'slug',
    ];

    public static function generateID()
    {
        $pemesanan_id = Pemesanan::whereYear('created_at', now()->year)->max('pemesanan_id');
        $addZero = '';
        $pemesanan_id = substr($pemesanan_id, 9, 6);
        $pemesanan_id = (int) $pemesanan_id + 1;
        $incrementPemesananId = $pemesanan_id;

        if (strlen($pemesanan_id) == 1) {
            $addZero = "0000";
        } elseif (strlen($pemesanan_id) == 2) {
            $addZero = "000";
        } elseif (strlen($pemesanan_id) == 3) {
            $addZero = "00";
        } elseif (strlen($pemesanan_id) == 4) {
            $addZero = "0";
        }

        $newPemesananId = "PMP." . now()->year . "." . $addZero . $incrementPemesananId;
        return $newPemesananId;
    }

    public function supplier()
    {
        return $this->hasMany(Supplier::class, 'id', 'supplier_id');
    }

    public function pemesanan_detail()
    {
        return $this->belongsTo(PemesananDetail::class);
    }
}
