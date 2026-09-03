<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CollectorController extends Controller
{
    public function index()
    {
        $collectors = User::where('role', 'collector');

        if (request()->has('search')  && request()->get('search') != '') {
            $collectors = $collectors->where(function ($query) {
                $query->where('name', 'like', '%' . request()->get('search') . '%')
                    ->orWhere('email', 'like', '%' . request()->get('search') . '%');
            });
        }

        $collectors = $collectors->orderBy('name')->paginate(10);
        return view('admin.collectors.index', compact('collectors'));
    }
}
