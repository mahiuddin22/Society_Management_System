<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DashboardNotificationReadsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('dashboard_notification_reads')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'notification_key' => 'bill_month-2026-11',
                'viewed_at' => '2026-11-16 08:22:23',
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'notification_key' => 'plot-1',
                'viewed_at' => '2026-11-16 08:22:23',
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'notification_key' => 'plot-3',
                'viewed_at' => '2026-11-16 08:22:23',
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'notification_key' => 'plot-4',
                'viewed_at' => '2026-11-16 08:22:23',
            ],
            [
                'id' => 5,
                'user_id' => 1,
                'notification_key' => 'plot-5',
                'viewed_at' => '2026-11-16 08:22:23',
            ],
            [
                'id' => 6,
                'user_id' => 1,
                'notification_key' => 'plot-6',
                'viewed_at' => '2026-11-16 08:22:23',
            ],
            [
                'id' => 7,
                'user_id' => 1,
                'notification_key' => 'plot-7',
                'viewed_at' => '2026-11-16 08:22:23',
            ],
            [
                'id' => 8,
                'user_id' => 1,
                'notification_key' => 'plot-8',
                'viewed_at' => '2026-11-16 08:22:23',
            ],
            [
                'id' => 9,
                'user_id' => 1,
                'notification_key' => 'plot-9',
                'viewed_at' => '2026-11-16 08:22:23',
            ],
            [
                'id' => 10,
                'user_id' => 1,
                'notification_key' => 'plot-10',
                'viewed_at' => '2026-11-16 08:22:23',
            ],
            [
                'id' => 11,
                'user_id' => 1,
                'notification_key' => 'plot-2',
                'viewed_at' => '2026-11-16 08:22:23',
            ],
        ]);
    }
}
