<?php

namespace App\Http\Controllers;

use App\Models\Draft;
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

    public function SMSHistory(Request $request)
    {
        $response = Http::get('http://103.230.63.50/bulksms/api/all-sms-data', [
            'page' => $request->query('page', 1),
            'mobile_no' => $request->query('mobile_no'),
            'api_status' => $request->query('api_status'),
            'date_from' => $request->query('date_from'),
            'date_to' => $request->query('date_to'),
        ]);

        $allsms = $response->json('all_sms');

        return view('admin.bulk_sms.sms_history', compact('allsms'));
    }

}
