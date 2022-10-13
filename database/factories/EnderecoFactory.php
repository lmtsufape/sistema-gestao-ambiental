<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EnderecoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cep' => $this->faker->postcode,
            'numero' => $this->faker->buildingNumber,
            'cidade' => $this->faker->city,
            'estado' => $this->faker->stateAbbr,
            'bairro' => $this->faker->city,
            'rua' => $this->faker->streetName,
            'complemento' => $this->faker->secondaryAddress,
        ];
    }
}
