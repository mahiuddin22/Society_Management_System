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
                'phone' => null,
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
                'phone' => null,
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
                'phone' => null,
                'email_verified_at' => null,
                'password' => '$2y$12$.nH1B9qV9T13m0IXTNMRA.Drl.iJ8A.SpPxm6LQ/hUjVXnTK/Rgd6',
                'remember_token' => null,
                'created_at' => '2026-09-06 02:22:42',
                'updated_at' => '2026-09-06 02:22:42'
            ],
            [
                'id' => 17,
                'uid' => 'UT0361/A1410',
                'role' => 'member',
                'name' => 'Ex Name',
                'username' => 'exname',
                'email' => 'test@example.com',
                'phone' => 8801234567890,
                'email_verified_at' => null,
                'password' => '$2y$12$gscCF7yAURrvKKvzxHORBuRHKX9nXGlDSTL1sFLiNHyzLAsoz/Tzm',
                'remember_token' => null,
                'created_at' => '2026-09-15 00:21:38',
                'updated_at' => '2026-09-15 00:22:15'
            ],
            [
                'id' => 18,
                'uid' => 'UT0371/B590',
                'role' => 'member',
                'name' => 'Aminul Haque',
                'username' => 'aminulhaque',
                'email' => 'aminul_h@live.com',
                'phone' => 8801970247545,
                'email_verified_at' => null,
                'password' => '$2y$12$shJWPj.9CZrjcyKThvNYb.0hB9h77JyVNoHeMo0IfIte82rtIqGEe',
                'remember_token' => null,
                'created_at' => '2026-09-15 01:56:38',
                'updated_at' => '2026-09-15 01:56:38'
            ],
            [
                'id' => 19,
                'uid' => 'UT0392/C6012',
                'role' => 'member',
                'name' => 'Rasel Miah',
                'username' => 'raselmiah',
                'email' => 'rasel@dev.com',
                'phone' => 8801330563459,
                'email_verified_at' => null,
                'password' => '$2y$12$rZtLaqKIjItHiSoQrkynJORu.tIziu.g7t2hrHbsImkclm639iNzm',
                'remember_token' => null,
                'created_at' => '2026-09-15 02:03:26',
                'updated_at' => '2026-09-15 05:22:05'
            ]
        ]);
    }
}