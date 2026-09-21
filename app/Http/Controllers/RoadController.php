<?php

#TODO::Ajax request check if already road exist

namespace App\Http\Controllers;

use App\Models\Road;
use Exception;
use Illuminate\Http\Request;

class RoadController extends Controller
{
    public function index()
    {
        $data['roads'] = Road::where('number', 'like', '%' . request()->get('search') . '%')->paginate(25);
        return view('admin.roads.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'number'  => 'required|string|max:21|unique:roads,number',
        ]);

        Road::create([
            'number' => $request->number,
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
            'number' => 'required|string|max:21|unique:roads,number,' . $id,
        ]);

        Road::findOrFail($id)->update([
            'number' => $request->number,
        ]);

        return redirect()->route('admin.roads.index')->with('success', 'Road updated successfully.');
    }

    public function destroy($id)
    {
         try {
            Road::findOrFail($id)->delete();

            return redirect()
                ->route('admin.roads.index')
                ->with('success', 'Road deleted successfully.');

        } catch (Exception $e) {

            return redirect()
                ->route('admin.roads.index')
                ->with('error', 'This road cannot be deleted because it is already associated with plot and unit records.');
        }
    }

}
