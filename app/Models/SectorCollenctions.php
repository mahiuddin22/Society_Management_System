<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectorCollenctions extends Model
{
    use HasFactory;

    public function members(){
        return $this->belongsTo(Member::class, 'member_id');
    }
}
