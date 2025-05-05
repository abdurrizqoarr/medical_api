<?php

namespace Database\Seeders;

use App\Models\Pendidikan;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class PendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pendidikan::create([
            'id' => Str::uuid(),
            'jenjang_pendidikan' => 'SD',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Pendidikan::create([
            'id' => Str::uuid(),
            'jenjang_pendidikan' => 'SMP',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Pendidikan::create([
            'id' => Str::uuid(),
            'jenjang_pendidikan' => 'SMA',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Pendidikan::create([
            'id' => Str::uuid(),
            'jenjang_pendidikan' => 'SARJANA',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
