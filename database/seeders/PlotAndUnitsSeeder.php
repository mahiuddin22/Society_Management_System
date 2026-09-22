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
                'plot_type_id'    => 1,
                'road_id'         => 1,
                'name'            => 'Md. Rahim Uddin',
                'email'           => 'rahim@example.com',
                'phone'           => '01711111111',
                'unique_id'       => 'PU-100001',
                'holding_no'      => '12/A',
                'total_flat'      => 8,
                'occupied_flat'   => 7,
                'building_name'   => 'Rahim Tower',
                'collection_type' => 'Individual',
                'collection_rate' => 750.00,
                'total_amount'    => 750.00,
                'discount'        => 0.00,
                'status'          => 'Active',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],

            [
                'plot_type_id'    => 1,
                'road_id'         => 1,
                'name'            => 'Md. Karim Hasan',
                'email'           => 'karim@example.com',
                'phone'           => '01822222222',
                'unique_id'       => 'PU-100002',
                'holding_no'      => '12/A',
                'total_flat'      => 8,
                'occupied_flat'   => 7,
                'building_name'   => 'Rahim Tower',
                'collection_type' => 'Individual',
                'collection_rate' => 750.00,
                'total_amount'    => 1500.00,
                'discount'        => 100.00,
                'status'          => 'Active',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],

            [
                'plot_type_id'    => 2,
                'road_id'         => 2,
                'name'            => 'Fatema Khatun',
                'email'           => 'fatema@example.com',
                'phone'           => '01933333333',
                'unique_id'       => 'PU-100003',
                'holding_no'      => '25/B',
                'total_flat'      => 12,
                'occupied_flat'   => 10,
                'building_name'   => 'Fatema Heights',
                'collection_type' => 'Group',
                'collection_rate' => 600.00,
                'total_amount'    => 6000.00,
                'discount'        => 500.00,
                'status'          => 'Active',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],

            [
                'plot_type_id'    => 2,
                'road_id'         => 2,
                'name'            => 'Abdul Mannan',
                'email'           => null,
                'phone'           => '01644444444',
                'unique_id'       => 'PU-100004',
                'holding_no'      => '25/B',
                'total_flat'      => 12,
                'occupied_flat'   => 10,
                'building_name'   => 'Fatema Heights',
                'collection_type' => 'Individual',
                'collection_rate' => 800.00,
                'total_amount'    => 800.00,
                'discount'        => 0.00,
                'status'          => 'Hold',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],

            [
                'plot_type_id'    => 3,
                'road_id'         => 3,
                'name'            => 'Nusrat Jahan',
                'email'           => 'nusrat@example.com',
                'phone'           => '01555555555',
                'unique_id'       => 'PU-100005',
                'holding_no'      => '45',
                'total_flat'      => 20,
                'occupied_flat'   => 18,
                'building_name'   => 'Jahan Palace',
                'collection_type' => 'Group',
                'collection_rate' => 1000.00,
                'total_amount'    => 18000.00,
                'discount'        => 1000.00,
                'status'          => 'Active',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);
    }
}