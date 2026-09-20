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
            PlotAndUnitsSeeder::class,
            PlotTypesSeeder::class,
            RoadsSeeder::class,
            RolesSeeder::class,
            RolePermissionsSeeder::class,
            SectorCollenctionsSeeder::class,
            SettingsSeeder::class,
            UsersSeeder::class
        ]);
    }
}