<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissingFlat extends Model
{
    protected $guarded = [];

    public function plotAndUnit()
    {
        return $this->belongsTo(PlotAndUnit::class);
    }
}
