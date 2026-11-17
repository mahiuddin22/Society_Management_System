<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            RoadsSeeder::class,
            PlotTypesSeeder::class,
            PlotAndUnitsSeeder::class,
            MembersSeeder::class,
            RolesSeeder::class,
            ActivitySeeder::class,
            PermissionSeeder::class,
            RolePermissionsSeeder::class,
            SectorCollenctionsSeeder::class,
            SettingsSeeder::class,
            DraftSeeder::class,
            BulkSmsSeeder::class,
            BillsSeeder::class,
            DashboardNotificationReadsSeeder::class,
            PasswordResetTokensSeeder::class,
        ]);
    }
}
