<?php

namespace App\Http\Requests\credenciales;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCredencialRequest extends FormRequest
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
            'fecha_emicion' => 'required|date',
            'fecha_expiracion' => 'required|date|after_or_equal:fecha_emicion',
            'estado' => 'required|boolean',
            // 'gestion_id' => 'required|exists:gestiones,id',
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_emicion.required' => 'La fecha de emisión es obligatoria.',
            'fecha_emicion.date' => 'La fecha de emisión no es válida.',
            'fecha_expiracion.required' => 'La fecha de expiración es obligatoria.',
            'fecha_expiracion.after_or_equal' => 'La fecha de expiración debe ser posterior o igual a la de emisión.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.boolean' => 'El estado debe ser verdadero o falso.',
            // 'gestion_id.required' => 'Debe seleccionar una gestión.',
            // 'gestion_id.exists' => 'La gestión seleccionada no existe.',
        ];
    }
}
