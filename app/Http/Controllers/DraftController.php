<?php

namespace App\Http\Controllers;

use App\Models\Draft;
use Illuminate\Http\Request;

class DraftController extends Controller
{
    public function index(Request $request)
    {
        $query = Draft::query();

        if ($request->filled('type')) {
            $query->where('type', 'like', '%' . $request->type . '%');
        }

        if ($request->filled('message')) {
            $query->where('message', 'like', '%' . $request->message . '%');
        }

        if ($request->filled('language')) {
            $query->where('language', $request->language);
        }

        if ($request->filled('length')) {
            $query->where('length', $request->length);
        }

        $drafts = $query->latest()->paginate(25);

        return view('admin.draft_sms.index', compact('drafts'));
    }

    public function create()
    {
        return view('admin.draft_sms.create');
    }

    public function store(Request $request)
    {
        $type       = $request->type;
        $language   = $request->language;
        $message    = $request->message;
        $sms_length = strlen($message);
        $request->validate([
            'type'      => 'required|string|unique:drafts,type',
            'language'  => 'required|string',
            'message'   => 'required',
        ]);

        Draft::create([
            'type'      => $type,
            'language'  => $language,
            'message'   => $message,
            'length'    => $sms_length,
        ]);

        return redirect()->route('admin.draft.index')->with('success', 'Draft created successfully.');
    }

    public function edit($id)
    {
        $data['draft'] = Draft::findOrFail($id);
        return view('admin.draft_sms.edit', $data);
    }

    public function update(Request $request, $id)
    {

        $type       = $request->type;
        $language   = $request->language;
        $message    = $request->message;
        $sms_length = strlen($message);

        $request->validate([
            'type'      => 'required|string|unique:drafts,type,' . $id,
            'language'  => 'required|string',
            'message'   => 'required',
        ]);

        Draft::findOrFail($id)->update([
            'type'      => $type,
            'language'  => $language,
            'message'   => $message,
            'length'    => $sms_length,
        ]);

        return redirect()->route('admin.draft.index')->with('success', 'Draft updated successfully.');
    }

    public function destroy($id)
    {
        Draft::findOrFail($id)->delete();
        return redirect()->route('admin.draft.index')->with('success', 'Draft deleted successfully.');
    }
}
