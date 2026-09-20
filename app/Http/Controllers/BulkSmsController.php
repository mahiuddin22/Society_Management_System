<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BulkSmsController extends Controller
{
    public function index(Request $request)
    {
        $totalsentapi = Http::get('http://103.230.63.50/bulksms/api/sent-sms-this-month');
        $balanceapi = Http::get('http://103.230.63.50/bulksms/api/sec03-amount');

        $data['totalsent']          = $totalsentapi->json('this_month');
        $data['amount']             = $balanceapi->json('amount');
        $data['validity_period']    = $balanceapi->json('validity_period');
        return view('admin.bulk_sms.index', $data);
    }

    public function SentTotal(){
        
    }
}
