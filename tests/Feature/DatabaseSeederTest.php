<?php

namespace Tests\Feature;

use App\Models\Comuna;
use App\Models\Pais;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_carga_la_jerarquia_geografica()
    {
        $this->seed(DatabaseSeeder::class);

        $colombia = Pais::with('capital', 'departamentos.municipios')->findOrFail('COL');

        $this->assertSame('Bogotá', $colombia->capital->muni_nomb);
        $this->assertCount(5, $colombia->departamentos);
        $this->assertCount(42, $colombia->departamentos->firstWhere('depa_nomb', 'Valle del Cauca')->municipios);
        $this->assertSame(22, Comuna::whereHas('municipio', fn ($q) => $q->where('muni_nomb', 'Cali'))->count());
        $this->assertSame(6, Pais::count());
    }
}
