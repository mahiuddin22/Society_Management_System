<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    // Main page: only send roles
    public function index()
    {
        $roles = User::distinct('role')->pluck('role')->toArray();
        return view('admin.RoleAndPermissions.role_permissions', compact('roles'));
    }

    // AJAX: get permissions table for selected role
    public function getRolePermissions(Request $request)
    {
        $role = $request->role;

        $permissions = Permission::orderBy('order_no', 'asc')->get();
        $activities  = Activity::all();

        // Get assigned role permissions
        $rolePermissions = RolePermission::where('role', $role)->get()
            ->map(function ($item) {
                return $item->permission_id . '_' . $item->activity_id;
            })->toArray();

        return view('admin.RoleAndPermissions.permissions_table', compact(
            'permissions',
            'activities',
            'role',
            'rolePermissions' // pass to view
        ))->render();
    }

    public function update(Request $request)
    {
        $role = $request->input('role');
        $permissionsData = $request->input('permissions', []);
        $applyForAll = $request->has('apply_for_all'); // checkbox

        // If "Apply for all" checked, remove user-specific permissions for this role
        if ($applyForAll) {
            RolePermission::whereNull('role')->whereIn('user_id', function ($query) use ($role) {
                $query->select('id')->from('users')->where('role', $role); // only users of this role
            })->delete();
        }

        // Remove old role permissions
        RolePermission::where('role', $role)->delete();

        $insertData = [];

        foreach ($permissionsData as $permissionId => $activities) {
            foreach ($activities as $activityId => $value) {
                if ($value) {
                    $menuKey = Permission::find($permissionId)->menu_key ?? null;

                    $insertData[] = [
                        'role'          => $role,
                        'user_id'       => null, // keep it null for role permissions
                        'permission_id' => $permissionId,
                        'activity_id'   => $activityId,
                        'menu_key'      => $menuKey,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ];
                }
            }
        }

        if (!empty($insertData)) {
            RolePermission::insert($insertData);
        }

        return redirect()->route('admin.role-permissions.index')->with('success', 'Permissions updated successfully.');
    }
}
