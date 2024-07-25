<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartPenjualan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'barang_id',
        'quantity',
        'status',
        'order_date'
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id', 'barang_id');
    }
}
