<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Menú del módulo geográfico
    |--------------------------------------------------------------------------
    |
    | Recursos que aparecen en la barra de navegación, en orden jerárquico.
    | La llave es el prefijo de la ruta resource y el valor es su etiqueta.
    |
    */

    'menu' => [
        'paises' => 'Países',
        'departamentos' => 'Departamentos',
        'municipios' => 'Municipios',
        'comunas' => 'Comunas',
    ],

    /*
    |--------------------------------------------------------------------------
    | Registros por página
    |--------------------------------------------------------------------------
    */

    'por_pagina' => (int) env('GEOGRAFIA_POR_PAGINA', 15),

];
