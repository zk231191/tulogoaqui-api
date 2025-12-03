<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->has('facture_required')) {
            $this->merge([
                'facture_required' => filter_var($this->input('facture_required'), FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }

    public function rules()
    {
        $base = [
            'name'               => 'required|string|max:255',
            'paternal_last_name' => 'nullable|string|max:255',
            'maternal_last_name' => 'nullable|string|max:255',
            'phone'              => 'required|string|max:20',
            'email'              => 'required|email|unique:customers,email,NULL,id,deleted_at,NULL',
            'facture_required'   => 'required|boolean',
        ];

        $facture = (bool) ($this->input('facture_required') ?? false);

        if ($facture) {
            $fiscal = [
                'street'        => 'required|string|max:255',
                'number'        => 'required|string|max:50',
                'neighborhood'  => 'required|string|max:50',
                'city'          => 'required|string|max:255',
                'state'         => 'required|string|max:255',
                'postal_code'   => 'required|string|max:20',
                'rfc'           => 'required|string|max:13|unique:fiscal_addresses,rfc,NULL,id,deleted_at,NULL',
                'business_name' => 'required|string|max:255',
            ];
        } else {
            $fiscal = [
                'street'        => 'nullable|string|max:255',
                'number'        => 'nullable|string|max:50',
                'neighborhood'  => 'nullable|string|max:50',
                'city'          => 'nullable|string|max:255',
                'state'         => 'nullable|string|max:255',
                'postal_code'   => 'nullable|string|max:20',
                'rfc'           => 'nullable|string|max:13',
                'business_name' => 'nullable|string|max:255',
            ];
        }

        return array_merge($base, $fiscal);
    }
}