<?php

namespace App\Http\Request\Reservation;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class IndexReservationRequest extends FormRequest
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
