<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $customerId = $this->route('customer')->id;

        return [
            'name' => ['required', 'string'],
            'last_name' => ['required' ,'string'],
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('customers', 'email')->ignore($customerId),
            ],
            'phone' => [
                'required',
                'string',
                Rule::unique('customers', 'phone')->ignore($customerId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'last_name.required' => 'El apellido es obligatorio',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El formato de correo electrónico no es válido',
            'email.unique' => 'El correo electrónico ya existe',
            'phone.required' => 'El teléfono es obligatorio',
            'phone.unique' => 'El teléfono ya existe',
        ];
    }
}
