<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberLoginOtp extends Model
{
    protected $fillable = [
        'user_id',
        'otp_hash',
        'expires_at',
        'attempts',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}