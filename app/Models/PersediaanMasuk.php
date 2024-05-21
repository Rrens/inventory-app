<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PersediaanMasuk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'persediaan_masuks';
    protected $primaryKey = 'persediaan_masuk_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'persediaan_masuk_id', 'slug', 'pemesanan_id', 'tanggal_persediaan_masuk'
    ];

    public static function generatePersediaanMasukId()
    {
        $persediaan_masuk_id = DB::table('persediaan_masuks')->whereYear('tanggal_persediaan_masuk', now()->year)->max('persediaan_masuk_id');
        $addZero = '';
        $persediaan_masuk_id = substr($persediaan_masuk_id, 9, 6);
        $persediaan_masuk_id = (int) $persediaan_masuk_id + 1;
        $incrementPersediaanMasukId = $persediaan_masuk_id;

        if (strlen($persediaan_masuk_id) == 1) {
            $addZero = "0000";
        } elseif (strlen($persediaan_masuk_id) == 2) {
            $addZero = "000";
        } elseif (strlen($persediaan_masuk_id) == 3) {
            $addZero = "00";
        } elseif (strlen($persediaan_masuk_id) == 4) {
            $addZero = "0";
        }

        $newPersediaanMasukId = "PSM." . now()->year . "." . $addZero . $incrementPersediaanMasukId;
        return $newPersediaanMasukId;
    }
}
