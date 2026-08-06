<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\RolePermission;
use App\Models\Permission;
use App\Models\Activity;

class CheckPermission
{
    public function handle($request, Closure $next, $menuKey, $activityKey = null)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $permission = Permission::where('menu_key', $menuKey)->first();
        if (!$permission) {
            abort(403, 'Invalid Permission Setup');
        }

        if (!$activityKey) {
            $activityKey = 'access';
        }

        $activity = Activity::where('activity_key', $activityKey)->first();
        if (!$activity) {
            abort(403, 'Invalid Activity Setup');
        }

        // ✅ 1. Check user-specific permission
        $userPermissionExists = RolePermission::where('user_id', $user->id)
            ->where('permission_id', $permission->id)
            ->where('activity_id', $activity->id)
            ->exists();

        if ($userPermissionExists) {
            return $next($request); // allow user if explicit permission exists
        }

        // ✅ 2. Fallback: check role-based permission
        $rolePermissionExists = RolePermission::where('role', $user->role)
            ->whereNull('user_id') // ensure this is role-based entry
            ->where('permission_id', $permission->id)
            ->where('activity_id', $activity->id)
            ->exists();

        if (!$rolePermissionExists) {
            abort(403, 'You do not have permission.');
        }

        return $next($request);
    }
}
