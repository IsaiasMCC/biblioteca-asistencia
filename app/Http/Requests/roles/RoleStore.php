<?php

namespace App\Http\Requests\roles;

use Illuminate\Foundation\Http\FormRequest;

class RoleStore extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.string' => 'El nombre del rol debe ser una cadena de texto.',
            'name.max' => 'El nombre del rol no puede exceder los 255 caracteres.',
            'description.required' => 'El nombre del rol es obligatorio.',
            'description.string' => 'La descripción del rol es obligatorio.',
            'description.max' => 'La descripción no puede exceder los 500 caracteres.',
        ];
    }
}
