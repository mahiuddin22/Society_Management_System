<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->input('name');
        $permissionId = $request->input('permission_id');
        $menu_type = $request->input('menu_type');

        $data['permissionsearch']   = Permission::all();
        $permissions                = Permission::orderBy('order_no', 'asc');

        if (!empty($name)) {
            $permissions = $permissions->where('name', 'like', '%' . $name . '%');
        }

        if (!empty($permissionId)) {
            $permissions = $permissions->where('id', $permissionId);
        }

        if (!empty($menu_type)) {
            $permissions = $permissions->where('menu_type', $menu_type);
        }

        $data['name']           = $request->input('name');
        $data['permissionId']   = $request->input('permission_id');
        $data['menu_type']      = $request->input('menu_type');
        $data['activities']     = Activity::all();

        $data['permissions']    = $permissions->paginate(30);
        return view('admin.permissions.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'menu_type' => 'required',
            'menu_key'  => 'required_if:menu_type,sub_menu|nullable|string|unique:permissions,menu_key',
        ]);

        Permission::create([
            'name'          => ucwords($request->name),
            'menu_key'      => $request->menu_type === 'sub_menu' ? strtolower($request->menu_key) : null,
            'menu_type'     => $request->menu_type,
            'activity_id'   => $request->menu_type === 'sub_menu' ? implode(',', $request->activities) : null,
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        if($permission->activity_id) {
            $activities = Activity::whereIn('id', explode(',', $permission->activity_id))->get();
        } else {
            $activities = Activity::all();
        }
        return view('admin.permissions.edit', compact('permission', 'activities'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'menu_type' => 'required',
        ]);

        $permission = Permission::findOrFail($id);

        $permission->update([
            'name'          => ucwords($request->name),
            'menu_key'      => $request->menu_type === 'sub_menu' ? strtolower($request->menu_key) : null,
            'menu_type'     => $request->menu_type,
            'activity_id'   => $request->menu_type === 'sub_menu' ? implode(',', $request->activities) : null,
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully.');
    }


    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully.');
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $item) {
            Permission::where('id', $item['id'])->update(['order_no' => $item['order_no']]);
        }
        return response()->json(['status' => 'success']);
    }
}
