<?php

namespace App\Models;

use App\Models\Concerns\Buscable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use Buscable, HasFactory;

    protected $table = 'tb_municipio';

    protected $primaryKey = 'muni_codi';

    public $timestamps = false;

    /** @var string[] Columnas usadas por el scope buscar(). */
    protected array $buscable = ['muni_nomb', 'departamento.depa_nomb'];

    protected $fillable = ['muni_nomb', 'depa_codi'];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'depa_codi', 'depa_codi');
    }

    public function comunas()
    {
        return $this->hasMany(Comuna::class, 'muni_codi', 'muni_codi');
    }
}
