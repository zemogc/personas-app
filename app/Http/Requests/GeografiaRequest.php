<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Base para los formularios del módulo geográfico: centraliza los mensajes
 * de validación en español. Cada subclase define rules() y attributes().
 */
abstract class GeografiaRequest extends FormRequest
{
    /**
     * Get the custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'max' => 'El campo :attribute no puede superar :max caracteres.',
            'size' => 'El campo :attribute debe tener :size caracteres.',
            'alpha' => 'El campo :attribute solo puede contener letras.',
            'integer' => 'El campo :attribute no es válido.',
            'exists' => 'El :attribute seleccionado no existe.',
            'unique' => 'Ya existe un registro con ese :attribute.',
        ];
    }
}
