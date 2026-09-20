<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlotTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Populates the plot_types table with initial data.
     */
    public function run()
    {
        DB::table('plot_types')->insert([
            [
                'id' => 8,
                'name' => 'Empty Plot',
                'amount' => 0,
                'status' => 1,
                'created_at' => '2026-08-17 23:09:57',
                'updated_at' => '2026-08-17 23:09:57'
            ],
            [
                'id' => 9,
                'name' => 'Under Construction',
                'amount' => 1500,
                'status' => 1,
                'created_at' => '2026-08-17 23:10:17',
                'updated_at' => '2026-08-25 05:16:09'
            ],
            [
                'id' => 10,
                'name' => 'Apartment',
                'amount' => 250,
                'status' => 1,
                'created_at' => '2026-08-17 23:10:31',
                'updated_at' => '2026-08-25 05:15:55'
            ],
            [
                'id' => 11,
                'name' => 'Owner Made Building',
                'amount' => 250,
                'status' => 1,
                'created_at' => '2026-08-17 23:10:48',
                'updated_at' => '2026-08-25 05:15:42'
            ],
            [
                'id' => 12,
                'name' => 'Commercial Building',
                'amount' => 1500,
                'status' => 1,
                'created_at' => '2026-08-17 23:11:05',
                'updated_at' => '2026-08-25 05:15:25'
            ],
            [
                'id' => 14,
                'name' => null,
                'amount' => null,
                'status' => 1,
                'created_at' => '2026-09-13 03:57:36',
                'updated_at' => '2026-09-13 03:57:36'
            ]
        ]);
    }
}