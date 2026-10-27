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
