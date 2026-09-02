<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class collectorController extends Controller
{
    public function index()
    {
        $collectors = User::where('role', 'collector')->get();
        return view('admin.collectors.index', compact('collectors'));
    }
}
