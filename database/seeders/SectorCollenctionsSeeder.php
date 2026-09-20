<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectorCollenctionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Populates the sector_collenctions table with initial data.
     */
    public function run()
    {
        DB::table('sector_collenctions')->insert([
            [
                'id' => 1,
                'unique_id' => 'UT0365410',
                'road_id' => 6,
                'holding_no' => 54,
                'plot_and_unit_id' => 4,
                'member_id' => 9,
                'flat_no' => 10,
                'number' => '01234567890',
                'email' => 'test@test.com',
                'amount' => 1000,
                'payment_status' => 0,
                'payment_date' => null,
                'created_at' => '2026-09-07 23:58:11',
                'updated_at' => '2026-09-08 02:16:23'
            ],
            [
                'id' => 2,
                'unique_id' => 'UT0365411',
                'road_id' => 6,
                'holding_no' => 54,
                'plot_and_unit_id' => 4,
                'member_id' => 9,
                'flat_no' => 11,
                'number' => '01234567812',
                'email' => 'test2@test.com',
                'amount' => 1000,
                'payment_status' => 1,
                'payment_date' => '2026-09-08',
                'created_at' => '2026-09-07 23:58:11',
                'updated_at' => '2026-09-08 02:16:23'
            ],
            [
                'id' => 3,
                'unique_id' => 'UT03100515',
                'road_id' => 10,
                'holding_no' => 05,
                'plot_and_unit_id' => 3,
                'member_id' => 10,
                'flat_no' => 15,
                'number' => '01234567834',
                'email' => 'rakib@gmail.com',
                'amount' => 1500,
                'payment_status' => 0,
                'payment_date' => null,
                'created_at' => '2026-09-08 02:35:06',
                'updated_at' => '2026-09-08 02:35:06'
            ],
            [
                'id' => 4,
                'unique_id' => 'UT03100516',
                'road_id' => 10,
                'holding_no' => 05,
                'plot_and_unit_id' => 3,
                'member_id' => 11,
                'flat_no' => 16,
                'number' => '012345678335',
                'email' => 'sadia@gmail.com',
                'amount' => 1500,
                'payment_status' => 0,
                'payment_date' => null,
                'created_at' => '2026-09-08 02:35:06',
                'updated_at' => '2026-09-08 02:35:06'
            ],
            [
                'id' => 5,
                'unique_id' => 'UT03100517',
                'road_id' => 10,
                'holding_no' => 05,
                'plot_and_unit_id' => 3,
                'member_id' => 12,
                'flat_no' => 17,
                'number' => '01234567836',
                'email' => 'ranvir@gmail.com',
                'amount' => 1500,
                'payment_status' => 0,
                'payment_date' => null,
                'created_at' => '2026-09-08 02:35:06',
                'updated_at' => '2026-09-08 02:35:06'
            ],
            [
                'id' => 20,
                'unique_id' => 'UT03834122020',
                'road_id' => 8,
                'holding_no' => 34,
                'plot_and_unit_id' => 12,
                'member_id' => 24,
                'flat_no' => 11,
                'number' => '8801710872443',
                'email' => 'naeem@example.com',
                'amount' => 2500,
                'payment_status' => 0,
                'payment_date' => null,
                'created_at' => '2026-09-09 03:53:31',
                'updated_at' => '2026-09-09 03:53:39'
            ],
            [
                'id' => 21,
                'unique_id' => 'UT03834122021',
                'road_id' => 8,
                'holding_no' => 34,
                'plot_and_unit_id' => 12,
                'member_id' => 23,
                'flat_no' => 10,
                'number' => '8801610440622',
                'email' => 'mahiuddin@example.com',
                'amount' => 2500,
                'payment_status' => 0,
                'payment_date' => null,
                'created_at' => '2026-09-09 03:53:39',
                'updated_at' => '2026-09-09 03:53:47'
            ]
        ]);
    }
}