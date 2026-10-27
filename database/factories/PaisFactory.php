<?php

namespace Database\Factories;

use App\Models\Pais;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pais>
 */
class PaisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pais_codi' => strtoupper($this->faker->unique()->lexify('???')),
            // tb_pais.pais_nomb es varchar(50) y Faker incluye nombres de 51
            // caracteres, que MySQL en modo estricto rechaza.
            'pais_nomb' => mb_substr($this->faker->country(), 0, 50),
        ];
    }
}
