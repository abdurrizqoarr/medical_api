<?php

namespace Database\Seeders;

use App\Models\Jaminan;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class JaminanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jaminan::create([
            'id' => Str::uuid(),
            'jaminan' => 'BPJS',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Jaminan::create([
            'id' => Str::uuid(),
            'jaminan' => 'UMUM',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Jaminan::create([
            'id' => Str::uuid(),
            'jaminan' => 'KPC',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Jaminan::create([
            'id' => Str::uuid(),
            'jaminan' => 'PAMA',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
