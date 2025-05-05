<?php

namespace Database\Seeders;

use App\Models\JenisTindakanRanap;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class JenisTindakanRanapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisTindakanRanap::create([
            'id' => Str::uuid(),
            'nama_perawatan' => 'Pemeriksaan Dokter Spesialis',
            'total_tarif' => '60000',
            'bhp' => '0',
            'kso' => '0',
            'manajemen' => '20000',
            'material' => '0',
            'tarif_dokter' => '40000',
            'tarif_perawat' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
