<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'admin',
                'created_at' => '2025-08-12 07:37:14',
                'updated_at' => '2025-08-12 07:45:45',
            ],
            [
                'id' => 5,
                'name' => 'collector',
                'created_at' => '2026-09-01 16:45:40',
                'updated_at' => '2026-09-01 16:45:40',
            ],
            [
                'id' => 7,
                'name' => 'member',
                'created_at' => '2026-09-14 17:17:17',
                'updated_at' => '2026-09-14 17:17:17',
            ],
        ]);
    }
}
