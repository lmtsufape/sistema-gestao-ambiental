<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\CEPGaranhuns;
use Illuminate\Foundation\Http\FormRequest;

class EmpresaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->validarDocumentos();

        return [
            'nome_da_empresa' => ['required', 'string', 'min:5', 'max:255'],
            'tipo_de_pessoa' => ['nullable'],
            'cpf' => ['required_if:tipo_de_pessoa,física'],
            'cnpj' => ['required_if:tipo_de_pessoa,jurídica'],
            'setor' => ['required', 'string'],
            'celular_da_empresa' => ['required', 'string', 'celular_com_ddd', 'max:255'],
            'porte' => ['required'],
            'cep_da_empresa' => ['required', 'string', 'max:255', new CEPGaranhuns()],
            'bairro_da_empresa' => ['required', 'string', 'max:255'],
            'rua_da_empresa' => ['required', 'string', 'max:255'],
            'número_da_empresa' => ['required', 'string', 'max:255'],
            'cidade_da_empresa' => ['required', 'string', 'max:255'],
            'estado_da_empresa' => ['required', 'string', 'max:255'],
            'complemento_da_empresa' => ['nullable', 'string', 'max:255'],
            'cnaes_id' => ['required', 'array', 'min:1'],
            'cnaes_id.*' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages()
    {
        return [
            'cpf.cpf' => 'O campo CPF não é um CPF válido.',
            'cnpj.cnpj' => 'O campo CNPJ não é um CNPJ válido.',
            'celular_da_empresa.celular_com_ddd' => 'O campo contato não é um contato com DDD válido.',
            'cnaes_id.required' => 'Escolha no mínimo um CNAE da lista de CNAES.',
            'cnaes_id.*.required' => 'Escolha no mínimo um CNAE da lista de CNAES.',
            'cnaes_id.*.integer' => 'Informe um CNAE valido.',
            'cnaes_id.*.min' => 'Informe um CNAE valido.',
        ];
    }

    public function validarDocumentos()
    {
        switch ($this->tipo_de_pessoa) {
            case 'física':
                $this->validate([
                    'cpf' => 'cpf',
                ]);
                break;
            case 'jurídica':
                $this->validate([
                    'cnpj' => 'cnpj',
                ]);
                break;
        }
    }
}
