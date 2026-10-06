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

    // public function edit($id)
    // {
    //     $collector = User::findOrFail($id);
    //     return view('admin.collectors.edit', compact('collector'));
    // }

    public function update(Request $request, $id)
    {
        $collector = User::findOrFail($id);

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email,',
            'role'      => 'required',
        ]);

        $collector->name    = $request->name;
        $collector->email   = $request->email;
        $collector->role    = $request->role;
        $collector->save();

        return redirect()
            ->route('admin.collectors.index')
            ->with('success', 'Collector updated successfully.');
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
