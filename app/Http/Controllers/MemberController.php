<?php

namespace App\Http\Controllers;

use App\Models\PlotAndUnit;
use App\Models\Settings;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function mypayments(){
        $data = PlotAndUnit::where('unique_id', auth()->user()->uid)->paginate(30);
        return view('members.index', compact('data'));
    }
    
    public function receipt($id)
    {
        $collection = PlotAndUnit::findOrFail($id);
        $settings   = Settings::latest()->first();
        return view('members.receipt', compact('collection', 'settings'));
    }

    public function Pay(){
        dd("Under COnstructions");
    }

}
