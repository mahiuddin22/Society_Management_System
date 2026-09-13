<?php

namespace App\Http\Controllers;

use App\Models\Road;
use Illuminate\Http\Request;

class RoadController extends Controller
{
    public function index()
    {
        $data['roads'] = Road::where('name', 'like', '%' . request()->get('search') . '%')->paginate(25);
        return view('admin.roads.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255'
        ]);

        Road::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.roads.index')->with('success', 'Road created successfully.');
    }

    public function edit($id)
    {
        $data['road'] = Road::findOrFail($id);
        return view('admin.roads.edit', $data);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Road::findOrFail($id)->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.roads.index')->with('success', 'Road updated successfully.');
    }

    public function destroy($id)
    {
        Road::findOrFail($id)->delete();
        return redirect()->route('admin.roads.index')->with('success', 'Road deleted successfully.');
    }

}
