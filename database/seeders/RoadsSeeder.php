<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Populates the roads table with initial data.
     */
    public function run()
    {
        DB::table('roads')->insert([
            [
                'id' => 3,
                'collector_id' => 10,
                'name' => 'Road 01',
                'created_at' => '2026-09-03 03:42:09',
                'updated_at' => '2026-09-06 03:12:12'
            ],
            [
                'id' => 4,
                'collector_id' => 10,
                'name' => 'Road 02',
                'created_at' => '2026-09-03 03:45:35',
                'updated_at' => '2026-09-06 03:12:12'
            ],
            [
                'id' => 5,
                'collector_id' => 10,
                'name' => 'Road 03',
                'created_at' => '2026-09-03 03:45:42',
                'updated_at' => '2026-09-06 03:12:12'
            ],
            [
                'id' => 6,
                'collector_id' => 10,
                'name' => 'Road 04',
                'created_at' => '2026-09-03 03:45:48',
                'updated_at' => '2026-09-06 03:12:12'
            ],
            [
                'id' => 7,
                'collector_id' => 10,
                'name' => 'Road 05',
                'created_at' => '2026-09-03 03:45:54',
                'updated_at' => '2026-09-06 03:12:12'
            ],
            [
                'id' => 8,
                'collector_id' => 9,
                'name' => 'Road 06',
                'created_at' => '2026-09-03 03:46:06',
                'updated_at' => '2026-09-06 03:12:37'
            ],
            [
                'id' => 9,
                'collector_id' => 9,
                'name' => 'Road 07',
                'created_at' => '2026-09-03 03:46:28',
                'updated_at' => '2026-09-06 03:12:37'
            ],
            [
                'id' => 10,
                'collector_id' => 9,
                'name' => 'Road 07-A',
                'created_at' => '2026-09-03 03:56:19',
                'updated_at' => '2026-09-06 03:12:37'
            ],
            [
                'id' => 11,
                'collector_id' => 9,
                'name' => 'Road 07-B',
                'created_at' => '2026-09-03 03:56:24',
                'updated_at' => '2026-09-06 03:12:37'
            ],
            [
                'id' => 12,
                'collector_id' => 9,
                'name' => 'Road 07-C',
                'created_at' => '2026-09-03 03:56:31',
                'updated_at' => '2026-09-06 03:12:37'
            ],
            [
                'id' => 13,
                'collector_id' => 9,
                'name' => 'Road 08',
                'created_at' => '2026-09-03 03:46:36',
                'updated_at' => '2026-09-06 03:12:37'
            ],
            [
                'id' => 14,
                'collector_id' => 9,
                'name' => 'Road 09',
                'created_at' => '2026-09-03 03:46:43',
                'updated_at' => '2026-09-06 03:12:37'
            ],
            [
                'id' => 15,
                'collector_id' => 9,
                'name' => 'Road 10',
                'created_at' => '2026-09-03 03:46:53',
                'updated_at' => '2026-09-06 03:12:37'
            ],
            [
                'id' => 16,
                'collector_id' => null,
                'name' => 'Road 11',
                'created_at' => '2026-09-03 03:47:04',
                'updated_at' => '2026-09-03 03:47:04'
            ],
            [
                'id' => 17,
                'collector_id' => null,
                'name' => 'Road 12',
                'created_at' => '2026-09-03 03:48:23',
                'updated_at' => '2026-09-03 03:48:23'
            ],
            [
                'id' => 18,
                'collector_id' => null,
                'name' => 'Road 13',
                'created_at' => '2026-09-03 03:48:28',
                'updated_at' => '2026-09-03 03:48:28'
            ],
            [
                'id' => 19,
                'collector_id' => null,
                'name' => 'Road 13-A',
                'created_at' => '2026-09-03 03:50:23',
                'updated_at' => '2026-09-03 03:50:23'
            ],
            [
                'id' => 20,
                'collector_id' => null,
                'name' => 'Road 13-B',
                'created_at' => '2026-09-03 03:50:33',
                'updated_at' => '2026-09-03 03:50:33'
            ],
            [
                'id' => 21,
                'collector_id' => null,
                'name' => 'Road 14',
                'created_at' => '2026-09-03 03:48:34',
                'updated_at' => '2026-09-03 03:48:34'
            ],
            [
                'id' => 22,
                'collector_id' => null,
                'name' => 'Road 15',
                'created_at' => '2026-09-03 03:52:59',
                'updated_at' => '2026-09-03 03:52:59'
            ],
            [
                'id' => 23,
                'collector_id' => null,
                'name' => 'Road 16',
                'created_at' => '2026-09-03 03:53:09',
                'updated_at' => '2026-09-03 03:53:09'
            ],
            [
                'id' => 24,
                'collector_id' => null,
                'name' => 'Road 17',
                'created_at' => '2026-09-03 03:54:40',
                'updated_at' => '2026-09-03 03:54:40'
            ],
            [
                'id' => 25,
                'collector_id' => null,
                'name' => 'Road 18',
                'created_at' => '2026-09-03 03:54:44',
                'updated_at' => '2026-09-03 03:54:44'
            ],
            [
                'id' => 26,
                'collector_id' => null,
                'name' => 'Road 19',
                'created_at' => '2026-09-03 03:54:49',
                'updated_at' => '2026-09-03 03:54:49'
            ],
            [
                'id' => 27,
                'collector_id' => null,
                'name' => 'Road 20',
                'created_at' => '2026-09-03 03:54:56',
                'updated_at' => '2026-09-03 03:54:56'
            ],
            [
                'id' => 1118,
                'collector_id' => null,
                'name' => null,
                'created_at' => '2026-09-13 03:57:36',
                'updated_at' => '2026-09-13 03:57:36'
            ]
        ]);
    }
}