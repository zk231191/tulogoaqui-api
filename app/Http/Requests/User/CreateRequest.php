<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'username' => 'required|string|max:255|unique:users',
            'role_name' => 'nullable|string|exists:roles,name'
        ];
    }

    public function messages(): array
    {
        return [
            'name' => [
                'required' => 'El nombre es campo obligatorio.',
                'max' => 'El nombre no puede tener mas de :max caracteres.',
            ],
            'email' => [
                'required' => 'El correo electrónico es campo obligatorio.',
                'max' => 'El correo electrónico no puede tener mas de :max caracteres.',
                'unique' => 'El correo electrónico ingresado ya esta en uso.',
            ],
            'password' => [
                'required' => 'La contraseña es requerida.',
                'min' => 'La contraseña debe tener al menos :min caracteres.',
            ],
            'username' => [
                'required' => 'El nombre de usuario es requerido.',
                'unique' => 'El nombre de usuario ingresado ya esta en uso.',
                'max' => 'El nombre de usuario no puede tener mas de :max caracteres.',
            ],
            'role_name.exists' => 'El rol seleccionado no existe.',
        ];
    }
}
