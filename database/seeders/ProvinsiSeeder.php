<?php

namespace Database\Seeders;

use App\Models\Provinsi;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Provinsi::create([
            'id' => Str::uuid(),
            'provinsi' => 'Kalimantan Timur',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Provinsi::create([
            'id' => Str::uuid(),
            'provinsi' => 'Kalimantan Utara',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Provinsi::create([
            'id' => Str::uuid(),
            'provinsi' => 'Kalimantan Selatan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Provinsi::create([
            'id' => Str::uuid(),
            'provinsi' => 'Kalimantan Tengah',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Provinsi::create([
            'id' => Str::uuid(),
            'provinsi' => 'Jakarta',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Provinsi::create([
            'id' => Str::uuid(),
            'provinsi' => 'Jawa Barat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Provinsi::create([
            'id' => Str::uuid(),
            'provinsi' => 'Jawa Tengah',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Provinsi::create([
            'id' => Str::uuid(),
            'provinsi' => 'Jawa Timur',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
