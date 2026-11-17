<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('settings')->insert([
            [
                'id' => 1,
                'name' => 'Sector 3 Welfare Society',
                'logo' => '1787134206_default.png',
                'login_background_image' => 'login_background_image_61adaf51-6195-456e-8adc-8d4f042a60d9.jpg',
                'login_panel_image' => 'login_panel_image_cbc09f3d-2dfd-4382-be4e-f51c8baf0721.jpg',
                'address' => 'House-10, Road-07, Sector-03, Uttara,Dhaka-1230, Bangladesh',
                'contact' => '8801234567890',
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
                'created_at' => '2026-03-31 22:18:14',
                'updated_at' => '2026-11-15 11:38:27',
            ],
        ]);
    }
}
