<?php

namespace Database\Seeders;

use App\Models\Spesialis;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpesialisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Spesialis::create([
            'spesialis' => 'Penyakit Dalam',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Spesialis::create([
            'spesialis' => 'Penyakit Jantung',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Spesialis::create([
            'spesialis' => 'Penyakit Kulit',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Spesialis::create([
            'spesialis' => 'Penyakit Saraf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Spesialis::create([
            'spesialis' => 'Penyakit THT',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Spesialis::create([
            'spesialis' => 'Penyakit Gigi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Spesialis::create([
            'spesialis' => 'Penyakit Anak',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Spesialis::create([
            'spesialis' => 'Penyakit Kandungan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Spesialis::create([
            'spesialis' => 'Penyakit Mata',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Spesialis::create([
            'spesialis' => 'Penyakit Paru',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Spesialis::create([
            'spesialis' => 'Penyakit Bedah',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Spesialis::create([
            'spesialis' => 'Penyakit Jiwa',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Spesialis::create([
            'spesialis' => 'Penyakit Rehabilitasi Medik',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
