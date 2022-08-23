<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmpresaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->company,
            'cpf_cnpj' => $this->faker->cnpj,
            'porte' => $this->faker->numberBetween(0, 5)
        ];
    }
}
