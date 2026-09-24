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
                'description' => 'Vacant ground awaiting building development',
                'fees' => 0,
                'status' => 'Active',
            ],
            [
                'id' => 2,
                'name' => 'Under Construction',
                'slug' => 'under-construction',
                'description' => 'Ongoing site development in progress',
                'fees' => 1500,
                'status' => 'Active',
            ],
            [
                'id' => 3,
                'name' => 'Apartment',
                'slug' => 'apartment',
                'description' => 'Multi-unit residential society housing space',
                'fees' => 250,
                'status' => 'Active',
            ],
            [
                'id' => 4,
                'name' => 'Owner',
                'slug' => 'owner',
                'description' => 'Private residence occupied by owner',
                'fees' => 250,
                'status' => 'Active',
            ],
            [
                'id' => 5,
                'name' => 'Commercial',
                'slug' => 'commercial',
                'description' => 'Dedicated space for business operations',
                'fees' => 1500,
                'status' => 'Active',
            ]
        ]);
    }
}