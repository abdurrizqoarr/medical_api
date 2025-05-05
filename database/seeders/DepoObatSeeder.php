<?php

namespace Database\Seeders;

use App\Models\DepoObat;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DepoObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DepoObat::create([
            'id' => Str::uuid(),
            'depo_obat' => 'Gudang Farmasi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DepoObat::create([
            'id' => Str::uuid(),
            'depo_obat' => 'Gudang Rawat Inap',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DepoObat::create([
            'id' => Str::uuid(),
            'depo_obat' => 'Gudang Rawat Jalan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DepoObat::create([
            'id' => Str::uuid(),
            'depo_obat' => 'Gudang Radiologi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
