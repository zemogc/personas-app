<?php

namespace App\Enums;

enum Rol: string
{
    /** Puede crear, editar y eliminar registros del módulo geográfico. */
    case Admin = 'admin';

    /** Solo puede consultar los listados. */
    case Lector = 'lector';

    public function etiqueta(): string
    {
        return match ($this) {
            self::Admin => 'Administrador',
            self::Lector => 'Lector',
        };
    }
}
