<?php

namespace App\Actions\Fortify;

use App\Models\Cnae;
use App\Models\User;
use App\Models\Endereco;
use App\Models\Telefone;
use App\Models\Empresa;
use App\Models\Requerente;
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
            'name'                      => ['required', 'string', 'min:10', 'max:255'],
            'email'                     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'                  => $this->passwordRules(),
            'terms'                     => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
            'cpf'                       => ['required', 'string', 'cpf'],
            'celular'                   => ['required', 'string', 'celular_com_ddd', 'max:255'],
            'rg'                        => ['required', 'string', 'max:255'],
            'orgão_emissor'             => ['required', 'string', 'max:255'],
            'cep'                       => ['required', 'string', 'max:255'],
            'bairro'                    => ['required', 'string', 'max:255'],
            'rua'                       => ['required', 'string', 'max:255'],
            'número'                    => ['required', 'string', 'max:255'],
            'cidade'                    => ['required', 'string', 'max:255'],
            'uf'                        => ['required', 'string', 'max:255'],
            'complemento'               => ['nullable', 'string', 'max:255'],
        ], [
            'cpf.cpf'                               => 'O campo CPF não é um CPF válido.',
            'celular.celular_com_ddd'               => 'O campo contato não é um contato com DDD válido.',
        ])->validate();

        $user = new User();
        $endereco = new Endereco();
        // $enderecoEmpresa = new Endereco();
        $telefone = new Telefone();
        // $telefoneEmpresa = new Telefone();
        // $empresa = new Empresa();
        $requerente = new Requerente();

        $user->setAtributes($input);
        $user->role = User::ROLE_ENUM['requerente'];
        $user->save();

        $endereco->setAtributes($input);
        $endereco->save();
        // $enderecoEmpresa->setAtributesEmpresa($input);
        // $enderecoEmpresa->save();

        $telefone->setNumero($input['celular']);
        $telefone->save();
        // $telefoneEmpresa->setNumero($input['celular_da_empresa']);
        // $telefoneEmpresa->save();

        $requerente->setAtributes($input);
        $requerente->user_id = $user->id;
        $requerente->endereco_id = $endereco->id;
        $requerente->telefone_id = $telefone->id;
        $requerente->save();

        // $empresa->setAtributes($input);
        // $empresa->user_id = $user->id;
        // $empresa->endereco_id = $enderecoEmpresa->id;
        // $empresa->telefone_id = $telefoneEmpresa->id;
        // $empresa->save();

        // $cnaes_id = $input['cnaes_id'];
        // foreach ($cnaes_id as $cnae_id) {
        //     $empresa->cnaes()->attach((Cnae::find($cnae_id)));
        // }
        return $user;
    }
}
