<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'quantity',
        'supplier_id',
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id', 'barang_id');
    }

    public function supplier()
    {
        return $this->hasMany(Supplier::class, 'id', 'supplier_id');
    }
}
