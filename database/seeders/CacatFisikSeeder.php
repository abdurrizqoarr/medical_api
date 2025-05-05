<?php

namespace Database\Seeders;

use App\Models\CacatFisik;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CacatFisikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CacatFisik::create([
            'id' => Str::uuid(),
            'cacat_fisik' => 'Tunanetra',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        CacatFisik::create([
            'id' => Str::uuid(),
            'cacat_fisik' => 'Tunarungu',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        CacatFisik::create([
            'id' => Str::uuid(),
            'cacat_fisik' => 'Tuna Grahita',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        CacatFisik::create([
            'id' => Str::uuid(),
            'cacat_fisik' => 'Tuna Daksa',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        CacatFisik::create([
            'id' => Str::uuid(),
            'cacat_fisik' => 'Tuna Laras',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        CacatFisik::create([
            'id' => Str::uuid(),
            'cacat_fisik' => 'Tuna Wicara',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        CacatFisik::create([
            'id' => Str::uuid(),
            'cacat_fisik' => 'Tuna Netra',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        CacatFisik::create([
            'id' => Str::uuid(),
            'cacat_fisik' => 'Tuna Rungu Wicara',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        CacatFisik::create([
            'id' => Str::uuid(),
            'cacat_fisik' => 'Tuna Grahita Ringan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        CacatFisik::create([
            'id' => Str::uuid(),
            'cacat_fisik' => 'Tuna Grahita Sedang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        CacatFisik::create([
            'id' => Str::uuid(),
            'cacat_fisik' => 'Tuna Grahita Berat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        CacatFisik::create([
            'id' => Str::uuid(),
            'cacat_fisik' => 'Tuna Laras Ringan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        CacatFisik::create([
            'id' => Str::uuid(),
            'cacat_fisik' => 'Tuna Laras Sedang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        CacatFisik::create([
            'id' => Str::uuid(),
            'cacat_fisik' => 'Tuna Laras Berat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        CacatFisik::create([
            'id' => Str::uuid(),
            'cacat_fisik' => 'Tuna Wicara Ringan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        CacatFisik::create([
            'id' => Str::uuid(),
            'cacat_fisik' => 'Tuna Wicara Sedang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
