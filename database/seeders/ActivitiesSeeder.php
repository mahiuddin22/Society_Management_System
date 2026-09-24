<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Populates the activities table with initial data.
     */
    public function run()
    {
        DB::table('activities')->insert([
            [
                'id' => 1,
                'name' => 'Access',
                'activity_key' => 'access',
                'created_at' => '2025-08-08 12:48:56',
                'updated_at' => '2025-08-08 12:48:56'
            ],
            [
                'id' => 2,
                'name' => 'Create',
                'activity_key' => 'create',
                'created_at' => '2025-08-08 06:29:27',
                'updated_at' => '2025-08-08 13:07:08'
            ],
            [
                'id' => 3,
                'name' => 'Edit',
                'activity_key' => 'edit',
                'created_at' => '2025-08-08 12:58:43',
                'updated_at' => '2025-08-08 12:58:43'
            ],
            [
                'id' => 4,
                'name' => 'Delete',
                'activity_key' => 'delete',
                'created_at' => '2025-08-08 14:16:10',
                'updated_at' => '2025-08-08 14:16:10'
            ],
            [
                'id' => 5,
                'name' => 'View',
                'activity_key' => 'view',
                'created_at' => '2025-08-09 06:31:21',
                'updated_at' => '2025-08-09 06:31:21'
            ],
            [
                'id' => 6,
                'name' => 'Move',
                'activity_key' => 'move',
                'created_at' => '2025-08-09 13:06:29',
                'updated_at' => '2025-08-09 13:06:29'
            ],
            [
                'id' => 8,
                'name' => 'Change Status',
                'activity_key' => 'change_status',
                'created_at' => '2026-08-18 00:59:15',
                'updated_at' => '2026-08-18 00:59:15'
            ],
            [
                'id' => 9,
                'name' => 'Download',
                'activity_key' => 'download',
                'created_at' => '2026-08-19 02:35:03',
                'updated_at' => '2026-08-19 02:35:03'
            ],
            [
                'id' => 10,
                'name' => 'Assign',
                'activity_key' => 'assign',
                'created_at' => '2026-09-06 04:41:49',
                'updated_at' => '2026-09-06 04:41:49'
            ],
            [
                'id' => 11,
                'name' => 'Pay',
                'activity_key' => 'pay',
                'created_at' => '2026-09-16 22:46:01',
                'updated_at' => '2026-09-16 22:46:01'
            ]
        ]);
    }
}