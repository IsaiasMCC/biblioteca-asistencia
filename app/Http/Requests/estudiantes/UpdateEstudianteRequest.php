<?php

namespace App\Http\Requests\estudiantes;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEstudianteRequest extends FormRequest
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
        $estudianteId = $this->route('estudiante');

        return [
            'registro' => ['required', 'string', 'unique:estudiantes,registro,' . $estudianteId],
            'telefono' => ['nullable', 'regex:/^\d{7,15}$/'],
            'email' => ['required', 'email', 'unique:estudiantes,email,' . $estudianteId],
            'codigo_carrera' => ['required', 'string'],
            'carrera' => ['required', 'string'],
            'genero' => ['required', 'in:masculino,femenino,otro'],
            'foto_url' => ['nullable'],
            'estado' => ['boolean'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }

    public function messages()
    {
        return [
            'registro.required' => 'El número de registro es obligatorio.',
            'registro.unique' => 'El número de registro ya está en uso.',
            'telefono.regex' => 'El teléfono debe tener entre 7 y 15 dígitos numéricos.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo debe tener un formato válido.',
            'email.unique' => 'El correo ya está registrado.',
            'codigo_carrera.required' => 'El código de carrera es obligatorio.',
            'carrera.required' => 'La carrera es obligatoria.',
            'genero.required' => 'El género es obligatorio.',
            'genero.in' => 'El género debe ser masculino, femenino u otro.',
            'estado.boolean' => 'El estado debe ser verdadero o falso.',
            'user_id.required' => 'El ID de usuario es obligatorio.',
            'user_id.exists' => 'El usuario seleccionado no existe.',
        ];
    }
}
