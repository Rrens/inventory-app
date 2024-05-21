<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = file_get_contents('database/seeders/JSON/Penjualan.json');
        $datas = json_decode($datas);

        DB::beginTransaction();
        try {
            foreach ($datas as $data) {
                // Buat penjualan baru
                $penjualan = new Penjualan;
                $penjualan->penjualan_id = Penjualan::generateID();
                $penjualan->slug = Str::random(5);
                $penjualan->order_date = $data->order_date;
                $penjualan->save();

                foreach ($data->items as $item) {
                    $barang = Barang::where('name', $item->product_name)->first();

                    if (is_null($barang)) {
                        echo "Barang dengan nama {$item->product_name} tidak ditemukan.\n";
                        continue;
                    }

                    $penjualan_detail = new PenjualanDetail();
                    $penjualan_detail->penjualan_detail_id = PenjualanDetail::generateID($penjualan->penjualan_id);
                    $penjualan_detail->barang_id = $barang->id;
                    $penjualan_detail->penjualan_id = $penjualan->penjualan_id;
                    $penjualan_detail->quantity = $item->quantity;
                    $penjualan_detail->subtotal = $item->quantity * $barang->price;
                    $penjualan_detail->save();
                }

                $sum_grand_total = PenjualanDetail::where('penjualan_id', $penjualan->penjualan_id)->sum('subtotal');
                $penjualan->grand_total = $sum_grand_total;
                $penjualan->save();
            }
            DB::commit();
        } catch (Exception $err) {
            echo $err->getMessage();
            DB::rollBack();
        }
    }
}
