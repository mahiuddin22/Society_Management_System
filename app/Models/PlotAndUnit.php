<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlotAndUnit extends Model
{
    use HasFactory;

    public function unit_road()
    {
        return $this->belongsTo(Road::class, 'road');
    }

    public function members()
    {
        return $this->hasMany(Member::class, 'plot_and_unit_id');
    }

    public function plot_type()
    {
        return $this->belongsTo(PlotType::class, 'building_type');
    }
    
}
