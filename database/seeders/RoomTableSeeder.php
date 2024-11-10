<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 24; $i++) {
            DB::table('rooms')->insert([
                'id' => 'M' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'name' => 'Kamar ' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'days_period' => 30,
                'price' => 200000,
                'room_type' => 'M',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for ($i = 1; $i <= 20; $i++) {
            DB::table('rooms')->insert([
                'id' => 'F' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'name' => 'Kamar ' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'days_period' => 30,
                'price' => 200000,
                'room_type' => 'F',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
