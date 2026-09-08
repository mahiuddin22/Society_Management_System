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

    public function roadaNumber()
    {
        return $this->belongsTo(Road::class, 'road_id', 'id');
    }

    public function plot()
    {
        return $this->belongsTo(PlotAndUnit::class, 'plot_and_unit_id', 'id');
    }

}
