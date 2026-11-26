<?php

namespace App\Http\Controllers;

use App\Jobs\SendBulkSmsJob;
use App\Models\Bulksms;
use App\Models\Bill;
use App\Models\Draft;
use App\Models\PlotAndUnit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\SmsGateway;
use Illuminate\Support\Facades\Log;

class BulkSmsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $balanceResponse = app(SmsGateway::class)->balance();
            $balanceStatus = $balanceResponse['statusInfo']['statusCode'] ?? null;
            $data['amount'] = (string) $balanceStatus === '0'
                ? ($balanceResponse['statusInfo']['availablebalance'] ?? null)
                : null;
        } catch (\Throwable $e) {
            Log::warning('Unable to retrieve SMS balance', ['error' => $e->getMessage()]);
            $data['amount'] = null;
        }
        $data['totalSent']          = Bulksms::where('status', 'sent')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $data['members']            = PlotAndUnit::where('status', 'Active')->get();
        $data['drafts']             = Draft::all();

        return view('admin.bulk_sms.index', $data); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_type'       => 'required|in:existing_member,custom_member',
            'sms_type'          => 'required|in:custom,draft',
            'language'          => 'required|in:English,Bangla',
            'sending_method'    => 'nullable|in:send_now,scheduled_message',
            'schedule_time'     => 'required_if:sending_method,scheduled_message|nullable|date',
            'draft_id'          => 'required_if:sms_type,draft|nullable|exists:drafts,id',
            'custom_sms'        => 'required_if:sms_type,custom|nullable|string',
            'target_recipient'  => 'required_if:member_type,custom_member|nullable|string',
            'recipients'        => 'required_if:member_type,existing_member|array',
            'recipients.*'      => 'integer|distinct|exists:plot_and_units,id',
        ]);

        $recipientIds = $request->input('recipients', []);
        if ($request->member_type === 'existing_member' && empty($recipientIds)) {
            $recipientIds = json_decode($request->input('recipient_ids', '[]'), true) ?: [];
        }

        $recipients = collect();
        if ($request->member_type === 'existing_member' && !empty($recipientIds)) {
            $recipients = PlotAndUnit::where('status', 'Active')
                ->whereIn('id', $recipientIds)
                ->get();
        }

        $phoneNumbers = $request->member_type === 'custom_member'
            ? [trim($request->target_recipient)]
            : $recipients->pluck('phone')->filter()->values()->all();

        if (empty($phoneNumbers)) {
            return redirect()->back()->withInput()->with('error', 'Please select at least one recipient with a phone number.');
        }

        $draft = null;

        if ($request->sms_type === 'draft') {
            $draft = Draft::where('id', $request->draft_id)->first();
        }

        $message = $request->sms_type === 'custom' ? $request->custom_sms : $draft->message;

        if ($request->member_type === 'custom_member') {
            $message = preg_replace('/\{(?:name|amount|due_month)\}/', '', $message);
        }

        if ($request->member_type === 'custom_member') {
            $sent = app(SmsGateway::class)->send($phoneNumbers[0], $message);
            $phone_no = $sent['phone'];
            Bulksms::create([
                'phone_no'       => $phone_no,
                'sms_type'       => $request->sms_type,
                'draft_id'       => $request->draft_id,
                'language'       => strtolower($request->language),
                'custom_sms'     => $message,
                'sending_method' => $request->sending_method,
                'schedule_time'  => $request->sending_method == 'scheduled_message'
                    ? Carbon::parse($request->schedule_time) : null,
                'status'         => 'sent',
            ]);
        } else {
            $latestOutstandingBills = Bill::whereIn('plot_and_unit_id', $recipients->pluck('id'))
                ->whereColumn('net_amount', '>', 'paid_amount')
                ->orderByDesc('billing_month')
                ->get()
                ->unique('plot_and_unit_id')
                ->keyBy('plot_and_unit_id');

            foreach ($recipients as $recipient) {
                $bill = $latestOutstandingBills->get($recipient->id);
                $messageForRecipient = strtr($message, [
                    '{name}' => $recipient->name ?? '',
                    '{amount}' => number_format((float) ($bill?->due_balance ?? $recipient->total_amount ?? 0), 2, '.', ''),
                    '{due_month}' => $bill?->billing_month
                        ? Carbon::parse($bill->billing_month)->format('F Y')
                        : 'N/A',
                ]);
                $sms_type = $request->sms_type;
                $draft_id = $request->draft_id;
                $language = strtolower($request->language);
                $custom_sms = $messageForRecipient;
                $sending_method = $request->sending_method;
                $schedule_time = $request->schedule_time;

                SendBulkSmsJob::dispatch($recipient->phone, $messageForRecipient, $sms_type, $draft_id, $language, $custom_sms, $sending_method, $schedule_time);
            }
        }


        return redirect()->back()->with('success', 'Sms Sent Successfully');
    }

    public function SMSHistory(Request $request)
    {
        $sms_histories = Bulksms::orderBy('created_at', 'desc');

        if ($request->mobile_no) {
            $sms_histories = $sms_histories->where('phone_no', 'like', '%' . $request->mobile_no . '%');
        }

        if ($request->from_date && $request->to_date) {
            $sms_histories = $sms_histories->whereBetween('created_at', [$request->from_date, $request->to_date]);
        }

        $sms_histories = $sms_histories->paginate(10)->withQueryString();

        return view('admin.bulk_sms.sms_history', compact('sms_histories'));
    }
}
