<?php 

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePlotAndUnitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Sanitize and format data before running the validator.
     */
    protected function prepareForValidation(): void
    {
        // Sanitize flat tags: uppercase, trim, remove empty & duplicates
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

        // Default discount to 0 if left empty
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

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // 1. Property Identity & Location
            'plot_type'          => ['required', 'integer', 'exists:plot_types,id'],
            'road'               => ['required', 'exists:roads,id'],
            'holding_no'         => ['required', 'string', 'max:20'],
            'building_name'      => ['nullable', 'string', 'max:100'],

            // 2. Flats & Occupancy
            'total_flat'    => ['required_if:plot_type,3,4,5', 'nullable', 'integer', 'min:0', 'max:65535'],
            'occupied_flat' => ['required_if:plot_type,3,4,5', 'nullable', 'integer', 'min:0', 'lte:total_flat'],
            'collection_type'    => ['required', Rule::in(['Group', 'Individual'])],
            'flat_numbers'       => ['nullable', 'string'],

            // 3. Contact Representative
            'flat_no'            => ['nullable', 'string', 'max:30'],
            'name'               => ['required', 'string', 'max:100'],
            'phone'             => ['required', 'string', 'max:20'],
            'email'              => ['nullable', 'email:rfc,dns', 'max:254'],
            'status'             => ['required', Rule::in(['Active', 'Inactive'])],

            // 4. Financial Calculations
            'custom_rate_toggle' => ['nullable', 'in:1,true,on'],
            'collection_rate'    => ['required', 'numeric', 'min:0'],
            'discount'           => ['nullable', 'numeric', 'min:0'],
            'collection_amount'  => ['required', 'numeric', 'min:0'],
        ];
    }

    /**
     * Post-validation cross-field integrity check.
     * Verifies that the submitted total matches:
     * (collection_rate * (occupied_flat > 0 ? occupied_flat : 1)) - discount
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $rate           = (float) ($this->collection_rate ?? 0);
            $occupied       = (int) ($this->occupied_flat ?? 0);
            $discount       = (float) ($this->discount ?? 0);
            $submittedTotal = (float) ($this->collection_amount ?? 0);

            // If 0 flats occupied (vacant or under construction), evaluate as 1 unit
            $billingUnits   = $occupied > 0 ? $occupied : 1;
            $expectedTotal  = max(0, ($rate * $billingUnits) - $discount);

            // Allow 0.01 tolerance for client/server floating-point rounding
            if (abs($expectedTotal - $submittedTotal) > 0.01) {
                // dd('ok');
                $validator->errors()->add(
                    'collection_amount',
                    'The submitted collection amount does not match the calculated fee of ৳' . number_format($expectedTotal, 2) . '.'
                );
            }
        });
    }

    /**
     * Friendly attribute names for clean UI error messages.
     */
    public function attributes(): array
    {
        return [
            'plot_type'          => 'plot type',
            'road'               => 'road',
            'holding_no'         => 'holding number',
            'building_name'      => 'building name',
            'total_flat'         => 'total flats',
            'occupied_flat'      => 'occupied flats',
            'collection_type'    => 'collection mode',
            'flat_numbers'       => 'flat numbers',
            'flat_no'            => 'flat number',
            'name'               => 'contact person name',
            'phone'             => 'phone number',
            'email'              => 'email address',
            'status'             => 'status',
            'collection_rate'    => 'rate per unit',
            'discount'           => 'discount',
            'collection_amount'  => 'total collection amount',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'occupied_flat.lte'   => 'Occupied flats cannot be greater than total flats.',
            'collection_rate.min' => 'Rate per unit cannot be negative.',
            'discount.min'        => 'Discount cannot be negative.',
        ];
    }
}