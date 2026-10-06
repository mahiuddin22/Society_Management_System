<?php

namespace Database\Seeders;

use App\Models\RolePermission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $now = '2026-09-05 22:46:28';

        $data = [];

        $adminPermissions = [
            [24, 'plot_and_units', [1, 2, 3, 4, 5]],
            [27, 'collections', [1, 3, 4, 8, 9]],
            [30, 'collectors', [1, 3, 4, 10]],
            [19, 'activities', [1, 2, 3, 4]],
            [21, 'roles', [1, 2, 3, 4]],
            [29, 'roads', [1, 2, 3, 4]],
            [28, 'users', [1, 2, 3, 4]],
            [17, 'permissions', [1, 2, 3, 4, 5, 6]],
            [13, 'site_settings', [1]],
            [22, 'plot_types', [1, 2, 3, 4, 8]],
        ];

        foreach ($adminPermissions as [$permissionId, $menuKey, $activities]) {
            foreach ($activities as $activityId) {
                $data[] = [
                    'role' => 'admin',
                    'user_id' => null,
                    'permission_id' => $permissionId,
                    'activity_id' => $activityId,
                    'menu_key' => $menuKey,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        $collectorPermissions = [
            [27, 'collections', [1, 8, 9]],
            [30, 'collectors', [1, 3, 4, 10]],
        ];

        $now = '2026-09-05 23:42:03';

        foreach ($collectorPermissions as [$permissionId, $menuKey, $activities]) {
            foreach ($activities as $activityId) {
                $data[] = [
                    'role' => 'collector',
                    'user_id' => null,
                    'permission_id' => $permissionId,
                    'activity_id' => $activityId,
                    'menu_key' => $menuKey,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        $moderatorPermissions = [
            [27, 'collections', [1, 3, 4, 8, 9]],
            [30, 'collectors', [1, 3, 4, 10]],
            [19, 'activities', [1, 2, 3, 4]],
            [21, 'roles', [1, 2, 3, 4]],
            [29, 'roads', [1, 2, 3, 4]],
            [28, 'users', [1, 2, 3, 4]],
            [17, 'permissions', [1, 2, 3, 4, 5, 6]],
            [24, 'plot_and_units', [1, 2, 3, 4, 5]],
            [31, 'upload_members', [1]],
            [13, 'site_settings', [1]],
            [22, 'plot_types', [1, 2, 3, 4, 8]],
            [33, 'my_payments', [1, 9, 11]],
            [36, 'payments_report', [1, 9]],
        ];

        $now = '2026-09-28 06:49:15';

        foreach ($moderatorPermissions as [$permissionId, $menuKey, $activities]) {
            foreach ($activities as $activityId) {
                $data[] = [
                    'role' => 'moderator',
                    'user_id' => null,
                    'permission_id' => $permissionId,
                    'activity_id' => $activityId,
                    'menu_key' => $menuKey,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        RolePermission::insert($data);
    }
}