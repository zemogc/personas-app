<?php

namespace Tests\Feature\Geografia;

use App\Enums\Rol;
use App\Models\Comuna;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Pais;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AutorizacionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, array{string, class-string<Model>}>
     */
    public static function recursos(): array
    {
        return [
            'países' => ['paises', Pais::class],
            'departamentos' => ['departamentos', Departamento::class],
            'municipios' => ['municipios', Municipio::class],
            'comunas' => ['comunas', Comuna::class],
        ];
    }

    #[DataProvider('recursos')]
    public function test_un_lector_puede_consultar_el_listado_sin_ver_acciones(string $ruta, string $modelo)
    {
        $modelo::factory()->create();

        $this->actingAs(User::factory()->create())
            ->get(route("{$ruta}.index"))
            ->assertOk()
            ->assertDontSee(route("{$ruta}.create"))
            ->assertDontSee('Eliminar');
    }

    #[DataProvider('recursos')]
    public function test_un_lector_no_puede_modificar_registros(string $ruta, string $modelo)
    {
        $registro = $modelo::factory()->create();
        $this->actingAs(User::factory()->create());

        $this->get(route("{$ruta}.create"))->assertForbidden();
        $this->post(route("{$ruta}.store"), [])->assertForbidden();
        $this->get(route("{$ruta}.edit", $registro))->assertForbidden();
        $this->put(route("{$ruta}.update", $registro), [])->assertForbidden();
        $this->delete(route("{$ruta}.destroy", $registro))->assertForbidden();

        $this->assertModelExists($registro);
    }

    #[DataProvider('recursos')]
    public function test_un_administrador_ve_las_acciones(string $ruta, string $modelo)
    {
        $modelo::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->get(route("{$ruta}.index"))
            ->assertOk()
            ->assertSee(route("{$ruta}.create"))
            ->assertSee('Eliminar');
    }

    public function test_los_usuarios_nuevos_son_lectores_aunque_envien_otro_rol()
    {
        $this->post(route('register'), [
            'name' => 'Intruso',
            'email' => 'intruso@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'rol' => 'admin',
        ]);

        $user = User::where('email', 'intruso@example.com')->firstOrFail();

        $this->assertSame(Rol::Lector, $user->rol);
        $this->assertFalse($user->esAdmin());
    }

    public function test_el_comando_asigna_un_rol()
    {
        $user = User::factory()->create(['email' => 'ana@example.com']);

        $this->artisan('usuario:rol', ['email' => 'ana@example.com', 'rol' => 'admin'])
            ->expectsOutput('ana@example.com ahora es Administrador.')
            ->assertSuccessful();

        $this->assertTrue($user->fresh()->esAdmin());
    }

    public function test_el_comando_valida_el_rol_y_el_usuario()
    {
        User::factory()->create(['email' => 'ana@example.com']);

        $this->artisan('usuario:rol', ['email' => 'ana@example.com', 'rol' => 'superusuario'])
            ->expectsOutput('Rol no válido. Valores permitidos: admin, lector.')
            ->assertExitCode(2);

        $this->artisan('usuario:rol', ['email' => 'nadie@example.com', 'rol' => 'admin'])
            ->expectsOutput('No existe un usuario con ese correo.')
            ->assertFailed();
    }
}
