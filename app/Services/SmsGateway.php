<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class SmsGateway
{
    public function balance(): array
    {
        if (!config('services.sms.apikey') || !config('services.sms.secretkey')) {
            throw new RuntimeException('SMS gateway credentials are not configured.');
        }

        $response = Http::timeout(30)->post(config('services.sms.balance_url'), [
            'apikey' => config('services.sms.apikey'),
            'secretkey' => config('services.sms.secretkey'),
            'clienttransid' => '123456',
        ]);

        if (!$response->successful()) {
            throw new RuntimeException('SMS balance provider returned HTTP ' . $response->status());
        }

        return $response->json() ?? [];
    }

    public function send(string $phone, string $message): array
    {
        if (!config('services.sms.apikey') || !config('services.sms.secretkey')) {
            throw new RuntimeException('SMS gateway credentials are not configured.');
        }

        $phone = preg_replace('/\D+/', '', $phone);
        if ($phone === '') {
            throw new RuntimeException('A valid SMS recipient number is required.');
        }

        if (!str_starts_with($phone, '88')) {
            $phone = '88' . $phone;
        }

        $response = Http::timeout(30)->post(config('services.sms.url'), [
            'apikey' => config('services.sms.apikey'),
            'secretkey' => config('services.sms.secretkey'),
            'callerID' => config('services.sms.caller_id'),
            'toUser' => $phone,
            'messageContent' => $message,
        ]);

        if (!$response->successful()) {
            throw new RuntimeException('SMS provider returned HTTP ' . $response->status());
        }

        return ['phone' => $phone, 'response' => $response->json() ?? $response->body()];
    }
}
