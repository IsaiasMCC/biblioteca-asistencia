<?php

namespace App\Http\Requests\horarios;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHorarioRequest extends FormRequest
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
            'lunes' => 'nullable|boolean',
            'martes' => 'nullable|boolean',
            'miercoles' => 'nullable|boolean',
            'jueves' => 'nullable|boolean',
            'viernes' => 'nullable|boolean',
            'sabado' => 'nullable|boolean',
            'domingo' => 'nullable|boolean',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'sala_id' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'lunes.boolean' => 'El campo lunes debe ser verdadero o falso.',
            'martes.boolean' => 'El campo martes debe ser verdadero o falso.',
            'miercoles.boolean' => 'El campo miércoles debe ser verdadero o falso.',
            'jueves.boolean' => 'El campo jueves debe ser verdadero o falso.',
            'viernes.boolean' => 'El campo viernes debe ser verdadero o falso.',
            'sabado.boolean' => 'El campo sábado debe ser verdadero o falso.',
            'domingo.boolean' => 'El campo domingo debe ser verdadero o falso.',
            'hora_inicio.date_format' => 'La hora de inicio debe estar en formato HH:MM (24 horas).',
            'hora_fin.date_format' => 'La hora de fin debe estar en formato HH:MM (24 horas).',
            'hora_fin.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
            'sala_id.required' => 'La Sala del horario es obligatorio.'
        ];
    }
}
