<?php

namespace Database\Seeders;

use App\Models\Pais;
use Illuminate\Database\Seeder;

class GeografiaSeeder extends Seeder
{
    /**
     * Comunas de Cali, numeradas del 1 al 22.
     */
    private const COMUNAS_CALI = 22;

    /**
     * Datos de ejemplo de Colombia: departamento => [municipio => [comunas]].
     *
     * @var array<string, array<string, string[]>>
     */
    private const COLOMBIA = [
        'Valle del Cauca' => [
            'Alcalá' => [], 'Andalucía' => [], 'Ansermanuevo' => [], 'Argelia' => [],
            'Bolívar' => [], 'Buenaventura' => [], 'Bugalagrande' => [], 'Caicedonia' => [],
            'Cali' => [], 'Calima' => [], 'Candelaria' => [], 'Cartago' => [],
            'Dagua' => [], 'El Águila' => [], 'El Cairo' => [], 'El Cerrito' => [],
            'El Dovio' => [], 'Florida' => [], 'Ginebra' => [], 'Guacarí' => [],
            'Guadalajara de Buga' => [], 'Jamundí' => [], 'La Cumbre' => [], 'La Unión' => [],
            'La Victoria' => [], 'Obando' => [], 'Palmira' => ['Comuna 1', 'Comuna 2', 'Comuna 3'],
            'Pradera' => [], 'Restrepo' => [], 'Riofrío' => [], 'Roldanillo' => [],
            'San Pedro' => [], 'Sevilla' => [], 'Toro' => [], 'Trujillo' => [],
            'Tuluá' => [], 'Ulloa' => [], 'Versalles' => [], 'Vijes' => [],
            'Yotoco' => [], 'Yumbo' => [], 'Zarzal' => [],
        ],
        'Antioquia' => [
            'Medellín' => [
                'Popular', 'Santa Cruz', 'Manrique', 'Aranjuez', 'Castilla', 'Doce de Octubre',
                'Robledo', 'Villa Hermosa', 'Buenos Aires', 'La Candelaria', 'Laureles-Estadio',
                'La América', 'San Javier', 'El Poblado', 'Guayabal', 'Belén',
            ],
            'Bello' => [], 'Envigado' => [], 'Itagüí' => [], 'Rionegro' => [], 'Sabaneta' => [],
        ],
        'Bogotá D.C.' => [
            'Bogotá' => [
                'Usaquén', 'Chapinero', 'Santa Fe', 'San Cristóbal', 'Usme', 'Tunjuelito', 'Bosa',
                'Kennedy', 'Fontibón', 'Engativá', 'Suba', 'Barrios Unidos', 'Teusaquillo',
                'Los Mártires', 'Antonio Nariño', 'Puente Aranda', 'La Candelaria',
                'Rafael Uribe Uribe', 'Ciudad Bolívar', 'Sumapaz',
            ],
        ],
        'Cundinamarca' => [
            'Chía' => [], 'Facatativá' => [], 'Fusagasugá' => [], 'Soacha' => ['Comuna 1', 'Comuna 4'], 'Zipaquirá' => [],
        ],
        'Atlántico' => [
            'Barranquilla' => [], 'Malambo' => [], 'Puerto Colombia' => [], 'Soledad' => [],
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

                if ($municipio === 'Cali') {
                    $comunas = array_map(fn ($n) => "Comuna {$n}", range(1, self::COMUNAS_CALI));
                }

                $muni->comunas()->createMany(array_map(fn ($nombre) => ['comu_nomb' => $nombre], $comunas));

                if ($municipio === 'Bogotá') {
                    $colombia->update(['pais_capi' => $muni->muni_codi]);
                }
            }
        }

        Pais::insert([
            ['pais_codi' => 'ARG', 'pais_nomb' => 'Argentina', 'pais_capi' => null],
            ['pais_codi' => 'CHL', 'pais_nomb' => 'Chile', 'pais_capi' => null],
            ['pais_codi' => 'ECU', 'pais_nomb' => 'Ecuador', 'pais_capi' => null],
            ['pais_codi' => 'MEX', 'pais_nomb' => 'México', 'pais_capi' => null],
            ['pais_codi' => 'PER', 'pais_nomb' => 'Perú', 'pais_capi' => null],
        ]);
    }
}
