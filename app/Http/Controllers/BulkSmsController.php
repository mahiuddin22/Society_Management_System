<?php

namespace App\Http\Controllers;

use App\Jobs\SendBulkSmsJob;
use App\Models\Bulksms;
use App\Models\Draft;
use App\Models\PlotAndUnit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BulkSmsController extends Controller
{
    public function index(Request $request)
    {
        $balanceapi                 = Http::get('http://103.230.63.50/bulksms/api/sec03-amount');
        $data['amount']             = $balanceapi->json('amount');
        $data['validity_period']    = $balanceapi->json('validity_period');
        // $balanceapi                 = 100;
        // $data['amount']             = 100;
        // $data['validity_period']    = 12 - 12 - 2026;
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
            $phone_no = preg_replace('/\D+/', '', $phoneNumbers[0]);

            if (!str_starts_with($phone_no, '88')) {
                $phone_no = '88' . $phone_no;
            }

            $number = $phone_no;
            $text   = $message;
            $mask   = 'HSIA';

            $ch = curl_init();

            $apiUrl         = "http://103.230.63.50/bulksms/api";
            $requesteid     = $_SERVER['REQUEST_TIME'];
            $contentType    = 1;

            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt(
                $ch,
                CURLOPT_POSTFIELDS,
                "authUser=HSIA&authAccess=HSIA@241#765&destination=" . $number .
                    "&mask=" . $mask . "&text=" . urlencode($text) .
                    "&requestId=" . $requesteid . "&contentType=" . $contentType
            );

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);

            curl_close($ch);

            $status_code = json_decode($server_output, true)['reply'][0]['statuscode'] ?? null;
            Bulksms::create([
                'phone_no'       => $phone_no,
                'sms_type'       => $request->sms_type,
                'draft_id'       => $request->draft_id,
                'language'       => strtolower($request->language),
                'custom_sms'     => $request->custom_sms,
                'sending_method' => $request->sending_method,
                'schedule_time'  => $request->sending_method == 'scheduled_message'
                    ? Carbon::parse($request->schedule_time) : null,
                'status'         => $status_code == 0 ? 'sent' : 'canceled',
            ]);
        } else {
            foreach ($phoneNumbers as $phone_no) {
                $sms_type = $request->sms_type;
                $draft_id = $request->draft_id;
                $language = strtolower($request->language);
                $custom_sms = $request->custom_sms;
                $sending_method = $request->sending_method;
                $schedule_time = $request->schedule_time;

                SendBulkSmsJob::dispatch($phone_no, $message, $sms_type, $draft_id, $language, $custom_sms, $sending_method, $schedule_time);
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

        $sms_histories = $sms_histories->paginate(10);

        return view('admin.bulk_sms.sms_history', compact('sms_histories'));
    }
}
