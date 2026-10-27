<?php

namespace App\Models;

use App\Models\Concerns\Buscable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comuna extends Model
{
    use Buscable, HasFactory;

    protected $table = 'tb_comuna';

    protected $primaryKey = 'comu_codi';

    public $timestamps = false;

    /** @var string[] Columnas usadas por el scope buscar(). */
    protected array $buscable = ['comu_nomb', 'municipio.muni_nomb'];

    protected $fillable = ['comu_nomb', 'muni_codi'];

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'muni_codi', 'muni_codi');
    }
}
