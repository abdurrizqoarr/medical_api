<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin' => [
                'provinsi' => ['tambah', 'edit', 'soft-delete', 'permanent-delete', 'lihat'],
                'kecamatan' => ['tambah', 'edit', 'soft-delete', 'permanent-delete', 'lihat'],
                'kabupaten' => ['tambah', 'edit', 'soft-delete', 'permanent-delete', 'lihat'],
                'suku' => ['tambah', 'edit', 'soft-delete', 'permanent-delete', 'lihat'],
                'bahasa' => ['tambah', 'edit', 'soft-delete', 'permanent-delete', 'lihat'],
                'cacat_fisik' => ['tambah', 'edit', 'soft-delete', 'permanent-delete', 'lihat'],
                'pendidikan' => ['tambah', 'edit', 'soft-delete', 'permanent-delete', 'lihat'],
                'keluarga' => ['tambah', 'edit', 'soft-delete', 'permanent-delete', 'lihat'],
                'pasien' => ['tambah', 'edit', 'permanent-delete', 'lihat'],
                'poli' => ['tambah', 'edit', 'soft-delete', 'permanent-delete', 'lihat'],
                'spesialis' => ['tambah', 'edit', 'soft-delete', 'permanent-delete', 'lihat'],
                'pegawai' => ['tambah', 'edit', 'soft-delete', 'permanent-delete', 'lihat'],
                'dokter' => ['tambah', 'edit', 'soft-delete', 'permanent-delete', 'lihat'],
                'registrasi' => ['tambah', 'edit', 'permanent-delete', 'lihat'],
            ],
            'dummy' => [
                'provinsi' => ['tambah', 'edit', 'soft-delete', 'permanent-delete', 'lihat'],
            ],
            'rm' => [
                'registrasi' => ['tambah', 'edit', 'permanent-delete', 'lihat'],
            ]
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            foreach ($permissions as $entity => $actions) {
                foreach ($actions as $action) {
                    $permission = Permission::firstOrCreate(['name' => "$action-$entity"]);
                    $role->givePermissionTo($permission);
                }
            }
        }
    }
}
