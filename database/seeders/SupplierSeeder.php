<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::create([
            'nama_suplier' => 'Kimia Farma',
            'no_kontak' => '08123456789',
            'alamat' => 'Jl. Raya No. 1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Supplier::create([
            'nama_suplier' => 'Indofarma',
            'no_kontak' => '08123456789',
            'alamat' => 'Jl. Raya No. 2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Supplier::create([
            'nama_suplier' => 'Apotek Sehat',
            'no_kontak' => '08123456789',
            'alamat' => 'Jl. Raya No. 3',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Supplier::create([
            'nama_suplier' => 'Apotek K24',
            'no_kontak' => '08123456789',
            'alamat' => 'Jl. Raya No. 4',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
