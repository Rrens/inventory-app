<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Barang::factory(10)->create();
        $buildingSupplies = [
            'Kran Air Amico 1/2',
            'Kran Air Sanho 1/2',
            'Selotip',
            'Pisau Potong WD',
            'Paku Beton 3 dim',
            'Sekrup Baja 2 dim',
            'Kunci Pintu',
            'Baut Drilling 12x25cm',
            'Sekrup Baja 1 dim',
            'Cat Semprot',
            'Lem Besi Dextone',
            'Meteran 5M',
            'Semen Gresik',
            'Cat Tembok Paragon',
            'Bor Besi 2MM',
        ];

        $faker = Faker::create();

        foreach ($buildingSupplies as $item) {
            $barang = new Barang();
            $barang->name = $item;
            $barang->saving_cost = $faker->randomFloat(2, 10000, 30000);
            $barang->price = $faker->randomFloat(2, 100000, 300000);
            $barang->unit = $faker->randomElement(['pcs', 'zak', 'unit', 'pack', 'm3']);
            $barang->quantity = $faker->numberBetween(100, 900);
            $barang->save();
        }
    }
}
