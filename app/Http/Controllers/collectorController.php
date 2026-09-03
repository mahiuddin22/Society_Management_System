<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class collectorController extends Controller
{
    public function index()
    {
        $collectors = User::where('role', 'collector')->where('name', 'like', '%' . request()->get('search') . '%')->orWhere('email', 'like', '%' . request()->get('search') . '%')->paginate(10);
        return view('admin.collectors.index', compact('collectors'));
    }
}
