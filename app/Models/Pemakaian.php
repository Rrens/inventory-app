<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemakaian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pemakaians';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'penjualan_id',
        'status'
    ];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'penjualan_id', 'penjualan_id');
    }
}
