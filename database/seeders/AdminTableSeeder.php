<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Admin::insert([
            [
              'id'  			=> strtoupper(hash('sha256', "!@#!@#" . Carbon::now()->format('YmdH:i:s'))),
              'name'  			=> 'Super Admin',
              'nip'		        => '123456789012345678',
              'password'		=> Hash::make('password'),
              'role'            => 'superadmin',
              'avatar'          => null,
              'created_at'      => \Carbon\Carbon::now(),
              'updated_at'      => \Carbon\Carbon::now()
            ]
        ]);
    }
}
