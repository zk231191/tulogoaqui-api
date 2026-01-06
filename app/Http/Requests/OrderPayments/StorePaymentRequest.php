<?php

namespace App\Http\Requests\OrderPayments;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
            'amount' => 'required|numeric|min:1',
            'method_id' => 'required|exists:payment_methods,id',
            'reference' => 'nullable|string',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $order = $this->route('order');
            $amount = $this->input('amount');

            if($order && $amount > $order->pending_amount) {
                $validator->errors()->add(
                    'amount',
                    'El monto no puede ser mayor al pago pendiente'
                );
            }
        });
    }
}
