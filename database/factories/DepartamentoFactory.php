<?php

namespace Database\Factories;

use App\Models\Departamento;
use App\Models\Pais;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Departamento>
 */
class DepartamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'depa_nomb' => $this->faker->state(),
            'pais_codi' => Pais::factory(),
        ];
    }
}
