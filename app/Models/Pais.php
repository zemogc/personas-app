<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;

    protected $table = 'tb_pais';
    protected $primaryKey = 'pais_codi';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['pais_codi', 'pais_nomb', 'pais_capi'];

    public function departamentos()
    {
        return $this->hasMany(Departamento::class, 'pais_codi', 'pais_codi');
    }

    public function capital()
    {
        return $this->belongsTo(Municipio::class, 'pais_capi', 'muni_codi');
    }
}
