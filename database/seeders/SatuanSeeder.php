<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Satuan::create([
            'id' => Str::uuid(),
            'satuan' => 'Ampul',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Satuan::create([
            'id' => Str::uuid(),
            'satuan' => 'Botol',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Satuan::create([
            'id' => Str::uuid(),
            'satuan' => 'Dus',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Satuan::create([
            'id' => Str::uuid(),
            'satuan' => 'Lembar',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Satuan::create([
            'id' => Str::uuid(),
            'satuan' => 'Pcs',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Satuan::create([
            'id' => Str::uuid(),
            'satuan' => 'Sachet',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Satuan::create([
            'id' => Str::uuid(),
            'satuan' => 'Strip',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Satuan::create([
            'id' => Str::uuid(),
            'satuan' => 'Tabung',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Satuan::create([
            'id' => Str::uuid(),
            'satuan' => 'Unit',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Satuan::create([
            'id' => Str::uuid(),
            'satuan' => 'Vial',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Satuan::create([
            'id' => Str::uuid(),
            'satuan' => 'Botol Kaca',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
