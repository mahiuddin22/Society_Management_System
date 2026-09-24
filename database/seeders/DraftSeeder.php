<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DraftSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('drafts')->insert([
            [
                'type' => 'Invoice',
                'message' => 'Dear customer, your monthly invoice is ready. Please make your payment within the due date.',
                'language' => 'English',
                'length' => 99,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Payment Reminder',
                'message' => 'Dear customer, this is a reminder that your payment is due. Please complete your payment on time.',
                'language' => 'English',
                'length' => 101,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Notice',
                'message' => 'প্রিয় গ্রাহক, আপনার মাসিক বিল পরিশোধের সময় হয়েছে। নির্ধারিত সময়ের মধ্যে বিল পরিশোধ করুন।',
                'language' => 'Bangla',
                'length' => 88,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'Collection',
                'message' => 'Dear customer, our collection representative will visit your area for monthly collection.',
                'language' => 'English',
                'length' => 89,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}