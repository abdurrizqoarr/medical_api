<?php

namespace Database\Seeders;

use App\Models\Keluarga;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class KeluargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Keluarga::create([
            'id' => Str::uuid(),
            'keluarga' => 'Ayah',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Keluarga::create([
            'id' => Str::uuid(),
            'keluarga' => 'Ibu',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Keluarga::create([
            'id' => Str::uuid(),
            'keluarga' => 'Paman',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Keluarga::create([
            'id' => Str::uuid(),
            'keluarga' => 'Anak',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Keluarga::create([
            'id' => Str::uuid(),
            'keluarga' => 'Kakak',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Keluarga::create([
            'id' => Str::uuid(),
            'keluarga' => 'Adik',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
