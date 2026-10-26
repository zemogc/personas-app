<?php

namespace Tests\Feature;

use App\Models\Comuna;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Pais;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GeografiaRelationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_las_relaciones_recorren_la_jerarquia()
    {
        $comuna = Comuna::factory()->create();

        $municipio = $comuna->municipio;
        $departamento = $municipio->departamento;
        $pais = $departamento->pais;

        $this->assertInstanceOf(Municipio::class, $municipio);
        $this->assertInstanceOf(Departamento::class, $departamento);
        $this->assertInstanceOf(Pais::class, $pais);
        $this->assertTrue($pais->departamentos->contains($departamento));
        $this->assertTrue($municipio->comunas->contains($comuna));
    }

    public function test_la_llave_primaria_de_pais_es_un_codigo_de_texto()
    {
        Pais::factory()->create(['pais_codi' => 'COL']);

        $this->assertSame('COL', Pais::findOrFail('COL')->getKey());
    }

    public function test_no_se_puede_eliminar_un_pais_con_departamentos()
    {
        $departamento = Departamento::factory()->create();

        $this->expectException(QueryException::class);

        $departamento->pais->delete();
    }
}
