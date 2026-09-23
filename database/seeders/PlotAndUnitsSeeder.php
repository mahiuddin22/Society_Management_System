<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlotAndUnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Exact DB fees:
     * 1. Land               -> 0.00
     * 2. Under Construction -> 1500.00
     * 3. Apartment          -> 250.00
     * 4. Owner              -> 250.00
     * 5. Commercial         -> 1500.00
     */
    public function run(): void
    {
        DB::table('plot_and_units')->insert([
            // ==================== 1. LAND (1-ta: ID 1 | Fee: 0.00) ====================
            [
                'plot_type_id'    => 1, // Land
                'road_id'         => 4,
                'holding_no'      => '09',
                'building_name'   => null,
                'total_flat'      => 0,
                'occupied_flat'   => 0,
                'flat_numbers'    => null,
                'collection_type' => 'Individual',
                'flat_no'         => null,
                'name'            => 'Abdul Mannan',
                'phone'           => '01644444444',
                'email'           => null,
                'unique_id'       => 'UTR03-0409-LAND',
                'collection_rate' => 0.00,
                'discount'        => 0.00,
                'total_amount'    => 0.00,
                'status'          => 'Active',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],

            // ==================== 2. UNDER CONSTRUCTION (2-ta: ID 2 | Fee: 1500.00) ====================
            [
                'plot_type_id'    => 2, // Under Construction
                'road_id'         => 1,
                'holding_no'      => '07',
                'building_name'   => 'Green Horizon',
                'total_flat'      => 0,
                'occupied_flat'   => 0,
                'flat_numbers'    => null,
                'collection_type' => 'Individual',
                'flat_no'         => null,
                'name'            => 'Engr. Kamal Hossain',
                'phone'           => '01822222222',
                'email'           => 'kamal@example.com',
                'unique_id'       => 'UTR03-0107-CONS',
                'collection_rate' => 1500.00,
                'discount'        => 0.00,
                'total_amount'    => 1500.00, // 1500 * 1 - 0
                'status'          => 'Active',
                'created_at' => Carbon::now()->subDays(100),
                'updated_at' => Carbon::now()->subDays(100),
            ],
            [
                'plot_type_id'    => 2, // Under Construction
                'road_id'         => 5,
                'holding_no'      => '18/C',
                'building_name'   => 'Skyline Heights',
                'total_flat'      => 0,
                'occupied_flat'   => 0,
                'flat_numbers'    => null,
                'collection_type' => 'Individual',
                'flat_no'         => null,
                'name'            => 'Barrister Shahriar Kabir',
                'phone'           => '01945678901',
                'email'           => 'shahriar@kabir-law.com',
                'unique_id'       => 'UTR03-0518/C-CONS',
                'collection_rate' => 1500.00,
                'discount'        => 0.00,
                'total_amount'    => 1500.00, // 1500 * 1 - 0
                'status'          => 'Active',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],

            // ==================== 3. APARTMENT (4-ta: ID 3 | Fee: 250.00) ====================
            [
                'plot_type_id'    => 3, // Apartment
                'road_id'         => 1,
                'holding_no'      => '12/A',
                'building_name'   => 'Rahim Tower',
                'total_flat'      => 8,
                'occupied_flat'   => 7,
                'flat_numbers'    => '1A,1B,2A,2B,3A,3B,4A,4B',
                'collection_type' => 'Group',
                'flat_no'         => '1A',
                'name'            => 'Md. Rahim Uddin',
                'phone'           => '01711111111',
                'email'           => 'rahim@example.com',
                'unique_id'       => 'UTR03-0112/A-1A',
                'collection_rate' => 250.00,
                'discount'        => 50.00,
                'total_amount'    => 1700.00, // (250 * 7) - 50 = 1700.00
                'status'          => 'Active',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'plot_type_id'    => 3, // Apartment
                'road_id'         => 2,
                'holding_no'      => '25/B',
                'building_name'   => 'Fatema Heights',
                'total_flat'      => 12,
                'occupied_flat'   => 10,
                'flat_numbers'    => '1A,1B,2A,2B,3A,3B,4A,4B,5A,5B,6A,6B',
                'collection_type' => 'Individual',
                'flat_no'         => '3B',
                'name'            => 'Fatema Khatun',
                'phone'           => '01933333333',
                'email'           => 'fatema@example.com',
                'unique_id'       => 'UTR03-0225/B-3B',
                'collection_rate' => 250.00,
                'discount'        => 0.00,
                'total_amount'    => 2500.00, // (250 * 10) - 0 = 2500.00
                'status'          => 'Active',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'plot_type_id'    => 3, // Apartment
                'road_id'         => 3,
                'holding_no'      => '05',
                'building_name'   => 'Jahan Palace',
                'total_flat'      => 20,
                'occupied_flat'   => 18,
                'flat_numbers'    => '1A,1B,2A,2B,3A,3B,4A,4B,5A,5B',
                'collection_type' => 'Group',
                'flat_no'         => '2A',
                'name'            => 'Nusrat Jahan',
                'phone'           => '01555555555',
                'email'           => 'nusrat@example.com',
                'unique_id'       => 'UTR0-3305-2A',
                'collection_rate' => 250.00,
                'discount'        => 500.00,
                'total_amount'    => 4000.00, // (250 * 18) - 500 = 4000.00
                'status'          => 'Active',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'plot_type_id'    => 3, // Apartment
                'road_id'         => 6,
                'holding_no'      => '03',
                'building_name'   => 'Rose Wood Residency',
                'total_flat'      => 10,
                'occupied_flat'   => 8,
                'flat_numbers'    => '1A,1B,2A,2B,3A,3B,4A,4B,5A,5B',
                'collection_type' => 'Group',
                'flat_no'         => '3A',
                'name'            => 'Mahbubur Rahman',
                'phone'           => '01567890123',
                'email'           => 'mahbub.rahman@example.com',
                'unique_id'       => 'UTR03-0603-3A',
                'collection_rate' => 250.00,
                'discount'        => 200.00,
                'total_amount'    => 1800.00, // (250 * 8) - 200 = 1800.00
                'status'          => 'Active',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],

            // ==================== 4. OWNER (2-ta: ID 4 | Fee: 250.00) ====================
            [
                'plot_type_id'    => 4, // Owner
                'road_id'         => 2,
                'holding_no'      => '08',
                'building_name'   => 'Khan Bhaban',
                'total_flat'      => 4,
                'occupied_flat'   => 4,
                'flat_numbers'    => '1A,1B,2A,2B',
                'collection_type' => 'Individual',
                'flat_no'         => '2A',
                'name'            => 'Imtiaz Ahmed Khan',
                'phone'           => '01834567890',
                'email'           => 'imtiaz.khan@example.com',
                'unique_id'       => 'UTR03-0208-2A',
                'collection_rate' => 250.00,
                'discount'        => 0.00,
                'total_amount'    => 1000.00, // (250 * 4) - 0 = 1000.00
                'status'          => 'Active',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'plot_type_id'    => 4, // Owner
                'road_id'         => 7,
                'holding_no'      => '02',
                'building_name'   => 'Chowdhury Villa',
                'total_flat'      => 2,
                'occupied_flat'   => 2,
                'flat_numbers'    => '2A,2B',
                'collection_type' => 'Individual',
                'flat_no'         => '2B',
                'name'            => 'Kabir Chowdhury',
                'phone'           => '01799887766',
                'email'           => 'kabir.chowdhury@example.com',
                'unique_id'       => 'UTR03-0702-2B',
                'collection_rate' => 250.00,
                'discount'        => 0.00,
                'total_amount'    => 500.00, // (250 * 2) - 0 = 500.00
                'status'          => 'Active',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],

            // ==================== 5. COMMERCIAL (1-ta: ID 5 | Fee: 1500.00) ====================
            [
                'plot_type_id'    => 5, // Commercial
                'road_id'         => 3,
                'holding_no'      => '14',
                'building_name'   => 'Sector 3 Commercial Plaza',
                'total_flat'      => 6,
                'occupied_flat'   => 5,
                'flat_numbers'    => 'Shop-1,Shop-2,Office-1,Office-2,Office-3',
                'collection_type' => 'Group',
                'flat_no'         => '7C',
                'name'            => 'Tariqul Islam',
                'phone'           => '01712345678',
                'email'           => 'tariqul@commercial.com',
                'unique_id'       => 'UTR03-0314-7C',
                'collection_rate' => 1500.00,
                'discount'        => 500.00,
                'total_amount'    => 7000.00, // (1500 * 5) - 500 = 7000.00
                'status'          => 'Active',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);
    }
}