<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $superAdmin = Role::create(['name' => 'super_admin', 'guard_name' => 'web']);
        $mahasiswa = Role::create(['name' => 'mahasiswa', 'guard_name' => 'web']);

        // Create permissions
        $permissions = [
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

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Give all permissions to admin and super_admin
        $admin->givePermissionTo($permissions);
        $superAdmin->givePermissionTo($permissions);
    }
} 