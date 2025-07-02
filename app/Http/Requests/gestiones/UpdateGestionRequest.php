<?php

namespace App\Http\Requests\gestiones;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGestionRequest extends FormRequest
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
    public function rules()
    {
        return [
            'anio' => ['required', 'digits:4', 'integer', 'min:1900', 'max:2100'],
            'semestre' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'anio.required' => 'El año es obligatorio.',
            'anio.digits' => 'El año debe tener exactamente 4 dígitos.',
            'anio.integer' => 'El año debe ser un número entero.',
            'anio.min' => 'El año no puede ser menor a 1900.',
            'anio.max' => 'El año no puede ser mayor a 2100.',

            'semestre.required' => 'El semestre es obligatorio.',
            'semestre.string' => 'El semestre debe ser string.',
        ];
    }
}
