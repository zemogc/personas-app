<?php

namespace Database\Seeders;

use App\Models\Pais;
use Illuminate\Database\Seeder;

class GeografiaSeeder extends Seeder
{
    /**
     * Datos de ejemplo: departamento => [municipio => [comunas]].
     *
     * @var array<string, array<string, string[]>>
     */
    private const COLOMBIA = [
        'Valle del Cauca' => [
            'Cali' => ['Comuna 1', 'Comuna 2', 'Comuna 3', 'Comuna 17', 'Comuna 22'],
            'Palmira' => ['Comuna 1', 'Comuna 2'],
            'Buenaventura' => [],
        ],
        'Antioquia' => [
            'Medellín' => ['Popular', 'Laureles-Estadio', 'El Poblado'],
            'Envigado' => [],
        ],
        'Cundinamarca' => [
            'Soacha' => ['Comuna 1', 'Comuna 4'],
        ],
        'Bogotá D.C.' => [
            'Bogotá' => ['Usaquén', 'Chapinero', 'Suba'],
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colombia = Pais::create(['pais_codi' => 'COL', 'pais_nomb' => 'Colombia']);

        foreach (self::COLOMBIA as $departamento => $municipios) {
            $depa = $colombia->departamentos()->create(['depa_nomb' => $departamento]);

            foreach ($municipios as $municipio => $comunas) {
                $muni = $depa->municipios()->create(['muni_nomb' => $municipio]);

                foreach ($comunas as $comuna) {
                    $muni->comunas()->create(['comu_nomb' => $comuna]);
                }

                if ($municipio === 'Bogotá') {
                    $colombia->update(['pais_capi' => $muni->muni_codi]);
                }
            }
        }

        Pais::insert([
            ['pais_codi' => 'ECU', 'pais_nomb' => 'Ecuador', 'pais_capi' => null],
            ['pais_codi' => 'PER', 'pais_nomb' => 'Perú', 'pais_capi' => null],
        ]);
    }
}
