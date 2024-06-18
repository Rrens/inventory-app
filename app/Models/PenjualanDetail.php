<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenjualanDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'penjualan_detail_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'penjualan_detail_id',
        'penjualan_id',
        'barang_id',
        'quantity',
        'subtotal',
    ];

    public static function generateID($penjualan_id)
    {
        $penjualan_count = PenjualanDetail::count();
        $timestamp = round(microtime(true) * 1000);
        $hash = substr(md5($timestamp + $penjualan_count), 0, 8);
        $unique_id =  $penjualan_id . '-' . $hash;
        return $unique_id;
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id', 'penjualan_id');
    }

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id', 'barang_id');
    }
}
