<?php

namespace App\Console\Commands;

use App\Models\Bulksms;
use Illuminate\Console\Command;

class SendScheduledSms extends Command
{
    protected $signature = 'sms:send-scheduled';

    protected $description = 'Send scheduled SMS messages';

    public function handle()
    {
        $messages = Bulksms::where('sending_method', 'scheduled_message')
            ->where('status', 'pending')->whereNotNull('schedule_time')
            ->where('schedule_time', '<=', now())->get();

        foreach ($messages as $bulkSms) {

            // Get SMS message
            if ($bulkSms->sms_type == 'custom') {
                $sms = $bulkSms->custom_sms;
            } else {
                $sms = $bulkSms->draftsms->message;
            }

            // Send SMS API here
            // Example:
            // $this->sendSms($bulkSms->mobile_no, $sms);

            $bulkSms->update([
                'status' => 'sent',
            ]);

            $this->info("SMS ID {$bulkSms->id} sent.");
        }

        return Command::SUCCESS;
    }
}
