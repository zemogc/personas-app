<?php

namespace App\Models;

use App\Models\Concerns\Buscable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use Buscable, HasFactory;

    protected $table = 'tb_departamento';

    protected $primaryKey = 'depa_codi';

    public $timestamps = false;

    /** @var string[] Columnas usadas por el scope buscar(). */
    protected array $buscable = ['depa_nomb', 'pais.pais_nomb'];

    protected $fillable = ['depa_nomb', 'pais_codi'];

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_codi', 'pais_codi');
    }

    public function municipios()
    {
        return $this->hasMany(Municipio::class, 'depa_codi', 'depa_codi');
    }
}
