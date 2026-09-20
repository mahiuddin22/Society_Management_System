<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PasswordResetTokensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Populates the password_reset_tokens table with initial data.
     */
    public function run()
    {
        DB::table('password_reset_tokens')->insert([
            [
                'email' => 'admin@example.com',
                'token' => '$2y$12$RQxDrG39UVwkTpI8kRbUruUHnb1gO9Tri4RXYNbDKMhcACx.2OaXy',
                'created_at' => '2025-08-12 12:18:29'
            ]
        ]);
    }
}