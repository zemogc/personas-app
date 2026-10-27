<?php

namespace Tests\Feature\Geografia;

use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Pais;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaisTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }

    public function test_lista_los_paises_con_su_capital()
    {
        $capital = Municipio::factory()->create(['muni_nomb' => 'Bogotá']);
        Pais::factory()->create(['pais_nomb' => 'Colombia', 'pais_capi' => $capital->muni_codi]);

        $this->get(route('paises.index'))
            ->assertOk()
            ->assertSeeInOrder(['Colombia', 'Bogotá']);
    }

    public function test_busca_por_nombre_o_codigo()
    {
        Pais::factory()->create(['pais_codi' => 'COL', 'pais_nomb' => 'Colombia']);
        Pais::factory()->create(['pais_codi' => 'PER', 'pais_nomb' => 'Perú']);

        $this->get(route('paises.index', ['q' => 'colom']))
            ->assertViewHas('paises', fn ($pagina) => $pagina->pluck('pais_codi')->all() === ['COL']);

        $this->get(route('paises.index', ['q' => 'per']))
            ->assertViewHas('paises', fn ($pagina) => $pagina->pluck('pais_codi')->all() === ['PER']);
    }

    public function test_pagina_el_listado_con_textos_en_espanol()
    {
        config(['geografia.por_pagina' => 2]);
        Pais::factory()->count(3)->create();

        $this->get(route('paises.index'))
            ->assertViewHas('paises', fn ($pagina) => $pagina->lastPage() === 2)
            ->assertSee('Mostrando')
            ->assertSee('Siguiente');
    }

    public function test_muestra_los_formularios()
    {
        $pais = Pais::factory()->create();

        $this->get(route('paises.create'))->assertOk()->assertSee('pais_codi');
        $this->get(route('paises.edit', $pais))->assertOk()->assertDontSee('name="pais_codi"', false);
    }

    public function test_crea_un_pais_normalizando_el_codigo()
    {
        $this->post(route('paises.store'), ['pais_codi' => ' col ', 'pais_nomb' => 'Colombia'])
            ->assertRedirect(route('paises.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('tb_pais', ['pais_codi' => 'COL', 'pais_nomb' => 'Colombia', 'pais_capi' => null]);
    }

    public function test_valida_el_codigo_al_crear()
    {
        Pais::factory()->create(['pais_codi' => 'COL']);

        $this->post(route('paises.store'), ['pais_codi' => 'COL', 'pais_nomb' => 'Otra'])
            ->assertSessionHasErrors('pais_codi');
        $this->post(route('paises.store'), ['pais_codi' => 'CO1', 'pais_nomb' => 'Otra'])
            ->assertSessionHasErrors('pais_codi');
        $this->post(route('paises.store'), ['pais_codi' => 'ECU', 'pais_nomb' => '', 'pais_capi' => 999])
            ->assertSessionHasErrors(['pais_nomb', 'pais_capi']);

        $this->assertDatabaseCount('tb_pais', 1);
    }

    public function test_actualiza_sin_permitir_cambiar_el_codigo()
    {
        $pais = Pais::factory()->create(['pais_codi' => 'COL']);
        $capital = Municipio::factory()->create();

        $this->put(route('paises.update', $pais), [
            'pais_codi' => 'XXX',
            'pais_nomb' => 'República de Colombia',
            'pais_capi' => $capital->muni_codi,
        ])->assertRedirect(route('paises.index'));

        $this->assertDatabaseHas('tb_pais', [
            'pais_codi' => 'COL',
            'pais_nomb' => 'República de Colombia',
            'pais_capi' => $capital->muni_codi,
        ]);
        $this->assertDatabaseMissing('tb_pais', ['pais_codi' => 'XXX']);
    }

    public function test_elimina_un_pais_sin_departamentos()
    {
        $pais = Pais::factory()->create();

        $this->delete(route('paises.destroy', $pais))->assertSessionHas('success');

        $this->assertDatabaseMissing('tb_pais', ['pais_codi' => $pais->pais_codi]);
    }

    public function test_no_elimina_un_pais_con_departamentos()
    {
        $pais = Departamento::factory()->create()->pais;

        $this->delete(route('paises.destroy', $pais))->assertSessionHas('error');

        $this->assertDatabaseHas('tb_pais', ['pais_codi' => $pais->pais_codi]);
    }
}
