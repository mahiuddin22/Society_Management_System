<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Populates the permissions table with initial data.
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'id' => 12,
                'name' => 'Settings',
                'menu_type' => 'main_menu',
                'menu_key' => null,
                'order_no' => 16,
                'activity_id' => null,
                'created_at' => '2026-07-30 02:15:32',
                'updated_at' => '2026-09-16 23:01:33'
            ],
            [
                'id' => 13,
                'name' => 'Site Settings',
                'menu_type' => 'sub_menu',
                'menu_key' => 'site_settings',
                'order_no' => 17,
                'activity_id' => 1,
                'created_at' => '2026-07-30 02:16:34',
                'updated_at' => '2026-09-16 23:01:33'
            ],
            [
                'id' => 17,
                'name' => 'Permissions',
                'menu_type' => 'sub_menu',
                'menu_key' => 'permissions',
                'order_no' => 15,
                'activity_id' => '1,2,3,4,5,6',
                'created_at' => '2026-07-30 04:02:41',
                'updated_at' => '2026-09-16 23:01:33'
            ],
            [
                'id' => 19,
                'name' => 'Activities',
                'menu_type' => 'sub_menu',
                'menu_key' => 'activities',
                'order_no' => 11,
                'activity_id' => '1,2,3,4',
                'created_at' => '2026-08-16 04:27:19',
                'updated_at' => '2026-09-16 23:01:33'
            ],
            [
                'id' => 20,
                'name' => 'Administrations',
                'menu_type' => 'main_menu',
                'menu_key' => null,
                'order_no' => 10,
                'activity_id' => null,
                'created_at' => '2026-08-16 04:30:35',
                'updated_at' => '2026-09-16 23:01:33'
            ],
            [
                'id' => 21,
                'name' => 'Roles',
                'menu_type' => 'sub_menu',
                'menu_key' => 'roles',
                'order_no' => 12,
                'activity_id' => '1,2,3,4',
                'created_at' => '2026-08-16 04:32:42',
                'updated_at' => '2026-09-16 23:01:33'
            ],
            [
                'id' => 22,
                'name' => 'Plot Types',
                'menu_type' => 'sub_menu',
                'menu_key' => 'plot_types',
                'order_no' => 18,
                'activity_id' => '1,2,3,4,8',
                'created_at' => '2026-08-18 01:00:57',
                'updated_at' => '2026-09-16 23:01:33'
            ],
            [
                'id' => 23,
                'name' => 'People',
                'menu_type' => 'main_menu',
                'menu_key' => null,
                'order_no' => 1,
                'activity_id' => null,
                'created_at' => '2026-08-18 01:02:23',
                'updated_at' => '2026-09-16 23:01:33'
            ],
            [
                'id' => 24,
                'name' => 'Plot And Units',
                'menu_type' => 'sub_menu',
                'menu_key' => 'plot_and_units',
                'order_no' => 2,
                'activity_id' => '1,2,3,4,5',
                'created_at' => '2026-08-18 01:03:04',
                'updated_at' => '2026-09-16 23:01:33'
            ],
            [
                'id' => 25,
                'name' => 'Collection Management',
                'menu_type' => 'main_menu',
                'menu_key' => null,
                'order_no' => 7,
                'activity_id' => null,
                'created_at' => '2026-08-18 01:03:38',
                'updated_at' => '2026-09-16 23:01:33'
            ],
            [
                'id' => 27,
                'name' => 'Collections',
                'menu_type' => 'sub_menu',
                'menu_key' => 'collections',
                'order_no' => 8,
                'activity_id' => '1,3,4,8,9',
                'created_at' => '2026-08-19 02:38:56',
                'updated_at' => '2026-09-16 23:01:33'
            ],
            [
                'id' => 28,
                'name' => 'Users',
                'menu_type' => 'sub_menu',
                'menu_key' => 'users',
                'order_no' => 14,
                'activity_id' => '1,2,3,4',
                'created_at' => '2026-09-01 23:23:24',
                'updated_at' => '2026-09-16 23:01:33'
            ],
            [
                'id' => 29,
                'name' => 'Roads',
                'menu_type' => 'sub_menu',
                'menu_key' => 'roads',
                'order_no' => 13,
                'activity_id' => '1,2,3,4',
                'created_at' => '2026-09-03 03:37:44',
                'updated_at' => '2026-09-16 23:01:33'
            ],
            [
                'id' => 30,
                'name' => 'Collectors',
                'menu_type' => 'sub_menu',
                'menu_key' => 'collectors',
                'order_no' => 9,
                'activity_id' => '1,3,4,10',
                'created_at' => '2026-09-06 04:38:17',
                'updated_at' => '2026-09-16 23:01:33'
            ],
            [
                'id' => 31,
                'name' => 'Upoad Members',
                'menu_type' => 'sub_menu',
                'menu_key' => 'upload_members',
                'order_no' => 3,
                'activity_id' => 1,
                'created_at' => '2026-09-16 02:49:18',
                'updated_at' => '2026-09-16 23:01:33'
            ],
            [
                'id' => 32,
                'name' => 'Payment Management',
                'menu_type' => 'main_menu',
                'menu_key' => null,
                'order_no' => 4,
                'activity_id' => null,
                'created_at' => '2026-09-16 22:42:35',
                'updated_at' => '2026-09-16 23:01:33'
            ],
            [
                'id' => 33,
                'name' => 'My Payments',
                'menu_type' => 'sub_menu',
                'menu_key' => 'my_payments',
                'order_no' => 5,
                'activity_id' => '1,9,11',
                'created_at' => '2026-09-16 22:46:21',
                'updated_at' => '2026-09-16 23:23:29'
            ],
            [
                'id' => 36,
                'name' => 'Payments Report',
                'menu_type' => 'sub_menu',
                'menu_key' => 'payments_report',
                'order_no' => 6,
                'activity_id' => '1,9',
                'created_at' => '2026-09-16 23:01:27',
                'updated_at' => '2026-09-16 23:01:33'
            ]
        ]);
    }
}