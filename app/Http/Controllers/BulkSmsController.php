<?php

namespace App\Http\Controllers;

use App\Models\Bulksms;
use App\Models\Draft;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BulkSmsController extends Controller
{
    public function index(Request $request)
    {
        $balanceapi     = Http::get('http://103.230.63.50/bulksms/api/sec03-amount');
        $data['amount'] = $balanceapi->json('amount');
        $data['validity_period'] = $balanceapi->json('validity_period');
        $data['drafts'] = Draft::all();

        return view('admin.bulk_sms.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'sms_type'      => 'required|in:custom,draft',
            'language'      => 'required|in:English,Bangla',
            'sending_method'=> 'required|in:send_now,scheduled_message',
            'schedule_time' => 'required_if:sending_method,scheduled_message|nullable|date',
            'draft_id'      => 'required_if:sms_type,draft|nullable|exists:drafts,id',
            'custom_sms'    => 'required_if:sms_type,custom|nullable|string',
        ]);

        $bulkSms = Bulksms::create([
            'sms_type'      => $request->sms_type,
            'draft_id'      => $request->draft_id,
            'language'      => $request->language,
            'custom_sms'    => $request->custom_sms,
            'sending_method'=> $request->sending_method,
            'schedule_time' => $request->sending_method == 'scheduled_message'
                ? Carbon::parse($request->schedule_time)
                : null,
            'status' => 'pending',
        ]);

        // Get SMS message
        if ($request->sms_type == 'custom') {
            $sms = $request->custom_sms;
        } else {
            $sms = $bulkSms->draftsms->message;
        }

        // Sending method
        if ($request->sending_method == 'scheduled_message') {

            // Save only.
            // Artisan scheduler will send it when schedule_time arrives.

        } else {

            // Send SMS immediately
            // SMS API here

            $bulkSms->update([
                'status' => 'sent',
            ]);
        }

        return redirect()->back()->with('success', 'Data Inserted Successfully');
    }

    public function SMSHistory(Request $request)
    {
        $response = Http::get('http://103.230.63.50/bulksms/api/all-sms-data', [
            'page'          => $request->query('page', 1),
            'mobile_no'     => $request->query('mobile_no'),
            'api_status'    => $request->query('api_status'),
            'date_from'     => $request->query('date_from'),
            'date_to'       => $request->query('date_to'),
        ]);

        $allsms = $response->json('all_sms');

        return view('admin.bulk_sms.sms_history', compact('allsms'));
    }
}
