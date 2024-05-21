<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $buildingSupplies = [
            'Kran Air Amico 1/2',
            'Kran Air Sanho 1/2',
            'Selotip',
            'Pisau Potong WD',
            'Paku Beton 3 dim',
            'Sekrup Baja 3 dim',
            'Sekrup Baja 2 dim',
            'Baut Drilling 12x25cm',
            'Cat Semprot',
            'Lem Besi Dextone',
            'Meteran 5M',
            'Semen Gresik',
            'Cat Tembok EMCO',
            'Bor Besi 2MM',
        ];


        return [
            'name' => Arr::random($buildingSupplies),
            'saving_cost' => $this->faker->randomFloat(2, 10000, 30000), // Angka 10 dan 100 sesuaikan dengan rentang yang Anda inginkan
            'price' => $this->faker->randomFloat(2, 100000, 300000),
            'unit' => $this->faker->randomElement(['pcs', 'zak', 'unit', 'pack', 'm3']),
            'quantity' => $this->faker->numberBetween(1, 10)
        ];
    }
}
