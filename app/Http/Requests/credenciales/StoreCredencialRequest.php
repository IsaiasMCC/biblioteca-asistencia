<?php

namespace App\Http\Requests\credenciales;

use Illuminate\Foundation\Http\FormRequest;

class StoreCredencialRequest extends FormRequest
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
            'codigo' => 'required|string|unique:credenciales,codigo|max:255',
            // 'foto_qr' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'fecha_emicion' => 'required|date',
            'fecha_expiracion' => 'required|date|after_or_equal:fecha_emicion',
            'estado' => 'required|boolean',
            'usuario_id' => 'required|exists:users,id',
            'gestion_id' => 'required|exists:gestiones,id',
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.required' => 'El código es obligatorio.',
            'codigo.unique' => 'Este código ya está en uso.',
            // 'foto_qr.image' => 'El archivo debe ser una imagen.',
            // 'foto_qr.mimes' => 'La imagen debe ser de tipo jpg, jpeg, png o webp.',
            // 'foto_qr.max' => 'La imagen no debe exceder los 2MB.',
            'fecha_emicion.required' => 'La fecha de emisión es obligatoria.',
            'fecha_emicion.date' => 'La fecha de emisión no es válida.',
            'fecha_expiracion.required' => 'La fecha de expiración es obligatoria.',
            'fecha_expiracion.after_or_equal' => 'La fecha de expiración debe ser posterior o igual a la de emisión.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.boolean' => 'El estado debe ser verdadero o falso.',
            'usuario_id.required' => 'Debe seleccionar un usuario.',
            'usuario_id.exists' => 'El usuario seleccionado no existe.',
            'gestion_id.required' => 'Debe seleccionar una gestión.',
            'gestion_id.exists' => 'La gestión seleccionada no existe.',
        ];
    }
}
