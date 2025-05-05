<?php

namespace Database\Seeders;

use App\Models\Kabupaten;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class KabupatenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kabupaten::create([
            'id' => Str::uuid(),
            'kabupaten' => 'Kutai Kartanegara',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Kabupaten::create([
            'id' => Str::uuid(),
            'kabupaten' => 'Balikpapan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Kabupaten::create([
            'id' => Str::uuid(),
            'kabupaten' => 'Samarinda',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Kabupaten::create([
            'id' => Str::uuid(),
            'kabupaten' => 'Bontang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Kabupaten::create([
            'id' => Str::uuid(),
            'kabupaten' => 'Berau',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Kabupaten::create([
            'id' => Str::uuid(),
            'kabupaten' => 'Kutai Barat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Kabupaten::create([
            'id' => Str::uuid(),
            'kabupaten' => 'Kutai Timur',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Kabupaten::create([
            'id' => Str::uuid(),
            'kabupaten' => 'Penajam Paser Utara',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Kabupaten::create([
            'id' => Str::uuid(),
            'kabupaten' => 'Paser',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Kabupaten::create([
            'id' => Str::uuid(),
            'kabupaten' => 'Mahakam Ulu',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
