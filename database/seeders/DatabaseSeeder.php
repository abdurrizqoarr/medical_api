<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Pegawai;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            BahasaSeeder::class,
            BangsalSeeder::class,
            CacatFisikSeeder::class,
            DepoObatSeeder::class,
            GolonganSeeder::class,
            JaminanSeeder::class,
            JenisSeeder::class,
            JenisTindakanRalanSeeder::class,
            JenisTindakanRanapSeeder::class,
            KabupatenSeeder::class,
            KategoriSeeder::class,
            KecamatanSeeder::class,
            KeluargaSeeder::class,
            KelurahanSeeder::class,
            PendidikanSeeder::class,
            PoliSeeder::class,
            ProvinsiSeeder::class,
            SatuanSeeder::class,
            SpesialisSeeder::class,
            SukuSeeder::class,
            SupplierSeeder::class,
        ]);
        Pegawai::factory(487)->create();
    }
}
