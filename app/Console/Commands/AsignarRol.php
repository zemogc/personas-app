<?php

namespace App\Console\Commands;

use App\Enums\Rol;
use App\Models\User;
use Illuminate\Console\Command;

class AsignarRol extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'usuario:rol
                            {email : Correo del usuario}
                            {rol : Rol a asignar (admin o lector)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Asigna un rol a un usuario existente';

    public function handle(): int
    {
        $rol = Rol::tryFrom($this->argument('rol'));

        if (! $rol) {
            $validos = implode(', ', array_column(Rol::cases(), 'value'));
            $this->error("Rol no válido. Valores permitidos: {$validos}.");

            return self::INVALID;
        }

        $user = User::where('email', $this->argument('email'))->first();

        if (! $user) {
            $this->error('No existe un usuario con ese correo.');

            return self::FAILURE;
        }

        $user->rol = $rol;
        $user->save();

        $this->info("{$user->email} ahora es {$rol->etiqueta()}.");

        return self::SUCCESS;
    }
}
