<?php

namespace App\Http\Requests\FiscalAddress;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'required|integer|exists:customers,id',
            'business_name' => 'required|string|max:255',
            'tax_identification_number' => 'required|string|size:13',
            'tax_regime_id' => 'required|exists:sat_regimes,id',
            'street' => 'required|string|max:255',
            'external_number' => 'required|integer',
            'internal_number' => 'nullable|string|max:5',
            'zip_code' => 'required|string|size:5',
            'suburb' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'email' => 'email|string|max:100',
        ];
    }
}
