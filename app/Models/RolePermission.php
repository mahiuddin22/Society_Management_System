<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'role',
        'user_id',
        'permission_id',
        'activity_id',
        'menu_key',
    ];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
