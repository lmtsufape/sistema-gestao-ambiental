<?php

namespace App\Actions\Fortify;

use App\Models\Endereco;
use App\Models\Requerente;
use App\Models\Telefone;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'min:10', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
            'cpf' => ['required', 'string', 'cpf'],
            'celular' => ['required', 'string', 'celular_com_ddd', 'max:255'],
            'rg' => ['required', 'string', 'max:255'],
            'orgão_emissor' => ['required', 'string', 'max:255'],
            'cep' => ['required', 'string', 'max:255'],
            'bairro' => ['required', 'string', 'max:255'],
            'rua' => ['required', 'string', 'max:255'],
            'número' => ['required', 'string', 'max:255'],
            'cidade' => ['required', 'string', 'max:255'],
            'uf' => ['required', 'string', 'max:255'],
            'complemento' => ['nullable', 'string', 'max:255'],
        ], [
            'cpf.cpf' => 'O campo CPF não é um CPF válido.',
            'celular.celular_com_ddd' => 'O campo contato não é um contato com DDD válido.',
        ])->validate();

        $user = new User();
        $endereco = new Endereco();
        $telefone = new Telefone();
        $usuario = new Requerente();
        $user->role = User::ROLE_ENUM['requerente'];

        $user->setAtributes($input);
        $user->save();
        $endereco->setAtributes($input);
        $endereco->save();
        $telefone->setNumero($input['celular']);
        $telefone->save();
        $usuario->setAtributes($input);
        $usuario->user_id = $user->id;
        $usuario->endereco_id = $endereco->id;
        $usuario->telefone_id = $telefone->id;
        $usuario->save();

        return $user;
    }
}
