<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Populates the users table with initial data.
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'uid' => null,
                'role' => 'admin',
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'phone' => 1571234569,
                'email_verified_at' => '2025-08-02 10:49:38',
                'password' => '$2y$12$dmhp2VydIdIJvtBm8NR9I.MoS/HEhtWDJSPdUCPMS6I/ReKJEWK0e',
                'remember_token' => 'u0dZbjOMX3SpyW6i89sXt9qhD8XrIDrfZqieivq9gYzJTkjI0OX49EAEBSuy',
                'created_at' => '2025-08-02 10:49:38',
                'updated_at' => '2025-08-02 08:08:44'
            ],
            [
                'id' => 9,
                'uid' => null,
                'role' => 'collector',
                'name' => 'Naeem biswas',
                'username' => 'naeem',
                'email' => 'nayeembiswas@sector3.com',
                'phone' => 15712994567,
                'email_verified_at' => null,
                'password' => '$2y$12$WnDMkEfc7v8.CtDpKF6P6.3KnrMd5NPaSXOQB943Y8kRKxs2w5LhW',
                'remember_token' => null,
                'created_at' => '2026-09-02 02:51:46',
                'updated_at' => '2026-09-02 02:51:46'
            ],
            [
                'id' => 10,
                'uid' => null,
                'role' => 'collector',
                'name' => 'mahiuddin',
                'username' => 'mahiuddin',
                'email' => 'mahiuddin@test.com',
                'phone' => 01571234567,
                'email_verified_at' => null,
                'password' => '$2y$12$.nH1B9qV9T13m0IXTNMRA.Drl.iJ8A.SpPxm6LQ/hUjVXnTK/Rgd6',
                'remember_token' => null,
                'created_at' => '2026-09-06 02:22:42',
                'updated_at' => '2026-09-06 02:22:42'
            ]
        ]);
    }
}