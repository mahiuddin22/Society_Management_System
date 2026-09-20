<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Populates the members table with initial data.
     */
    public function run()
    {
        DB::table('members')->insert([
            [
                'id' => 9,
                'name' => 'Nusrat Jahan',
                'flat_no' => 202,
                'number' => '01823456789',
                'email' => 'nusrat.jahan@example.com',
                'created_at' => '2026-09-08 09:49:34',
                'updated_at' => '2026-09-08 09:49:34'
            ],
            [
                'id' => 10,
                'name' => 'Md. Rakib Hasan',
                'flat_no' => 303,
                'number' => '01934567890',
                'email' => 'rakib@example.com',
                'created_at' => '2026-09-08 09:49:34',
                'updated_at' => '2026-09-08 09:49:34'
            ],
            [
                'id' => 11,
                'name' => 'Sadia Rahman',
                'flat_no' => 404,
                'number' => '01645678901',
                'email' => 'sadia.rahman@example.com',
                'created_at' => '2026-09-08 09:49:34',
                'updated_at' => '2026-09-08 09:49:34'
            ],
            [
                'id' => 12,
                'name' => 'Tanvir Ahmed',
                'flat_no' => 505,
                'number' => '01556789012',
                'email' => 'tanvir.ahmed@example.com',
                'created_at' => '2026-09-08 09:49:34',
                'updated_at' => '2026-09-08 09:49:34'
            ],
            [
                'id' => 13,
                'name' => 'Farhan Hossain',
                'flat_no' => 606,
                'number' => '01767890123',
                'email' => 'farhan.hossain@example.com',
                'created_at' => '2026-09-08 03:49:50',
                'updated_at' => '2026-09-08 03:49:50'
            ],
            [
                'id' => 14,
                'name' => 'Mim Akter',
                'flat_no' => 707,
                'number' => '01878901234',
                'email' => 'mim.akter@example.com',
                'created_at' => '2026-09-08 03:49:50',
                'updated_at' => '2026-09-08 03:49:50'
            ],
            [
                'id' => 15,
                'name' => 'Shakil Ahmed',
                'flat_no' => 808,
                'number' => '01989012345',
                'email' => 'shakil.ahmed@example.com',
                'created_at' => '2026-09-08 03:49:50',
                'updated_at' => '2026-09-08 03:49:50'
            ],
            [
                'id' => 16,
                'name' => 'Jannatul Ferdous',
                'flat_no' => 909,
                'number' => '01690123456',
                'email' => 'jannatul.ferdous@example.com',
                'created_at' => '2026-09-08 03:49:50',
                'updated_at' => '2026-09-08 03:49:50'
            ],
            [
                'id' => 17,
                'name' => 'Imran Kabir',
                'flat_no' => 110,
                'number' => '01501234567',
                'email' => 'imran.kabir@example.com',
                'created_at' => '2026-09-08 03:49:50',
                'updated_at' => '2026-09-08 03:49:50'
            ],
            [
                'id' => 18,
                'name' => 'Rafiul Islam',
                'flat_no' => 111,
                'number' => '01711223344',
                'email' => 'rafiul.islam@example.com',
                'created_at' => '2026-09-08 03:49:50',
                'updated_at' => '2026-09-08 03:49:50'
            ],
            [
                'id' => 19,
                'name' => 'Tania Sultana',
                'flat_no' => 112,
                'number' => '01822334455',
                'email' => 'tania.sultana@example.com',
                'created_at' => '2026-09-08 03:49:50',
                'updated_at' => '2026-09-08 03:49:50'
            ],
            [
                'id' => 20,
                'name' => 'Mahmud Hasan',
                'flat_no' => 113,
                'number' => '01933445566',
                'email' => 'mahmud.hasan@example.com',
                'created_at' => '2026-09-08 03:49:50',
                'updated_at' => '2026-09-08 03:49:50'
            ],
            [
                'id' => 21,
                'name' => 'Priya Das',
                'flat_no' => 114,
                'number' => '01644556677',
                'email' => 'priya.das@example.com',
                'created_at' => '2026-09-08 03:49:50',
                'updated_at' => '2026-09-08 03:49:50'
            ],
            [
                'id' => 22,
                'name' => 'Arif Rahman',
                'flat_no' => 115,
                'number' => '01555667788',
                'email' => 'arif.rahman@example.com',
                'created_at' => '2026-09-08 03:49:50',
                'updated_at' => '2026-09-08 03:49:50'
            ],
            [
                'id' => 23,
                'name' => 'Md Mahiuddin',
                'flat_no' => 10,
                'number' => '01610440622',
                'email' => 'mahiuddin@example.com',
                'created_at' => '2026-09-09 00:59:47',
                'updated_at' => '2026-09-09 00:59:47'
            ],
            [
                'id' => 24,
                'name' => 'Naeem Biswas',
                'flat_no' => 11,
                'number' => '01710872443',
                'email' => 'naeem@example.com',
                'created_at' => '2026-09-09 01:00:46',
                'updated_at' => '2026-09-09 01:00:46'
            ]
        ]);
    }
}