<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    public function plot()
    {
        return $this->belongsTo(PlotAndUnit::class, 'plot_and_unit_id', 'id');
    }
    
}
