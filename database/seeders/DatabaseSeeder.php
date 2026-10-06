<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            ActivitiesSeeder::class,
            MembersSeeder::class,
            PasswordResetTokensSeeder::class,
            PermissionsSeeder::class,
            UsersSeeder::class,
            RoadsSeeder::class,
            PlotTypesSeeder::class,
            PlotAndUnitsSeeder::class,
            RolesSeeder::class,
            SectorCollenctionsSeeder::class,
            SettingsSeeder::class,
            DraftSeeder::class,
            ActivitySeeder::class,
            PermissionSeeder::class,
            RolePermissionsSeeder::class,

        ]);
    }
}