<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoadsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roads')->insert([
            [
                'id' => 1,
                'collector_id' => 10,
                'number' => '01',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'collector_id' => 10,
                'number' => '02',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 3,
                'collector_id' => 10,
                'number' => '03',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 4,
                'collector_id' => 10,
                'number' => '04',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 5,
                'collector_id' => 10,
                'number' => '05',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 6,
                'collector_id' => 10,
                'number' => '06',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 7,
                'collector_id' => 10,
                'number' => '07',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 8,
                'collector_id' => 10,
                'number' => '07/A',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 9,
                'collector_id' => 10,
                'number' => '07/B',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 10,
                'collector_id' => 10,
                'number' => '07/C',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 11,
                'collector_id' => 10,
                'number' => '08',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 12,
                'collector_id' => 10,
                'number' => '09',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 13,
                'collector_id' => 10,
                'number' => '10',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 14,
                'collector_id' => null,
                'number' => '11',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 15,
                'collector_id' => null,
                'number' => '12',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 16,
                'collector_id' => null,
                'number' => '13',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 17,
                'collector_id' => null,
                'number' => '13/A',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 18,
                'collector_id' => null,
                'number' => '13/B',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 19,
                'collector_id' => null,
                'number' => '14',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 20,
                'collector_id' => null,
                'number' => '15',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 21,
                'collector_id' => null,
                'number' => '16',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 22,
                'collector_id' => null,
                'number' => '17',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 23,
                'collector_id' => null,
                'number' => '18',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 24,
                'collector_id' => null,
                'number' => '19',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 25,
                'collector_id' => null,
                'number' => '20',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
