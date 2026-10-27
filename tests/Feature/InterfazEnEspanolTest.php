<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InterfazEnEspanolTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_portada_presenta_la_aplicacion()
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('La división geográfica de un país')
            ->assertSee(route('login'))
            ->assertSee('Crear una cuenta');
    }

    public function test_la_portada_lleva_al_panel_si_hay_sesion()
    {
        $this->actingAs(User::factory()->create())
            ->get('/')
            ->assertSee('Ir al panel')
            ->assertDontSee('Crear una cuenta');
    }

    public function test_las_pantallas_de_autenticacion_estan_en_espanol()
    {
        $this->get(route('login'))
            ->assertSee('Correo electrónico')
            ->assertSee('Recordarme')
            ->assertSee('¿Olvidaste tu contraseña?');

        $this->get(route('register'))->assertSee('Confirmar contraseña');
    }

    public function test_los_errores_de_validacion_estan_en_espanol()
    {
        $this->from(route('login'))
            ->post(route('login'), ['email' => '', 'password' => ''])
            ->assertSessionHasErrors([
                'email' => 'El campo correo electrónico es obligatorio.',
                'password' => 'El campo contraseña es obligatorio.',
            ]);

        $user = User::factory()->create();

        $this->post(route('login'), ['email' => $user->email, 'password' => 'incorrecta'])
            ->assertSessionHasErrors(['email' => 'Estas credenciales no coinciden con nuestros registros.']);
    }

    public function test_los_errores_del_modulo_usan_el_nombre_del_campo()
    {
        $this->actingAs(User::factory()->admin()->create())
            ->post(route('paises.store'), ['pais_codi' => 'CO', 'pais_nomb' => ''])
            ->assertSessionHasErrors([
                'pais_codi' => 'El campo código debe tener 3 caracteres.',
                'pais_nomb' => 'El campo nombre es obligatorio.',
            ]);
    }
}
