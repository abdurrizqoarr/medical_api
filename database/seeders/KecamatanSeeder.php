<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kecamatan::create([
            'id' => Str::uuid(),
            'kecamatan' => 'Sangatta Utara',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Kecamatan::create([
            'id' => Str::uuid(),
            'kecamatan' => 'Sangatta Selatan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Kecamatan::create([
            'id' => Str::uuid(),
            'kecamatan' => 'Bengalon',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Kecamatan::create([
            'id' => Str::uuid(),
            'kecamatan' => 'Teluk Pandan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Kecamatan::create([
            'id' => Str::uuid(),
            'kecamatan' => 'Rantau Pulung',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Kecamatan::create([
            'id' => Str::uuid(),
            'kecamatan' => 'Kaubun',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Kecamatan::create([
            'id' => Str::uuid(),
            'kecamatan' => 'Karangan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
