<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Populates the settings table with initial data.
     */
    public function run()
    {
        DB::table('settings')->insert([
            [
                'id' => 1,
                'name' => 'Sector 3 Welfare Society',
                'logo' => '1787134206_default.png',
                'address' => 'House-10, Road-07, Sector-03, Uttara,Dhaka-1230, Bangladesh',
                'contact' => +8801234567890,
                'email' => 'info@sector3society.com',
                'mail_driver' => 'smtp',
                'mail_host' => 'sandbox.smtp.mailtrap.io',
                'mail_port' => 587,
                'mail_username' => 'd1b3021b79c020',
                'mail_password' => '32918f66f08d5c',
                'mail_encryption' => 'tls',
                'mail_from_address' => 'support@sector3society.com',
                'mail_from_name' => 'Society Management System',
                'copy_right' => null,
                'created_at' => '2026-04-01 04:18:14',
                'updated_at' => '2026-08-25 03:21:42'
            ]
        ]);
    }
}