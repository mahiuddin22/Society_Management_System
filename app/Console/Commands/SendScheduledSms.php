<?php

namespace App\Console\Commands;

use App\Models\Bulksms;
use App\Services\SmsGateway;
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

            try {
                app(SmsGateway::class)->send($bulkSms->phone_no, $sms);
                $bulkSms->update(['status' => 'sent']);
                $this->info("SMS ID {$bulkSms->id} sent.");
            } catch (\Throwable $e) {
                \Log::error('Scheduled SMS failed', ['sms_id' => $bulkSms->id, 'error' => $e->getMessage()]);
                $bulkSms->update(['status' => 'canceled']);
                $this->error("SMS ID {$bulkSms->id} failed.");
            }
        }

        return Command::SUCCESS;
    }
}
