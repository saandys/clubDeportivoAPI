<?php

namespace App\Http\Request\Member;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateMemberRequest extends FormRequest
{
    /**
     * Determine if the member is authorized to make this request.
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
            ],
            'name' => 'required|string|max:100',
            'phone' => 'required|numeric|digits_between:8,15',
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
            'phone.required' => 'La contraseña es obligatoria.',
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
