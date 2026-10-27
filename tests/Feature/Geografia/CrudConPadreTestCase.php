<?php

namespace Tests\Feature\Geografia;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Casos comunes para los recursos que tienen un nombre y una llave foránea
 * hacia su entidad padre (departamento → país, municipio → departamento...).
 */
abstract class CrudConPadreTestCase extends TestCase
{
    use RefreshDatabase;

    /** @var class-string<Model> */
    protected string $model;

    /** @var class-string<Model> */
    protected string $parentModel;

    /** @var class-string<Model>|null Modelo hijo que impide eliminar el registro. */
    protected ?string $childModel = null;

    protected string $route;

    protected string $nameColumn;

    protected string $foreignKey;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }

    public function test_requiere_autenticacion()
    {
        auth()->logout();

        $this->get(route("{$this->route}.index"))->assertRedirect(route('login'));
        $this->post(route("{$this->route}.store"))->assertRedirect(route('login'));
    }

    public function test_lista_los_registros_con_su_padre()
    {
        $registro = $this->model::factory()->create();
        $padre = $registro->{$this->parentRelation()};

        $this->get(route("{$this->route}.index"))
            ->assertOk()
            ->assertSee($registro->{$this->nameColumn})
            ->assertSee($padre->{$this->parentNameColumn()});
    }

    public function test_pagina_el_listado()
    {
        config(['geografia.por_pagina' => 5]);
        $this->model::factory()->count(6)->create();

        $this->get(route("{$this->route}.index"))
            ->assertOk()
            ->assertViewHas($this->route, fn ($pagina) => $pagina->count() === 5 && $pagina->total() === 6);

        $this->get(route("{$this->route}.index", ['page' => 2]))
            ->assertViewHas($this->route, fn ($pagina) => $pagina->count() === 1);
    }

    public function test_busca_por_nombre_y_conserva_el_termino_en_la_paginacion()
    {
        config(['geografia.por_pagina' => 1]);
        $this->model::factory()->create([$this->nameColumn => 'Zafiro Norte']);
        $this->model::factory()->create([$this->nameColumn => 'Zafiro Sur']);
        $this->model::factory()->create([$this->nameColumn => 'Rubí']);

        $this->get(route("{$this->route}.index", ['q' => 'zafiro']))
            ->assertOk()
            ->assertViewHas($this->route, fn ($pagina) => $pagina->total() === 2)
            ->assertSee('q=zafiro', false)
            ->assertDontSee('Rubí');
    }

    public function test_busca_por_nombre_del_padre()
    {
        $padre = $this->parentModel::factory()->create([$this->parentNameColumn() => 'Quetzal']);
        $hijo = $this->model::factory()->create([$this->foreignKey => $padre->getKey()]);
        $this->model::factory()->create();

        $this->get(route("{$this->route}.index", ['q' => 'quetz']))
            ->assertViewHas($this->route, fn ($pagina) => $pagina->total() === 1 && $pagina->first()->is($hijo));
    }

    public function test_los_comodines_de_like_se_buscan_literalmente()
    {
        $this->model::factory()->create([$this->nameColumn => 'Cien_por_ciento']);
        $this->model::factory()->create([$this->nameColumn => 'Cienxporxciento']);

        $this->get(route("{$this->route}.index", ['q' => 'cien_']))
            ->assertViewHas($this->route, fn ($pagina) => $pagina->total() === 1);

        $this->get(route("{$this->route}.index", ['q' => '%']))
            ->assertViewHas($this->route, fn ($pagina) => $pagina->total() === 0)
            ->assertSee('No hay resultados para');
    }

    public function test_muestra_los_formularios_con_las_opciones_del_padre()
    {
        $registro = $this->model::factory()->create();
        $padre = $registro->{$this->parentRelation()};

        $this->get(route("{$this->route}.create"))->assertOk()->assertSee($padre->{$this->parentNameColumn()});
        $this->get(route("{$this->route}.edit", $registro))->assertOk()->assertSee($registro->{$this->nameColumn});
    }

    public function test_crea_un_registro()
    {
        $padre = $this->parentModel::factory()->create();

        $this->post(route("{$this->route}.store"), [
            $this->nameColumn => 'Nuevo registro',
            $this->foreignKey => $padre->getKey(),
        ])->assertRedirect(route("{$this->route}.index"))->assertSessionHas('success');

        $this->assertDatabaseHas($this->table(), [
            $this->nameColumn => 'Nuevo registro',
            $this->foreignKey => $padre->getKey(),
        ]);
    }

    public function test_valida_los_campos()
    {
        $this->post(route("{$this->route}.store"), [
            $this->nameColumn => str_repeat('a', 51),
            $this->foreignKey => 'inexistente',
        ])->assertSessionHasErrors([$this->nameColumn, $this->foreignKey]);

        $this->assertDatabaseCount($this->table(), 0);
    }

    public function test_actualiza_un_registro()
    {
        $registro = $this->model::factory()->create();
        $otroPadre = $this->parentModel::factory()->create();

        $this->put(route("{$this->route}.update", $registro), [
            $this->nameColumn => 'Nombre editado',
            $this->foreignKey => $otroPadre->getKey(),
        ])->assertRedirect(route("{$this->route}.index"))->assertSessionHas('success');

        $this->assertDatabaseHas($this->table(), [
            $registro->getKeyName() => $registro->getKey(),
            $this->nameColumn => 'Nombre editado',
            $this->foreignKey => $otroPadre->getKey(),
        ]);
    }

    public function test_elimina_un_registro()
    {
        $registro = $this->model::factory()->create();

        $this->delete(route("{$this->route}.destroy", $registro))->assertSessionHas('success');

        $this->assertDatabaseMissing($this->table(), [$registro->getKeyName() => $registro->getKey()]);
    }

    public function test_no_elimina_un_registro_con_hijos()
    {
        if (! $this->childModel) {
            $this->markTestSkipped('El recurso no tiene registros dependientes.');
        }

        $registro = $this->model::factory()->create();
        $this->childModel::factory()->create([$registro->getKeyName() => $registro->getKey()]);

        $this->delete(route("{$this->route}.destroy", $registro))->assertSessionHas('error');

        $this->assertDatabaseHas($this->table(), [$registro->getKeyName() => $registro->getKey()]);
    }

    public function test_responde_404_si_el_registro_no_existe()
    {
        $this->get(route("{$this->route}.edit", 999))->assertNotFound();
    }

    abstract protected function parentRelation(): string;

    abstract protected function parentNameColumn(): string;

    private function table(): string
    {
        return (new $this->model)->getTable();
    }
}
