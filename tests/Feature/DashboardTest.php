<?php

namespace Tests\Feature;

use App\Models\Comuna;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_requiere_autenticacion()
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_muestra_los_totales_de_cada_catalogo()
    {
        // Una comuna crea en cascada su municipio, departamento y país.
        Comuna::factory()->count(2)->create();

        $this->actingAs(User::factory()->create())
            ->get(route('dashboard'))
            ->assertOk()
            ->assertViewHas('totales', [
                'paises' => 2,
                'departamentos' => 2,
                'municipios' => 2,
                'comunas' => 2,
            ]);
    }

    public function test_ordena_los_departamentos_por_cantidad_de_municipios()
    {
        $grande = Departamento::factory()->create(['depa_nomb' => 'Grande']);
        $mediano = Departamento::factory()->create(['depa_nomb' => 'Mediano']);
        Departamento::factory()->create(['depa_nomb' => 'Vacío']);
        Municipio::factory()->count(3)->create(['depa_codi' => $grande->depa_codi]);
        Municipio::factory()->create(['depa_codi' => $mediano->depa_codi]);

        $this->actingAs(User::factory()->create())
            ->get(route('dashboard'))
            ->assertViewHas('departamentosDestacados', fn ($deps) => $deps->pluck('depa_nomb')->all() === ['Grande', 'Mediano', 'Vacío'])
            ->assertSeeInOrder(['Grande', 'Mediano', 'Vacío']);
    }

    public function test_indica_el_rol_del_usuario()
    {
        $this->actingAs(User::factory()->admin()->create(['name' => 'Ana']))
            ->get(route('dashboard'))
            ->assertSee('Hola, Ana')
            ->assertSee('Administrador')
            ->assertDontSee('solo lectura');

        $this->actingAs(User::factory()->create())
            ->get(route('dashboard'))
            ->assertSee('Lector')
            ->assertSee('solo lectura');
    }

    public function test_funciona_sin_datos()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Todavía no hay departamentos registrados.');
    }
}
