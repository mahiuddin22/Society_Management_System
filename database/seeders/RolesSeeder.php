<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Populates the roles table with initial data.
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'admin',
                'created_at' => '2025-08-12 13:37:14',
                'updated_at' => '2025-08-12 13:45:45'
            ],
            [
                'id' => 5,
                'name' => 'collector',
                'created_at' => '2026-09-01 22:45:40',
                'updated_at' => '2026-09-01 22:45:40'
            ],
            [
                'id' => 7,
                'name' => 'member',
                'created_at' => '2026-09-14 23:17:17',
                'updated_at' => '2026-09-14 23:17:17'
            ]
        ]);
    }
}