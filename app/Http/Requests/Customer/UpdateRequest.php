<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Customer;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // soporta route-model-binding: $this->route('customer') puede ser el id o el modelo
        $customerParam = $this->route('customer');

        if ($customerParam instanceof Customer) {
            $customer = $customerParam->loadMissing('address');
            $id = $customer->id;
        } else {
            $id = $customerParam;
            $customer = $id ? Customer::with('address')->find($id) : null;
        }

        $base = [
            'name'               => 'required|string|max:255',
            'paternal_last_name' => 'nullable|string|max:255',
            'maternal_last_name' => 'nullable|string|max:255',
            'phone'              => 'required|string|max:20',
            'email'              => "required|email|unique:customers,email,{$id},id,deleted_at,NULL",
            'facture_required'   => 'sometimes|boolean',
        ];

        $provided = $this->has('facture_required') ? filter_var($this->input('facture_required'), FILTER_VALIDATE_BOOLEAN) : null;
        $facture = $provided !== null ? $provided : (bool) ($customer->facture_required ?? false);

        $addressId = $customer && $customer->address ? $customer->address->id : null;

        if ($facture) {
            $rfcRule = $addressId
                ? "required|string|max:13|unique:fiscal_addresses,rfc,{$addressId},id,deleted_at,NULL"
                : 'required|string|max:13|unique:fiscal_addresses,rfc,NULL,id,deleted_at,NULL';

            $fiscal = [
                'street'        => 'required|string|max:255',
                'number'        => 'required|string|max:50',
                'neighborhood'  => 'required|string|max:50',
                'city'          => 'required|string|max:255',
                'state'         => 'required|string|max:255',
                'postal_code'   => 'required|string|max:20',
                'rfc'           => $rfcRule,
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

    protected function prepareForValidation()
    {
        if ($this->has('facture_required')) {
            $this->merge([
                'facture_required' => filter_var($this->input('facture_required'), FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }
}