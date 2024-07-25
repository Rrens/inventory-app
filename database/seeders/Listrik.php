<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Listrik extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('listriks')->insert([
            [
                'place' => 'Gudang',
                'price' => 100000
            ],
            [
                'place' => 'Toko',
                'price' => 500000
            ]
        ]);
    }
}
