<?php

namespace App\Jobs;

use App\Models\Bulksms;
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
        $this->phone_no = $phone_no;
        $this->message = $message;
        $this->sms_type = $sms_type;
        $this->draft_id = $draft_id;
        $this->language = $language;
        $this->custom_sms = $custom_sms;
        $this->sending_method = $sending_method;
        $this->schedule_time = $schedule_time;
    }

    public function handle(): void
    {
        $phone_no = trim($this->phone_no);

        $phone_no = preg_replace('/\D+/', '', $phone_no);

        if (!str_starts_with($phone_no, '88')) {
            $phone_no = '88' . $phone_no;
        }

        $number = $phone_no;
        $text = $this->message;
        $mask = 'HSIA';

        $apiUrl = "http://103.230.63.50/bulksms/api";

        // Must be unique for every queued SMS
        $requesteid = uniqid('', true);

        $contentType = 1;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            "authUser=HSIA&authAccess=HSIA@241#765&destination=" . $number .
                "&mask=" . $mask .
                "&text=" . urlencode($text) .
                "&requestId=" . $requesteid .
                "&contentType=" . $contentType
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close($ch);

        $status_code = json_decode($server_output, true)['reply'][0]['statuscode'] ?? null;
        Bulksms::create([
            'phone_no'       => $phone_no,
            'sms_type'       => $this->sms_type,
            'draft_id'       => $this->draft_id,
            'language'       => $this->language,
            'custom_sms'     => $this->custom_sms,
            'sending_method' => $this->sending_method,
            'schedule_time'  => $this->sending_method == 'scheduled_message'
                ? Carbon::parse($this->schedule_time) : null,
            'status'         => $status_code === 0 ? 'sent' : 'canceled',
        ]);
    }

}
