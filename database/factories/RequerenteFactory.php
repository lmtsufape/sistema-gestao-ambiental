<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RequerenteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cpf' => $this->faker->cpf,
            'rg' => $this->faker->rg,
            'orgao_emissor' => $this->faker->word,
        ];
    }
}
