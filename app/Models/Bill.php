<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'plot_and_unit_id',
        'bill_number',
        'billing_month',
        'due_date',
        'plot_type_name',
        'billing_units',
        'rate_snapshot',
        'discount_snapshot',
        'gross_amount',
        'net_amount',
        'paid_amount',
        'status',
    ];

    protected $casts = [
        'due_date'          => 'date',
        'rate_snapshot'     => 'decimal:2',
        'discount_snapshot' => 'decimal:2',
        'gross_amount'      => 'decimal:2',
        'net_amount'        => 'decimal:2',
        'paid_amount'       => 'decimal:2',
    ];

    public function plotAndUnit(): BelongsTo
    {
        return $this->belongsTo(PlotAndUnit::class, 'plot_and_unit_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function getDueBalanceAttribute(): float
    {
        return max(0, (float)$this->net_amount - (float)$this->paid_amount);
    }
}