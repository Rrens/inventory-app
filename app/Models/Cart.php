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
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id', 'barang_id');
    }
}
