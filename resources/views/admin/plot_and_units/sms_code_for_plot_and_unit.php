<?php
// SMS text
$text = 'Dear ' . $validatedData['name']
. ', Your Collection Amount is ' . $validatedData['collection_amount']
. ' BDT. for the month of ' . $issue_date
. '. Please pay your dues on time. Thank you.';

// Use the configured SMS provider for collection reminders.
try {
    app(\App\Services\SmsGateway::class)->send($number, $text);
} catch (\Throwable $e) {
    \Log::error('Collection reminder SMS failed', [
        'number' => $number,
        'error' => $e->getMessage(),
    ]);
}
