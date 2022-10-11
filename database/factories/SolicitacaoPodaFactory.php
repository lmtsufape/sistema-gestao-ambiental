<?php

namespace Database\Factories;

use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class SolicitacaoPodaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'protocolo' => Hash::make($this->faker->word),
            'status' => 1,
            'comentario' => $this->faker->realText(),
            'area' => $this->faker->numberBetween(1, 2),
        ];
    }
}
