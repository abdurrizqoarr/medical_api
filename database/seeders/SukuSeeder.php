<?php

namespace Database\Seeders;

use App\Models\Suku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Suku::create([
            'suku' => 'Jawa',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Suku::create([
            'suku' => 'Sunda',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Suku::create([
            'suku' => 'Batak',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Suku::create([
            'suku' => 'Minangkabau',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Suku::create([
            'suku' => 'Bugis',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Suku::create([
            'suku' => 'Bali',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
