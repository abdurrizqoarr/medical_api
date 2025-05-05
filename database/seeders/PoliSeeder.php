<?php

namespace Database\Seeders;

use App\Models\Poli;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Poli::create([
            'id' => Str::uuid(),
            'poli' => 'Poli Umum',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Poli::create([
            'id' => Str::uuid(),
            'poli' => 'Poli Gigi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Poli::create([
            'id' => Str::uuid(),
            'poli' => 'Poli Anak',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Poli::create([
            'id' => Str::uuid(),
            'poli' => 'Poli Kandungan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Poli::create([
            'id' => Str::uuid(),
            'poli' => 'Poli Jantung',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Poli::create([
            'id' => Str::uuid(),
            'poli' => 'Poli THT',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Poli::create([
            'id' => Str::uuid(),
            'poli' => 'Poli Kulit',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Poli::create([
            'id' => Str::uuid(),
            'poli' => 'Poli Saraf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Poli::create([
            'id' => Str::uuid(),
            'poli' => 'Poli Penyakit Dalam',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Poli::create([
            'id' => Str::uuid(),
            'poli' => 'Poli Bedah',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Poli::create([
            'id' => Str::uuid(),
            'poli' => 'Poli Rehabilitasi Medik',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Poli::create([
            'id' => Str::uuid(),
            'poli' => 'Poli Gizi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Poli::create([
            'id' => Str::uuid(),
            'poli' => 'Poli Mata',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Poli::create([
            'id' => Str::uuid(),
            'poli' => 'Poli Paru',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
