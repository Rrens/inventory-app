<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemesananDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pemesanan_details';
    protected $fillable = [
        'pemesanan_id',
        'barang_id',
        'quantity',
        'eoq',
        'status',
        'date_in',
        'order_cost',
        'supplier_id',
    ];

    public function supplier()
    {
        return $this->hasMany(Supplier::class, 'id', 'supplier_id');
    }

    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'id', 'pemesanan_id');
    }

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id', 'barang_id');
    }
}
