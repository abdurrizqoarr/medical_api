<?php

namespace Database\Seeders;

use App\Models\Kelurahan;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kelurahan::create([
            'id' => Str::uuid(),
            'kelurahan' => 'Sangatta Utara',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Kelurahan::create([
            'id' => Str::uuid(),
            'kelurahan' => 'Sangatta Selatan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Kelurahan::create([
            'id' => Str::uuid(),
            'kelurahan' => 'Bontang Barat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Kelurahan::create([
            'id' => Str::uuid(),
            'kelurahan' => 'Bontang Utara',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Kelurahan::create([
            'id' => Str::uuid(),
            'kelurahan' => 'Bontang Selatan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Kelurahan::create([
            'id' => Str::uuid(),
            'kelurahan' => 'Samarinda Kota',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Kelurahan::create([
            'id' => Str::uuid(),
            'kelurahan' => 'Samarinda Seberang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Kelurahan::create([
            'id' => Str::uuid(),
            'kelurahan' => 'Balikpapan Tengah',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Kelurahan::create([
            'id' => Str::uuid(),
            'kelurahan' => 'Balikpapan Selatan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
