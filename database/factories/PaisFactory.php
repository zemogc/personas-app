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
            'pais_nomb' => $this->faker->country(),
        ];
    }
}
