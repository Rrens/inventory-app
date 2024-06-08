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

use function PHPSTORM_META\map;

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

        // DB::table('penjualans')->insert([
        //     'slug' => Str::random(5),
        //     'order_date' => '2024-09-10',
        //     'grand_total' => 100000,
        // ]);

        // $penjualan = new Penjualan;
        // $penjualan->penjualan_id = Penjualan::generateID();
        // $penjualan->slug = Str::random(5);
        // $penjualan->order_date = '2024-09-10';
        // $penjualan->grand_total = 100000;
        // $penjualan->save();



        // DB::table('penjualan_details')->insert(
        //     [
        //         [
        //             'penjualan_detail_id' => PenjualanDetail::generateID($penjualan->id),
        //             'penjualan_id' => $penjualan->id,
        //             'barang_id' => 1,
        //             'quantity' => 30,
        //             'subtotal' => $this->getSubTotal(1, 30),
        //         ],
        //         [
        //             'penjualan_detail_id' => PenjualanDetail::generateID($penjualan->id),
        //             'penjualan_id' => $penjualan->id,
        //             'barang_id' => 2,
        //             'quantity' => 20,
        //             'subtotal' => $this->getSubTotal(2, 20),
        //         ],
        //         [
        //             'penjualan_detail_id' => PenjualanDetail::generateID($penjualan->id),
        //             'penjualan_id' => $penjualan->id,
        //             'barang_id' => 3,
        //             'quantity' => 100,
        //             'subtotal' => $this->getSubTotal(3, 100),
        //         ],
        //         [
        //             'penjualan_detail_id' => PenjualanDetail::generateID($penjualan->id),
        //             'penjualan_id' => $penjualan->id,
        //             'barang_id' => 4,
        //             'quantity' => 320,
        //             'subtotal' => $this->getSubTotal(4, 320),
        //         ],
        //         [
        //             'penjualan_detail_id' => PenjualanDetail::generateID($penjualan->id),
        //             'penjualan_id' => $penjualan->id,
        //             'barang_id' => 5,
        //             'quantity' => 30,
        //             'subtotal' => $this->getSubTotal(5, 30),
        //         ],
        //         [
        //             'penjualan_detail_id' => PenjualanDetail::generateID($penjualan->id),
        //             'penjualan_id' => $penjualan->id,
        //             'barang_id' => 6,
        //             'quantity' => 7,
        //             'subtotal' => $this->getSubTotal(6, 7),
        //         ],
        //         [
        //             'penjualan_detail_id' => PenjualanDetail::generateID($penjualan->id),
        //             'penjualan_id' => $penjualan->id,
        //             'barang_id' => 7,
        //             'quantity' => 10,
        //             'subtotal' => $this->getSubTotal(7, 10),
        //         ],
        //         [
        //             'penjualan_detail_id' => PenjualanDetail::generateID($penjualan->id),
        //             'penjualan_id' => $penjualan->id,
        //             'barang_id' => 8,
        //             'quantity' => 5,
        //             'subtotal' => $this->getSubTotal(8, 5),
        //         ],
        //         [
        //             'penjualan_detail_id' => PenjualanDetail::generateID($penjualan->id),
        //             'penjualan_id' => $penjualan->id,
        //             'barang_id' => 9,
        //             'quantity' => 30,
        //             'subtotal' => $this->getSubTotal(9, 30),
        //         ],
        //         [
        //             'penjualan_detail_id' => PenjualanDetail::generateID($penjualan->id),
        //             'penjualan_id' => $penjualan->id,
        //             'barang_id' => 10,
        //             'quantity' => 50,
        //             'subtotal' => $this->getSubTotal(10, 50),
        //         ],
        //         [
        //             'penjualan_detail_id' => PenjualanDetail::generateID($penjualan->id),
        //             'penjualan_id' => $penjualan->id,
        //             'barang_id' => 11,
        //             'quantity' => 20,
        //             'subtotal' => $this->getSubTotal(11, 20),
        //         ],
        //         [
        //             'penjualan_detail_id' => PenjualanDetail::generateID($penjualan->id),
        //             'penjualan_id' => $penjualan->id,
        //             'barang_id' => 12,
        //             'quantity' => 30,
        //             'subtotal' => $this->getSubTotal(12, 30),
        //         ],
        //         [
        //             'penjualan_detail_id' => PenjualanDetail::generateID($penjualan->id),
        //             'penjualan_id' => $penjualan->id,
        //             'barang_id' => 13,
        //             'quantity' => 720,
        //             'subtotal' => $this->getSubTotal(13, 720),
        //         ],
        //         [
        //             'penjualan_detail_id' => PenjualanDetail::generateID($penjualan->id),
        //             'penjualan_id' => $penjualan->id,
        //             'barang_id' => 14,
        //             'quantity' => 40,
        //             'subtotal' => $this->getSubTotal(14, 40),
        //         ],
        //         [
        //             'penjualan_detail_id' => PenjualanDetail::generateID($penjualan->id),
        //             'penjualan_id' => $penjualan->id,
        //             'barang_id' => 15,
        //             'quantity' => 10,
        //             'subtotal' => $this->getSubTotal(15, 10),
        //         ],
        //     ]
        // );

        // $penjualan_after = Penjualan::findOrFail($penjualan->penjualan_id);
        // $penjualan_after->grand_total = PenjualanDetail::sum('subtotal');
        // $penjualan_after->save();
    }

    public function getSubTotal($barang_id, $quantity)
    {
        $barang = Barang::where('id', $barang_id)->first();
        $subtotal = $barang->price * $quantity;
        return $subtotal;
    }
}
