<?php

namespace Database\Factories;

use App\Models\Municipio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comuna>
 */
class ComunaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'comu_nomb' => 'Comuna '.$this->faker->unique()->numberBetween(1, 999),
            'muni_codi' => Municipio::factory(),
        ];
    }
}
