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
                'collector_id' => 10,
                'number' => '01',
            ],
            [
                'collector_id' => 10,
                'number' => '02',
            ],
            [
                'collector_id' => 10,
                'number' => '03',
            ],
            [
                'collector_id' => 10,
                'number' => '04',
            ],
            [
                'collector_id' => 10,
                'number' => '05'
            ],
            [
                'collector_id' => 10,
                'number' => '06'
            ],
            [
                'collector_id' => 10,
                'number' => '07'
            ],
            [
                'collector_id' => 10,
                'number' => '07/A'
            ],
            [
                'collector_id' => 10,
                'number' => '07/B'
            ],
            [
                'collector_id' => 10,
                'number' => '07/C'
            ],
            [
                'collector_id' => 10,
                'number' => '08'
            ],
            [
                'collector_id' => 10,
                'number' => '09'
            ],
            [
                'collector_id' => 10,
                'number' => '10',
            ],
            [
                'collector_id' => null,
                'number' => '11'
            ],
            [
                'collector_id' => null,
                'number' => '12'
            ],
            [
                'collector_id' => null,
                'number' => '13'
            ],
            [
                'collector_id' => null,
                'number' => '13/A'
            ],
            [
                'collector_id' => null,
                'number' => '13/B'
            ],
            [
                'collector_id' => null,
                'number' => '14'
            ],
            [
                'collector_id' => null,
                'number' => '15'
            ],
            [
                'collector_id' => null,
                'number' => '16'
            ],
            [
                'collector_id' => null,
                'number' => '17'
            ],
            [
                'collector_id' => null,
                'number' => '18'
            ],
            [
                'collector_id' => null,
                'number' => '19'
            ],
            [
                'collector_id' => null,
                'number' => '20'
            ],
        ]);
    }
}