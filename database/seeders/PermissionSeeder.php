<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus semua data yang terkait dengan permission dan role
        DB::table('model_has_permissions')->delete();
        DB::table('model_has_roles')->delete();
        DB::table('role_has_permissions')->delete();
        DB::table('permissions')->delete();
        DB::table('roles')->delete();

        // Permission untuk Parameter
        $parameterPermissions = [
            'view_any_parameter',
            'view_parameter',
            'create_parameter',
            'update_parameter',
            'delete_parameter',
            'delete_any_parameter',
            'force_delete_parameter',
            'force_delete_any_parameter',
            'restore_parameter',
            'restore_any_parameter',
            'replicate_parameter',
            'reorder_parameter'
        ];

        // Permission untuk Hasil
        $hasilPermissions = [
            'view_any_hasil',
            'view_hasil',
            'create_hasil',
            'update_hasil',
            'delete_hasil',
            'delete_any_hasil',
            'force_delete_hasil',
            'force_delete_any_hasil',
            'restore_hasil',
            'restore_any_hasil',
            'replicate_hasil',
            'reorder_hasil'
        ];

        // Permission untuk Pengumuman
        $pengumumanPermissions = [
            'view_any_pengumuman',
            'view_pengumuman',
            'create_pengumuman',
            'update_pengumuman',
            'delete_pengumuman',
            'delete_any_pengumuman',
            'force_delete_pengumuman',
            'force_delete_any_pengumuman',
            'restore_pengumuman',
            'restore_any_pengumuman',
            'replicate_pengumuman',
            'reorder_pengumuman'
        ];

        // Permission untuk Mahasiswa
        $mahasiswaPermissions = [
            'view_any_mahasiswa',
            'view_mahasiswa',
            'create_mahasiswa',
            'update_mahasiswa',
            'delete_mahasiswa',
            'delete_any_mahasiswa',
            'force_delete_mahasiswa',
            'force_delete_any_mahasiswa',
            'restore_mahasiswa',
            'restore_any_mahasiswa',
            'replicate_mahasiswa',
            'reorder_mahasiswa'
        ];

        // Permission untuk Kriteria
        $kriteriaPermissions = [
            'view_any_kriteria',
            'view_kriteria',
            'create_kriteria',
            'update_kriteria',
            'delete_kriteria',
            'delete_any_kriteria',
            'force_delete_kriteria',
            'force_delete_any_kriteria',
            'restore_kriteria',
            'restore_any_kriteria',
            'replicate_kriteria',
            'reorder_kriteria'
        ];

        // Permission untuk SubKriteria
        $subKriteriaPermissions = [
            'view_any_subkriteria',
            'view_subkriteria',
            'create_subkriteria',
            'update_subkriteria',
            'delete_subkriteria',
            'delete_any_subkriteria',
            'force_delete_subkriteria',
            'force_delete_any_subkriteria',
            'restore_subkriteria',
            'restore_any_subkriteria',
            'replicate_subkriteria',
            'reorder_subkriteria'
        ];

        // Gabungkan semua permission
        $allPermissions = array_merge(
            $parameterPermissions,
            $hasilPermissions,
            $pengumumanPermissions,
            $mahasiswaPermissions,
            $kriteriaPermissions,
            $subKriteriaPermissions
        );

        // Buat permission
        foreach ($allPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Buat role Super Admin dan berikan semua permission
        $superAdmin = Role::create(['name' => 'super_admin']);
        $superAdmin->syncPermissions($allPermissions);

        // Buat role Admin dan berikan permission yang diperlukan
        $admin = Role::create(['name' => 'admin']);
        $admin->syncPermissions(array_merge(
            $parameterPermissions,
            $hasilPermissions,
            $pengumumanPermissions
        ));

        // Buat role Mahasiswa dan berikan permission yang diperlukan
        $mahasiswa = Role::create(['name' => 'mahasiswa']);
        $mahasiswa->syncPermissions($pengumumanPermissions);
    }
}