<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlotType extends Model
{
    use HasFactory;
    protected $fillable = ['name','amount','status'];

    public function plotAndUnits()
    {
        return $this->hasMany(PlotAndUnit::class);
    }
}
