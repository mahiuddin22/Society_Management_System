<?php

namespace App\Jobs;

use App\Models\Bulksms;
use App\Services\SmsGateway;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendBulkSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phone_no;
    protected $message;
    protected $sms_type;
    protected $draft_id;
    protected $language;
    protected $custom_sms;
    protected $sending_method;
    protected $schedule_time;

    public function __construct($phone_no, $message, $sms_type, $draft_id, $language, $custom_sms, $sending_method, $schedule_time)
    {
        $this->phone_no         = $phone_no;
        $this->message          = $message;
        $this->sms_type         = $sms_type;
        $this->draft_id         = $draft_id;
        $this->language         = $language;
        $this->custom_sms       = $custom_sms;
        $this->sending_method   = $sending_method;
        $this->schedule_time    = $schedule_time;
    }

    public function handle(): void
    {
        $result = app(SmsGateway::class)->send($this->phone_no, $this->message);
        $phone_no = $result['phone'];
        Bulksms::create([
            'phone_no'       => $phone_no,
            'sms_type'       => $this->sms_type,
            'draft_id'       => $this->draft_id,
            'language'       => $this->language,
            'custom_sms'     => $this->custom_sms,
            'sending_method' => $this->sending_method,
            'schedule_time'  => $this->sending_method == 'scheduled_message' ? Carbon::parse($this->schedule_time) : null,
            'status'         => 'sent',
        ]);
    }

}
