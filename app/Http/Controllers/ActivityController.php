<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Permission;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $name           = $request->input('name');
        $activity_key    = $request->input('activity_key');

        $activitiesearch    = Activity::all();

        $activities = Activity::orderBy('id', 'desc');

        if (!empty($name)) {
            $activities = $activities->where('name', 'like', '%' . $name . '%');
        }

        if (!empty($activity_key)) {
            $activities = $activities->where('activity_key', $activity_key);
        }

        $activities = $activities->paginate(30);

        return view('admin.activities.index', compact('activities','activitiesearch','name', 'activity_key'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'activity_key' => 'required|string|max:255|unique:activities,activity_key',
        ]);

        $name = ucwords($request->name);
        $activity_key = strtolower($request->activity_key);

        Activity::create([
            'name'          => $name,
            'activity_key'  => $activity_key,
        ]);

        return redirect()->route('admin.activities.index')->with('success', 'Activitiy created successfully.');
    }

    public function edit($id)
    {
        $activity = Activity::findOrFail($id);
        return view('admin.activities.edit', compact('activity'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'activity_key' => 'required|string|max:255',
        ]);

        $name = ucwords($request->name);
        $activity_key = strtolower($request->activity_key);

        $activity = Activity::findOrFail($id);
        $activity->update([
            'name' => $name,
            'activity_key' => $activity_key,
        ]);

        return redirect()->route('admin.activities.index')->with('success', 'Activitiy updated successfully.');
    }


    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();

        return redirect()->route('admin.activities.index')->with('success', 'Activitiy deleted successfully.');
    }
}
