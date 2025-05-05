<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::create([
            'id' => Str::uuid(),
            'kategori' => 'B',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Kategori::create([
            'id' => Str::uuid(),
            'kategori' => 'A',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Kategori::create([
            'id' => Str::uuid(),
            'kategori' => 'C',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
