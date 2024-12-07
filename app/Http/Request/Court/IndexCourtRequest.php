<?php

namespace App\Http\Request\Court;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class IndexCourtRequest extends FormRequest
{
    /**
     * Determine if the reservation is authorized to make this request.
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
            'date' => 'required|date',
            'sport_id' => 'required|exists:sports,id',
            'member_id' => 'required|exists:members,id',
        ];
    }

    protected function passedValidation()
    {
        //dd('Validation passed', $this->all());
    }

    public function messages(): array
    {
        return [
            'date.required' => 'La fecha es obligatoria.',
            'date.date' => 'La fecha debe ser válida.',
            'sport_id.required' => 'El ID del deporte es obligatorio.',
            'sport_id.exists' => 'El deporte seleccionado no existe.',
            'member_id.required' => 'El ID del miembro es obligatorio.',
            'member_id.exists' => 'El miembro seleccionado no existe.',
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
