<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Populates the role_permissions table with initial data.
     */
    public function run()
    {
        DB::table('role_permissions')->insert([
            [
                'id' => 1563,
                'role' => 'collector',
                'user_id' => null,
                'permission_id' => 27,
                'activity_id' => 1,
                'menu_key' => 'collections',
                'created_at' => '2026-09-16 23:09:25',
                'updated_at' => '2026-09-16 23:09:25'
            ],
            [
                'id' => 1564,
                'role' => 'collector',
                'user_id' => null,
                'permission_id' => 27,
                'activity_id' => 8,
                'menu_key' => 'collections',
                'created_at' => '2026-09-16 23:09:25',
                'updated_at' => '2026-09-16 23:09:25'
            ],
            [
                'id' => 1565,
                'role' => 'collector',
                'user_id' => null,
                'permission_id' => 27,
                'activity_id' => 9,
                'menu_key' => 'collections',
                'created_at' => '2026-09-16 23:09:25',
                'updated_at' => '2026-09-16 23:09:25'
            ],
            [
                'id' => 1575,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 24,
                'activity_id' => 1,
                'menu_key' => 'plot_and_units',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1576,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 24,
                'activity_id' => 2,
                'menu_key' => 'plot_and_units',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1577,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 24,
                'activity_id' => 3,
                'menu_key' => 'plot_and_units',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1578,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 24,
                'activity_id' => 4,
                'menu_key' => 'plot_and_units',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1579,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 24,
                'activity_id' => 5,
                'menu_key' => 'plot_and_units',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1580,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 31,
                'activity_id' => 1,
                'menu_key' => 'upload_members',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1581,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 33,
                'activity_id' => 1,
                'menu_key' => 'my_payments',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1582,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 33,
                'activity_id' => 9,
                'menu_key' => 'my_payments',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1583,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 33,
                'activity_id' => 11,
                'menu_key' => 'my_payments',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1584,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 36,
                'activity_id' => 1,
                'menu_key' => 'payments_report',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1585,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 36,
                'activity_id' => 9,
                'menu_key' => 'payments_report',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1586,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 27,
                'activity_id' => 1,
                'menu_key' => 'collections',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1587,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 27,
                'activity_id' => 3,
                'menu_key' => 'collections',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1588,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 27,
                'activity_id' => 4,
                'menu_key' => 'collections',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1589,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 27,
                'activity_id' => 8,
                'menu_key' => 'collections',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1590,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 27,
                'activity_id' => 9,
                'menu_key' => 'collections',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1591,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 30,
                'activity_id' => 1,
                'menu_key' => 'collectors',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1592,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 30,
                'activity_id' => 3,
                'menu_key' => 'collectors',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1593,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 30,
                'activity_id' => 4,
                'menu_key' => 'collectors',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1594,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 30,
                'activity_id' => 10,
                'menu_key' => 'collectors',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1595,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 19,
                'activity_id' => 1,
                'menu_key' => 'activities',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1596,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 19,
                'activity_id' => 2,
                'menu_key' => 'activities',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1597,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 19,
                'activity_id' => 3,
                'menu_key' => 'activities',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1598,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 19,
                'activity_id' => 4,
                'menu_key' => 'activities',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1599,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 21,
                'activity_id' => 1,
                'menu_key' => 'roles',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1600,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 21,
                'activity_id' => 2,
                'menu_key' => 'roles',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1601,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 21,
                'activity_id' => 3,
                'menu_key' => 'roles',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1602,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 21,
                'activity_id' => 4,
                'menu_key' => 'roles',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1603,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 29,
                'activity_id' => 1,
                'menu_key' => 'roads',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1604,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 29,
                'activity_id' => 2,
                'menu_key' => 'roads',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1605,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 29,
                'activity_id' => 3,
                'menu_key' => 'roads',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1606,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 29,
                'activity_id' => 4,
                'menu_key' => 'roads',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1607,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 28,
                'activity_id' => 1,
                'menu_key' => 'users',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1608,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 28,
                'activity_id' => 2,
                'menu_key' => 'users',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1609,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 28,
                'activity_id' => 3,
                'menu_key' => 'users',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1610,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 28,
                'activity_id' => 4,
                'menu_key' => 'users',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1611,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 17,
                'activity_id' => 1,
                'menu_key' => 'permissions',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1612,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 17,
                'activity_id' => 2,
                'menu_key' => 'permissions',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1613,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 17,
                'activity_id' => 3,
                'menu_key' => 'permissions',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1614,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 17,
                'activity_id' => 4,
                'menu_key' => 'permissions',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1615,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 17,
                'activity_id' => 5,
                'menu_key' => 'permissions',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1616,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 17,
                'activity_id' => 6,
                'menu_key' => 'permissions',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1617,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 13,
                'activity_id' => 1,
                'menu_key' => 'site_settings',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1618,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 22,
                'activity_id' => 1,
                'menu_key' => 'plot_types',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1619,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 22,
                'activity_id' => 2,
                'menu_key' => 'plot_types',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1620,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 22,
                'activity_id' => 3,
                'menu_key' => 'plot_types',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1621,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 22,
                'activity_id' => 4,
                'menu_key' => 'plot_types',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1622,
                'role' => 'admin',
                'user_id' => null,
                'permission_id' => 22,
                'activity_id' => 8,
                'menu_key' => 'plot_types',
                'created_at' => '2026-09-16 23:24:09',
                'updated_at' => '2026-09-16 23:24:09'
            ],
            [
                'id' => 1623,
                'role' => 'member',
                'user_id' => null,
                'permission_id' => 33,
                'activity_id' => 1,
                'menu_key' => 'my_payments',
                'created_at' => '2026-09-16 23:25:53',
                'updated_at' => '2026-09-16 23:25:53'
            ],
            [
                'id' => 1624,
                'role' => 'member',
                'user_id' => null,
                'permission_id' => 33,
                'activity_id' => 9,
                'menu_key' => 'my_payments',
                'created_at' => '2026-09-16 23:25:53',
                'updated_at' => '2026-09-16 23:25:53'
            ],
            [
                'id' => 1625,
                'role' => 'member',
                'user_id' => null,
                'permission_id' => 33,
                'activity_id' => 11,
                'menu_key' => 'my_payments',
                'created_at' => '2026-09-16 23:25:53',
                'updated_at' => '2026-09-16 23:25:53'
            ],
            [
                'id' => 1626,
                'role' => 'member',
                'user_id' => null,
                'permission_id' => 36,
                'activity_id' => 1,
                'menu_key' => 'payments_report',
                'created_at' => '2026-09-16 23:25:53',
                'updated_at' => '2026-09-16 23:25:53'
            ],
            [
                'id' => 1627,
                'role' => 'member',
                'user_id' => null,
                'permission_id' => 36,
                'activity_id' => 9,
                'menu_key' => 'payments_report',
                'created_at' => '2026-09-16 23:25:53',
                'updated_at' => '2026-09-16 23:25:53'
            ]
        ]);
    }
}