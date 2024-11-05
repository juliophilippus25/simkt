<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regencies = [
            ['name' => 'Barito Selatan'],
            ['name' => 'Barito Timur'],
            ['name' => 'Barito Utara'],
            ['name' => 'Gunung Mas'],
            ['name' => 'Kapuas'],
            ['name' => 'Katingan'],
            ['name' => 'Kotawaringin Barat'],
            ['name' => 'Kotawaringin Timur'],
            ['name' => 'Lamandau'],
            ['name' => 'Murung Raya'],
            ['name' => 'Pulang Pisau'],
            ['name' => 'Seruyan'],
            ['name' => 'Sukamara'],
            ['name' => 'Palangkaraya']
        ];

        foreach ($regencies as $regency) {
            DB::table('regencies')->insert([
                'id' => Str::upper(Str::random(10)),
                'name' => $regency['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
