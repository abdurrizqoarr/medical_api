<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pegawai = Pegawai::create([
            'id' => Str::uuid(),
            'nik' => '3276012300010001',
            'npwp' => '123456789012345',
            'nip' => '198001012022011001',
            'nama' => 'Ahmad Fauzi',
            'jenis_kelamin' => 'PRIA',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1980-01-01',
            'stts_nikah' => 'MENIKAH',
            'alamat' => 'Jl. Merdeka No. 10, Jakarta',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $pegawai2 = Pegawai::create([
            'id' => Str::uuid(),
            'nik' => '3246012300010001',
            'npwp' => '153456789012345',
            'nip' => '1980066012022011001',
            'nama' => 'Ahmad Fauzi2',
            'jenis_kelamin' => 'PRIA',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1980-01-01',
            'stts_nikah' => 'MENIKAH',
            'alamat' => 'Jl. Merdeka No. 10, Jakarta',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $pegawai3 = Pegawai::create([
            'id' => Str::uuid(),
            'nik' => '3243652300010001',
            'npwp' => '153643289012345',
            'nip' => '1987346012022011001',
            'nama' => 'Ahmad Fauzi3',
            'jenis_kelamin' => 'PRIA',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1980-01-01',
            'stts_nikah' => 'MENIKAH',
            'alamat' => 'Jl. Merdeka No. 10, Jakarta',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $pegawai4 = Pegawai::create([
            'id' => Str::uuid(),
            'nik' => '3243666300010001',
            'npwp' => '153643289232345',
            'nip' => '19873460120643011001',
            'nama' => 'Ahmad Fauzi3',
            'jenis_kelamin' => 'PRIA',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1980-01-01',
            'stts_nikah' => 'MENIKAH',
            'alamat' => 'Jl. Merdeka No. 10, Jakarta',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = User::create([
            'pegawai_id' => $pegawai->id,
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user2 = User::create([
            'pegawai_id' => $pegawai2->id,
            'username' => 'admin2',
            'password' => Hash::make('admin2'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user3 = User::create([
            'pegawai_id' => $pegawai3->id,
            'username' => 'admin3',
            'password' => Hash::make('admin3'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user4 = User::create([
            'pegawai_id' => $pegawai4->id,
            'username' => 'admin4',
            'password' => Hash::make('admin4'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $role = Role::where('name', 'admin')->first();
        $user->assignRole($role);

        $role2 = Role::where('name', 'dummy')->first();
        $user2->assignRole($role2);

        $role3 = Role::where('name', 'rm')->first();
        $user3->assignRole($role3);

        $permission = Permission::where('name', 'tambah-provinsi')->first();
        $user4->givePermissionTo($permission);
    }
}
