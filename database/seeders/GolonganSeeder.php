<?php

namespace Database\Seeders;

use App\Models\Golongan;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class GolonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Golongan::create([
            'id' => Str::uuid(),
            'golongan' => 'A',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Golongan::create([
            'id' => Str::uuid(),
            'golongan' => 'B',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Golongan::create([
            'id' => Str::uuid(),
            'golongan' => 'C',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
