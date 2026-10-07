<?php

namespace App\Jobs;

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

    public function __construct($phone_no, $message)
    {
        $this->phone_no = $phone_no;
        $this->message = $message;
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
    }
}