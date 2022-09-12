<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class CEPGaranhuns implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $response = Http::get('https://viacep.com.br/ws/' . $value . '/json/');

        if ($value == env('CEP_GERAL')) {
            return true;
        }

        if ($response->json()['erro']) {
            return false;
        }

        return $response->json()['localidade'] == 'Garanhuns';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O cadastro não está disponível para empresas fora do município de Garanhuns!';
    }
}
