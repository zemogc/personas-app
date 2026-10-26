<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comuna extends Model
{
    use HasFactory;

    protected $table = 'tb_comuna';

    protected $primaryKey = 'comu_codi';

    public $timestamps = false;

    protected $fillable = ['comu_nomb', 'muni_codi'];

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'muni_codi', 'muni_codi');
    }
}
