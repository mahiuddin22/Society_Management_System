<?php
// SMS text
$text = 'Dear ' . $validatedData['name']
. ', Your Collection Amount is ' . $validatedData['collection_amount']
. ' BDT. for the month of ' . $issue_date
. '. Please pay your dues on time. Thank you.';

// Send SMS
$ch = curl_init();

$apiUrl = "http://103.230.63.50/bulksms/api";

// Different request ID for every member
$requesteid = time();

$postData = http_build_query([
'authUser' => 'Sector-03',
'authAccess' => 'Sector@0309',
'destination' => $number,
'text' => $text,
'requestId' => $requesteid,
'contentType' => 1,
]);

curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);

if ($server_output === false) {
\Log::error('SMS Error', [
'number' => $number,
'error' => curl_error($ch),
]);
}

curl_close($ch);

// Debug
\Log::info('SMS Response', [
'name' => $$validatedData['name'],
'number' => $number,
'requestId' => $requesteid,
'response' => $server_output,
]);