<?php

namespace Database\Seeders;

use App\Models\RolePermission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];

        $adminPermissions = [
            [24, 'plot_and_units', [1, 2, 3, 4, 5]],
            [31, 'upload_members', [1]],
            [33, 'my_payments', [1, 9, 11]],
            [36, 'payments_report', [1, 9]],
            [37, 'bill_generator', [1, 2, 12]],
            [27, 'collections', [1, 9]],
            [30, 'collectors', [1, 3, 4, 10]],
            [39, 'bulk_sms', [1]],
            [40, 'draft_sms', [1, 2, 3, 4]],
            [41, 'sms_history', [1, 9]],
            [19, 'activities', [1, 2, 3, 4]],
            [21, 'roles', [1, 2, 3, 4]],
            [29, 'roads', [1, 2, 3, 4]],
            [28, 'users', [1, 2, 3, 4]],
            [17, 'permissions', [1, 2, 3, 4, 5, 6]],
            [43, 'role_permission', [1]],
            [44, 'user_permission', [1]],
            [22, 'plot_types', [1, 2, 3, 4, 8]],
            [13, 'site_settings', [1]],
        ];

        $collectorPermissions = [
            [27, 'collections', [1, 8, 9]],
        ];

        $memberPermissions = [
            [33, 'my_payments', [1, 9, 11]],
            [36, 'payments_report', [1, 9]],
        ];

        $permissionGroups = [
            'admin' => [
                'permissions' => $adminPermissions,
                'timestamp' => '2026-10-12 11:46:49',
            ],
            'collector' => [
                'permissions' => $collectorPermissions,
                'timestamp' => '2026-09-16 17:09:25',
            ],
            'member' => [
                'permissions' => $memberPermissions,
                'timestamp' => '2026-09-16 17:25:53',
            ],
        ];

        foreach ($permissionGroups as $role => $group) {
            $now = $group['timestamp'];

            foreach ($group['permissions'] as [$permissionId, $menuKey, $activities]) {
                foreach ($activities as $activityId) {
                    $data[] = [
                        'role' => $role,
                        'user_id' => null,
                        'permission_id' => $permissionId,
                        'activity_id' => $activityId,
                        'menu_key' => $menuKey,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }

        RolePermission::insert($data);
    }
}