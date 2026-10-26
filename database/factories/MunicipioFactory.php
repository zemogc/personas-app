<?php

namespace Database\Factories;

use App\Models\Departamento;
use App\Models\Municipio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Municipio>
 */
class MunicipioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'muni_nomb' => $this->faker->city(),
            'depa_codi' => Departamento::factory(),
        ];
    }
}
