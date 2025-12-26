<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'customer.id' => ['required', 'exists:customers,id'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.service_id' => ['required', 'exists:services,id'],
            'items.*.mode_id' => ['required', 'exists:service_modes,id'],
            'items.*.price_id' => ['required', 'array', 'min:1'],
            'items.*.price_id.*' => ['exists:service_price_tiers,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.comments' => ['nullable', 'string'],

            'notes' => ['nullable', 'string'],
            'delivery_date' => ['nullable', 'date'],

            'requires_invoice' => ['boolean'],
            'fiscal_address_id' => ['nullable', 'exists:fiscal_addresses,id'],

            'billing_data' => ['nullable', 'array'],
            'billing_data.tax_identification_number' => ['required_if:requires_invoice,true'],
            'billing_data.business_name' => ['required_if:requires_invoice,true'],
            'billing_data.zip_code' => ['required_if:requires_invoice,true'],
            'billing_data.street' => ['required_if:requires_invoice,true'],
            'billing_data.external_number' => ['required_if:requires_invoice,true'],
            'billing_data.email' => ['required_if:requires_invoice,true', 'email'],
            'billing_data.tax_regime' => ['required_if:requires_invoice,true', 'exists:sat_regimes,id'],

            'cfdi_use' => ['nullable', 'required_if:requires_invoice,true', 'exists:sat_cfdi_uses,id'],

            'discount' => ['nullable', 'numeric', 'min:0'],
            'deposit' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
