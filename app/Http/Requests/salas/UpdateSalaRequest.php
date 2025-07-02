<?php

namespace App\Http\Requests\salas;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSalaRequest extends FormRequest
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
            'nombre' => 'required|string|max:255',
            'capacidad' => 'required|integer|min:1',
            'ubicacion' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'estado' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre de la sala es obligatorio.',
            'capacidad.required' => 'La capacidad de la sala es obligatoria.',
            'capacidad.integer' => 'La capacidad debe ser un número entero.',
            'capacidad.min' => 'La capacidad debe ser al menos 1.',
            'ubicacion.string' => 'La ubicación debe ser una cadena de texto.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'estado.required' => 'El estado de la sala es obligatorio.',
            'estado.boolean' => 'El estado debe ser verdadero o falso.',
        ];
    }
}
