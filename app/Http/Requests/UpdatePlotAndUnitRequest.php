<?php

namespace App\Http\Requests;

use App\Models\PlotType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePlotAndUnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('flat_numbers') && is_string($this->flat_numbers)) {
            $cleaned = collect(explode(',', $this->flat_numbers))
                ->map(fn ($item) => trim(strtoupper($item)))
                ->filter()
                ->unique()
                ->implode(',');

            $this->merge([
                'flat_numbers' => $cleaned ?: null,
            ]);
        }

        if (! $this->filled('discount')) {
            $this->merge([
                'discount' => 0,
            ]);
        }

        // If holding_no is a single digit 1 to 9 (e.g., '1', ' 5 '), prepend '0' -> '01', '05'
        if ($this->has('holding_no') && is_string($this->holding_no)) {
            $holding = trim($this->holding_no);
            if (preg_match('/^[1-9]$/', $holding)) {
                $holding = '0' . $holding;
            }

            $this->merge([
                'holding_no' => $holding,
            ]);
        }
    }

    public function rules(): array
    {
        $selectedPlotType = PlotType::find($this->plot_type);
        $isExempt = in_array($selectedPlotType?->slug, ['under-construction', 'empty-plot']);

        return [
            // 1. Property Identity & Location
            'plot_type'          => ['required', 'integer', 'exists:plot_types,id'],
            'road'               => ['required', 'exists:roads,id'],
            'holding_no'         => ['required', 'string', 'max:20'],
            'building_name'      => ['nullable', 'string', 'max:100'],

            // 2. Flats & Occupancy (Optional for land / under-construction)
            'total_flat'         => [
                $isExempt ? 'nullable' : 'required',
                'integer',
                'min:0',
                'max:65535',
            ],
            'occupied_flat'      => [
                $isExempt ? 'nullable' : 'required',
                'integer',
                'min:0',
                'lte:total_flat',
            ],
            'collection_type' => ['nullable', 'required_if:plot_type,2,3,4,5', Rule::in(['Group', 'Individual'])],

            'flat_numbers'       => ['nullable', 'string'],

            // 3. Contact Representative
            'flat_no'            => ['nullable', 'string', 'max:30'],
            'name'               => ['required', 'string', 'max:100'],
            'phone'              => ['required', 'string', 'max:20'],
            'email'              => ['nullable', 'email', 'max:254'],
            'status'             => ['required', Rule::in(['Active', 'Inactive'])],

            // 4. Financial Calculations
            'custom_rate_toggle' => ['nullable', 'in:1,true,on'],
            'collection_rate'    => ['required', 'numeric', 'min:0'],
            'discount'           => ['nullable', 'numeric', 'min:0'],
            'collection_amount'  => ['required', 'numeric', 'min:0'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $rate           = (float) ($this->collection_rate ?? 0);
            $occupied       = (int) ($this->occupied_flat ?? 0);
            $discount       = (float) ($this->discount ?? 0);
            $submittedTotal = (float) ($this->collection_amount ?? 0);

            $billingUnits   = $occupied > 0 ? $occupied : 1;
            $expectedTotal  = max(0, ($rate * $billingUnits) - $discount);

            if (abs($expectedTotal - $submittedTotal) > 0.01) {
                $validator->errors()->add(
                    'collection_amount',
                    'The submitted collection amount does not match the calculated fee of ৳' . number_format($expectedTotal, 2) . '.'
                );
            }
        });
    }

    public function attributes(): array
    {
        return [
            'plot_type'         => 'plot type',
            'road'              => 'road',
            'holding_no'        => 'holding number',
            'building_name'     => 'building name',
            'total_flat'        => 'total flats',
            'occupied_flat'     => 'occupied flats',
            'collection_type'   => 'collection mode',
            'flat_numbers'      => 'flat numbers',
            'flat_no'           => 'flat number',
            'name'              => 'contact person name',
            'phone'             => 'phone number',
            'email'             => 'email address',
            'status'            => 'status',
            'collection_rate'   => 'rate per unit',
            'discount'          => 'discount',
            'collection_amount' => 'total collection amount',
        ];
    }
}