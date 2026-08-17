<?php

namespace App\Http\Controllers;

use App\Models\PlotAndUnit;
use App\Models\Member;
use App\Models\PlotType;
use Illuminate\Http\Request;

class PlotAndUnitController extends Controller
{
    public function index()
    {
        $plotAndUnits = PlotAndUnit::all();
        $plot_types = PlotType::where('status', true)->get();
        return view('admin.plot_and_units.index', compact('plotAndUnits', 'plot_types'));
    }

    public function create()
    {
        $plot_types = PlotType::where('status', true)->get();
        $rates              = $plot_types->pluck('amount', 'id')->toArray();
        return view('admin.plot_and_units.create', compact('plot_types', 'rates'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'road' => 'required|string|max:255',
            'holding_no' => 'required|string|max:255',
            'building_type' => 'required',
            'total_flat' => 'required|integer|min:0',
            'occupied_flat' => 'required|integer|min:0|lte:total_flat',
            'collection_type' => 'required|in:Group,Individual',
            'contact_person' => 'required|integer|min:0',
            'collection_rate' => 'required|numeric|min:0',
            'collection_amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',

            'contact_persons' => 'nullable|array',
            'contact_persons.*.name' => 'required|string|max:255',
            'contact_persons.*.number' => 'required|string|max:255',
            'contact_persons.*.email' => 'nullable|email|max:255',
            'contact_persons.*.amount' => 'required|numeric|min:0',
        ]);

        $plotAndUnit = new PlotAndUnit();
        $plotAndUnit->road = $validatedData['road'];
        $plotAndUnit->holding_no = $validatedData['holding_no'];
        $plotAndUnit->building_type = $validatedData['building_type'];
        $plotAndUnit->total_flat = $validatedData['total_flat'];
        $plotAndUnit->occupied_flat = $validatedData['occupied_flat'];
        $plotAndUnit->collection_type = $validatedData['collection_type'];
        $plotAndUnit->contact_person = $validatedData['contact_person'];
        $plotAndUnit->collection_rate = $validatedData['collection_rate'];
        $plotAndUnit->collection_amount = $validatedData['collection_amount'];
        $plotAndUnit->discount = $validatedData['discount'] ?? 0;
        $plotAndUnit->save();

        foreach ($validatedData['contact_persons'] ?? [] as $contact) {
            $member = new Member();
            $member->plot_and_unit_id = $plotAndUnit->id;
            $member->name = $contact['name'];
            $member->number = $contact['number'];
            $member->email = $contact['email'] ?? null;
            $member->amount = $contact['amount'];
            $member->save();
        }

        return redirect()
            ->route('admin.plot-and-units.index')
            ->with('success', 'Data created successfully.');
    }

    public function edit($id)
    {
        $data = PlotAndUnit::findOrFail($id);
        $members = Member::where('plot_and_unit_id', $id)->get();
        $plot_types = PlotType::where('status', true)->get();
        $rates = $plot_types->pluck('amount', 'id')->toArray();
        return view('admin.plot_and_units.edit', compact('data', 'plot_types', 'rates', 'members'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'road' => 'required|string|max:255',
            'holding_no' => 'required|string|max:255',
            'building_type' => 'required',
            'total_flat' => 'required|integer|min:0',
            'occupied_flat' => 'required|integer|min:0|lte:total_flat',
            'collection_type' => 'required|in:Group,Individual',
            'contact_person' => 'required|integer|min:0',
            'collection_rate' => 'required|numeric|min:0',
            'collection_amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',

            'contact_persons' => 'nullable|array',
            'contact_persons.*.name' => 'required|string|max:255',
            'contact_persons.*.number' => 'required|string|max:255',
            'contact_persons.*.email' => 'nullable|email|max:255',
            'contact_persons.*.amount' => 'required|numeric|min:0',
        ]);

        $plotAndUnit = PlotAndUnit::findOrFail($id);

        // Update Plot and Unit
        $plotAndUnit->road = $validatedData['road'];
        $plotAndUnit->holding_no = $validatedData['holding_no'];
        $plotAndUnit->building_type = $validatedData['building_type'];
        $plotAndUnit->total_flat = $validatedData['total_flat'];
        $plotAndUnit->occupied_flat = $validatedData['occupied_flat'];
        $plotAndUnit->collection_type = $validatedData['collection_type'];
        $plotAndUnit->contact_person = $validatedData['contact_person'];
        $plotAndUnit->collection_rate = $validatedData['collection_rate'];
        $plotAndUnit->collection_amount = $validatedData['collection_amount'];
        $plotAndUnit->discount = $validatedData['discount'] ?? 0;
        $plotAndUnit->save();

        // Remove old members
        Member::where('plot_and_unit_id', $plotAndUnit->id)->delete();

        // Create updated members
        foreach ($validatedData['contact_persons'] ?? [] as $contact) {
            $member = new Member();
            $member->plot_and_unit_id = $plotAndUnit->id;
            $member->name = $contact['name'];
            $member->number = $contact['number'];
            $member->email = $contact['email'] ?? null;
            $member->amount = $contact['amount'];
            $member->save();
        }

        return redirect()->route('admin.plot-and-units.index')->with('success', 'Data updated successfully.');
    }

    public function view($id)
    {
        $plotAndUnit = PlotAndUnit::with('members')->findOrFail($id);
        return view('admin.plot_and_units.view', compact('plotAndUnit'));
    }

    public function destroy($id)
    {
        $plotAndUnit = PlotAndUnit::with('members')->findOrFail($id);

        // Delete related members
        $plotAndUnit->members()->delete();

        // Delete plot/unit
        $plotAndUnit->delete();

        return redirect()
            ->route('admin.plot-and-units.index')
            ->with('success', 'Data deleted successfully.');
    }
}
