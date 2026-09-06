<?php

namespace App\Http\Controllers;

use App\Models\Road;
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

    public function assignRoad($id)
    {
        $collector = User::findOrFail($id);
        $roads = Road::all();
        return view('admin.collectors.assign_road', compact('collector', 'roads'));
    }

    public function updateRoad($id, Request $request)
    {
        $collector = User::findOrFail($id);

        Road::where('collector_id', $collector->id)
            ->update(['collector_id' => null]);

        if ($request->filled('roads')) {
            Road::whereIn('id', $request->roads)
                ->update(['collector_id' => $collector->id]);
        }

        return redirect()
            ->route('admin.collectors.index')
            ->with('success', 'Roads assigned successfully.');
    }
    
}
