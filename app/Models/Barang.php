<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barangs';
    protected $fillable = [
        'name',
        'saving_cost',
        'price',
        'unit',
        'quantity',
        'eoq',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    public function penjualan_detail()
    {
        return $this->belongsTo(PenjualanDetail::class);
    }

    public function pemesanan_detail()
    {
        return $this->belongsTo(PemesananDetail::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
