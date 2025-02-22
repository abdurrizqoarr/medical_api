<?php

namespace Database\Seeders;

use App\Models\Pegawai;
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


        $user = User::create([
            'id' => Str::uuid(),
            'pegawai_id' => $pegawai->id,
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $role = Role::where('name', 'admin')->first();
        $user->assignRole($role);
    }
}
