<?php

/*
|--------------------------------------------------------------------------
| Validation Language Lines
|--------------------------------------------------------------------------
|
| Solo se traducen las reglas que usa la aplicación; el resto cae al inglés
| (fallback_locale). Los nombres de los campos propios se definen en el
| método attributes() de cada Form Request.
|
*/

return [

    'alpha' => 'El campo :attribute solo puede contener letras.',
    'confirmed' => 'La confirmación de :attribute no coincide.',
    'current_password' => 'La contraseña es incorrecta.',
    'email' => 'El campo :attribute debe ser un correo válido.',
    'exists' => 'El :attribute seleccionado no existe.',
    'integer' => 'El campo :attribute no es válido.',
    'lowercase' => 'El campo :attribute debe estar en minúsculas.',
    'max' => [
        'string' => 'El campo :attribute no puede superar :max caracteres.',
    ],
    'min' => [
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'required' => 'El campo :attribute es obligatorio.',
    'size' => [
        'string' => 'El campo :attribute debe tener :size caracteres.',
    ],
    'string' => 'El campo :attribute debe ser texto.',
    'unique' => 'Ya existe un registro con ese :attribute.',

    'attributes' => [
        'name' => 'nombre',
        'email' => 'correo electrónico',
        'password' => 'contraseña',
        'current_password' => 'contraseña actual',
    ],

];
