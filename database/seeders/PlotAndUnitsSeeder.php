<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlotAndUnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Populates the plot_and_units table with initial data.
     */
    public function run()
    {
        DB::table('plot_and_units')->insert([
            [
                'id' => 14,
                'unique_id' => 'UT0361/A1410',
                'road' => 6,
                'holding_no' => '1/A',
                'building_type' => 10,
                'total_flat' => 10,
                'occupied_flat' => 8,
                'building_name' => 'Amicus',
                'collection_type' => 'Group',
                'collection_rate' => 250,
                'collection_amount' => 1500,
                'discount' => 500,
                'date' => '2026-09-11',
                'status' => 1,
                'name' => 'Ex Name',
                'flat_no' => 01,
                'number' => 8801234567890,
                'email' => 'test@example.com',
                'payment_status' => 1,
                'payment_date' => '2026-09-16',
                'created_at' => '2026-09-10 12:26:35',
                'updated_at' => '2026-09-16 05:07:53'
            ],
            [
                'id' => 59,
                'unique_id' => 'UT0371/B590',
                'road' => 7,
                'holding_no' => '1/B',
                'building_type' => 9,
                'total_flat' => 0,
                'occupied_flat' => 0,
                'building_name' => 'Nanadan kanon Haousing',
                'collection_type' => 'Individual',
                'collection_rate' => 1500,
                'collection_amount' => 1000,
                'discount' => 500,
                'date' => '2026-09-02',
                'status' => 1,
                'name' => 'Aminul Haque',
                'flat_no' => 02,
                'number' => 8801970247545,
                'email' => 'aminul_h@live.com',
                'payment_status' => 0,
                'payment_date' => null,
                'created_at' => '2026-09-13 04:06:53',
                'updated_at' => '2026-09-15 01:56:38'
            ],
            [
                'id' => 60,
                'unique_id' => 'UT0392/C6012',
                'road' => 9,
                'holding_no' => '2/C',
                'building_type' => 10,
                'total_flat' => 12,
                'occupied_flat' => 10,
                'building_name' => 'Kolmi lata Housing',
                'collection_type' => 'Group',
                'collection_rate' => 250,
                'collection_amount' => 2500,
                'discount' => 0,
                'date' => '2026-09-03',
                'status' => 1,
                'name' => 'Rasel Miah',
                'flat_no' => 01,
                'number' => 8801330563459,
                'email' => 'rasel@dev.com',
                'payment_status' => 1,
                'payment_date' => '2026-09-14',
                'created_at' => '2026-09-13 04:06:53',
                'updated_at' => '2026-09-15 02:03:26'
            ]
        ]);
    }
}