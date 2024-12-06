<?php

namespace App\Http\Request\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'), // Verifica que el email sea único
            ],
            'password' => 'required|min:6',
            'name' => 'required|string|max:100',
        ];
    }

    protected function passedValidation()
    {
        //dd('Validation passed', $this->all());
    }

    // Mensajes de error personalizados (opcional)
    public function messages()
    {
        return [
            'email.unique' => 'El correo ya está registrado.',
            'email.required' => 'El correo es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre debe tener máximo 100 caracteres.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Errores de validación',
            'errors' => $errors
        ], 422));
    }
}
