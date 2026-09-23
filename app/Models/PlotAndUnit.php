<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlotAndUnit extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'plot_and_units';

    public function road()
    {
        return $this->belongsTo(Road::class);
    }

    public function plotType()
    {
        return $this->belongsTo(PlotType::class);
    }
    
    public function bills(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Bill::class);
    }
}
