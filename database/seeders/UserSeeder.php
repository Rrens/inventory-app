<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'role' => 'admin'
            ],
            [
                'name' => 'owner',
                'username' => 'owner',
                'password' => Hash::make('owner'),
                'role' => 'owner'
            ],
        ]);
    }
}
