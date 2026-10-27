<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * Búsqueda por texto sobre las columnas declaradas en $buscable.
 *
 * Admite columnas propias ('pais_nomb') y de relaciones con notación de
 * punto ('pais.pais_nomb'). Los comodines de LIKE del término se escapan
 * para que '%' o '_' se busquen de forma literal.
 */
trait Buscable
{
    public function scopeBuscar(Builder $query, ?string $termino): Builder
    {
        $termino = trim((string) $termino);

        if ($termino === '') {
            return $query;
        }

        // SQLite no define un carácter de escape por defecto y MySQL usa '\',
        // así que se declara uno explícito que funciona igual en ambos.
        $patron = '%'.str_replace(['!', '%', '_'], ['!!', '!%', '!_'], $termino).'%';

        return $query->where(function (Builder $query) use ($patron) {
            foreach ($this->buscable as $columna) {
                if (Str::contains($columna, '.')) {
                    [$relacion, $columnaRelacion] = explode('.', $columna, 2);

                    $query->orWhereHas($relacion, fn (Builder $q) => $this->whereLike($q, $columnaRelacion, $patron));
                } else {
                    $query->orWhere(fn (Builder $q) => $this->whereLike($q, $columna, $patron));
                }
            }
        });
    }

    private function whereLike(Builder $query, string $columna, string $patron): Builder
    {
        $columna = $query->getQuery()->getGrammar()->wrap($columna);

        return $query->whereRaw("{$columna} like ? escape '!'", [$patron]);
    }
}
