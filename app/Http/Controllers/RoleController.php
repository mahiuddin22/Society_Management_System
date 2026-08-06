<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->input('name');
        $roles = Role::when($name, function ($query, $name) {
            return $query->where('name', 'like', "%{$name}%");
        })->paginate(10);
        // Logic to display roles
        return view('admin.roles.index', compact('roles', 'name'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ], [
            'name.required' => 'Please enter a role name.',
            'name.string'   => 'The role name must be text.',
            'name.unique'   => 'This role ' . $request->name . ' already exists.',
        ]);

        Role::create([
            'name' => strtolower($request->name),
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }


    public function edit($id)
    {
        $role = Role::findOrFail($id);
        // Check if the role exists
        if (!$role) {
            return redirect()->route('admin.roles.index')->with('error', 'Role not found.');
        }

        // Logic to show the edit form for a role
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        // Logic to update a role
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
        ], [
            'name.required' => 'Please enter a role name.',
            'name.string'   => 'The role name must be text.',
            'name.unique'   => 'This role ' . $request->name . ' already exists.',
        ]);

        $role->update([
            'name' => strtolower($request->name),
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        // Logic to delete a role
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
