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
        'leadtime',
        'eoq',
        'rop',
        'place',
        'max_quantity',
        'supplier_id'
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    public function supplier()
    {
        return $this->hasMany(Supplier::class, 'id', 'supplier_id');
    }

    public function penjualan_detail()
    {
        return $this->belongsTo(PenjualanDetail::class);
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function pemesanan_detail()
    {
        return $this->belongsTo(PemesananDetail::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function cart_penjualan()
    {
        return $this->belongsTo(CartPenjualan::class);
    }
}
