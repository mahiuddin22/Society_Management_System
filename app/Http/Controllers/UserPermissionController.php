<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permission;
use App\Models\Activity;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class UserPermissionController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('admin.UserPermissions.user_permissions', compact('users'));
    }

    public function getUserPermissions(Request $request)
    {
        $userId = $request->user_id;
        $user   = User::findOrFail($userId);

        $permissions = Permission::orderBy('order_no', 'asc')->get();
        $activities  = Activity::all();

        // Role-based permissions
        $rolePermissions = RolePermission::where('role', $user->role)
            ->whereNull('user_id')
            ->get()
            ->map(fn($item) => $item->permission_id . '_' . $item->activity_id)
            ->toArray();

        // User-specific permissions (overrides)
        $userPermissions = RolePermission::where('user_id', $userId)
            ->get()
            ->map(fn($item) => $item->permission_id . '_' . $item->activity_id)
            ->toArray();

        // Merge: User-specific wins over role-based
        $mergedPermissions = array_unique(array_merge($rolePermissions, $userPermissions));

        return view('admin.UserPermissions.permissions_table', compact(
            'permissions',
            'activities',
            'userId',
            'mergedPermissions',  // used for pre-checking
            'userPermissions'     // used for knowing what's user-specific
        ))->render();
    }


    public function update(Request $request)
    {
        $userId = $request->input('user_id');
        $permissionsData = $request->input('permissions', []);

        // Remove old user-specific permissions
        RolePermission::where('user_id', $userId)->delete();

        $insertData = [];

        foreach ($permissionsData as $permissionId => $activities) {
            foreach ($activities as $activityId => $value) {
                if ($value) {
                    $menuKey = Permission::find($permissionId)->menu_key ?? null;
                    $insertData[] = [
                        'user_id'       => $userId,
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

        return redirect()->route('admin.user-permissions.index')
            ->with('success', 'User permissions updated successfully.');
    }
}
