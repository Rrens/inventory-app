<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penjualan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penjualans';
    protected $primaryKey = 'penjualan_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'penjualan_id',
        'slug',
        'grand_total',
        'order_date',
    ];

    public static function generateID()
    {
        $penjualan_count = Penjualan::count();
        $timestamp = round(microtime(true) * 1000);
        $hash = substr(md5($timestamp + $penjualan_count), 0, 8);
        $unique_id = 'PENJUALAN' . '-' . $hash;
        return $unique_id;
    }

    public function penjualan_detail()
    {
        return $this->belongsTo(PenjualanDetail::class);
    }
}
