<?php

use App\Models\RolePermission;
use App\Models\Permission;
use App\Models\Activity;

if (!function_exists('hasPermission')) {
    function hasPermission($menuKey, $activityKey = 'access')
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }

        // Find permission ID by menu_key
        $permissionId = Permission::where('menu_key', $menuKey)->value('id');
        if (!$permissionId) {
            return false;
        }

        // Find activity ID by activity_key
        $activityId = Activity::where('activity_key', $activityKey)->value('id');
        if (!$activityId) {
            return false;
        }

        // 1. User-specific check
        if (RolePermission::where('user_id', $user->id)
            ->where('permission_id', $permissionId)
            ->where('activity_id', $activityId)
            ->exists()
        ) {
            return true;
        }

        // 2. Role-based check
        return RolePermission::where('role', $user->role)
            ->whereNull('user_id')
            ->where('permission_id', $permissionId)
            ->where('activity_id', $activityId)
            ->exists();
    }

    
}
