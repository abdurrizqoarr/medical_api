<?php

namespace Database\Seeders;

use App\Models\JenisTindakanRalan;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class JenisTindakanRalanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisTindakanRalan::create([
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
        JenisTindakanRalan::create([
            'id' => Str::uuid(),
            'nama_perawatan' => 'Pemeriksaan Dokter Umum',
            'total_tarif' => '40000',
            'bhp' => '0',
            'kso' => '0',
            'manajemen' => '15000',
            'material' => '0',
            'tarif_dokter' => '25000',
            'tarif_perawat' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        JenisTindakanRalan::create([
            'id' => Str::uuid(),
            'nama_perawatan' => 'Pemeriksaan Gigi',
            'total_tarif' => '50000',
            'bhp' => '0',
            'kso' => '0',
            'manajemen' => '20000',
            'material' => '0',
            'tarif_dokter' => '30000',
            'tarif_perawat' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        JenisTindakanRalan::create([
            'id' => Str::uuid(),
            'nama_perawatan' => 'Pemeriksaan Fisioterapi',
            'total_tarif' => '70000',
            'bhp' => '0',
            'kso' => '0',
            'manajemen' => '25000',
            'material' => '0',
            'tarif_dokter' => '45000',
            'tarif_perawat' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
