<?php

namespace Database\Seeders;

use App\Models\Bahasa;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class BahasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bahasa::create([
            'id' => Str::uuid(),
            'bahasa' => 'Bahasa Indonesia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Bahasa::create([
            'id' => Str::uuid(),
            'bahasa' => 'Bahasa Inggris',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Bahasa::create([
            'id' => Str::uuid(),
            'bahasa' => 'Bahasa Arab',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Bahasa::create([
            'id' => Str::uuid(),
            'bahasa' => 'Bahasa Mandarin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Bahasa::create([
            'id' => Str::uuid(),
            'bahasa' => 'Bahasa Jepang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
