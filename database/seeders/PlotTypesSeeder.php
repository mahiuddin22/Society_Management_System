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
                'id' => 1,
                'name' => 'Empty Plot',
                'slug' => 'empty-plot',
                'fees' => 0,
                'status' => 'Active',
            ],
            [
                'id' => 2,
                'name' => 'Under Construction',
                'slug' => 'under-construction',
                'fees' => 1500,
                'status' => 'Active',
            ],
            [
                'id' => 3,
                'name' => 'Apartment',
                'slug' => 'apartment',
                'fees' => 250,
                'status' => 'Active',
            ],
            [
                'id' => 4,
                'name' => 'Owner Made Building',
                'slug' => 'owner-building',
                'fees' => 250,
                'status' => 'Active',
            ],
            [
                'id' => 5,
                'name' => 'Commercial Building',
                'slug' => 'commercial-building',
                'fees' => 1500,
                'status' => 'Active',
            ]
        ]);
    }
}