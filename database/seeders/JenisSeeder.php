<?php

namespace Database\Seeders;

use App\Models\Jenis;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jenis::create([
            'id' => Str::uuid(),
            'jenis' => 'A',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Jenis::create([
            'id' => Str::uuid(),
            'jenis' => 'B',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Jenis::create([
            'id' => Str::uuid(),
            'jenis' => 'C',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
