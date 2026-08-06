<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'view_dashboard',
            'manage_users',
            'view_reports',
            'settings_menu',
        ];

        foreach ($permissions as $perm) {
            DB::table('permissions')->updateOrInsert(['name' => $perm]);
        }

        // Optional: assign all permissions to admin
        $adminRole = 'admin';
        $permissionIds = DB::table('permissions')->pluck('id');

        foreach ($permissionIds as $pid) {
            DB::table('role_permissions')->updateOrInsert([
                'role' => $adminRole,
                'permission_id' => $pid
            ]);
        }
    }
}
