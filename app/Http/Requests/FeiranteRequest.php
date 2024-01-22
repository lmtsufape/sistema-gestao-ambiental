<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeiranteRequest extends FormRequest
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
        return [
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'string|required|before_or_equal:today',
            'cpf' => 'string|max:255|unique:feirantes',
            'rg' => 'string|max:255|unique:feirantes',
            'orgao_emissor' => 'string|max:255',
            'cep' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'uf' => 'required|string|max:255',
            'cep_comercio' => 'required|string|max:255',
            'bairro_comercio' => 'required|string|max:255',
            'numero_comerciu' => 'required|string|max:255',
            'cidade_comercio' => 'required|string|max:255',
            'estado_comercio' => 'required|string|max:255',
            'uf_comercio' => 'required|string|max:255',
            'atividade_comercial' => 'required|string|max:255',
            'residuos_gerados' => 'required|string|max:255',
            'protocolo_vigilancia_sanitaria' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.max' => 'O campo nome deve ter no máximo 255 caracteres',
            'nome.string' => 'O campo nome deve ser uma string',
            'data_nascimento.required' => 'O campo data de nascimento é obrigatório',
            'data_nascimento.string' => 'O campo nome deve ser uma string',
            'data_nascimento.before_or_equal' => 'A data de nascimento não pode ser superior a data atual',
            'cpf.required' => 'O campo cpf é obrigatório',
            'cpf.max' => 'O campo cpf deve ter no máximo 255 caracteres',
            'cpf.string' => 'O campo cpf deve ser uma sequencia númerica',
            'cpf.unique' => 'O cpf já está cadastrado',
            'rg.required' => 'O campo rg é obrigatório',
            'rg.max' => 'O campo rg deve ter no máximo 255 caracteres',
            'rg.string' => 'O campo rg deve ser uma sequencia númerica',
            'rg.unique' => 'O rg já está cadastrado',
            'orgao_emissor.required' => 'O campo orgão emissor é obrigatório',
            'orgao_emissor.max' => 'O campo orgão emissor deve ter no máximo 255 caracteres',
            'cep.required' => 'O campo cep é obrigatório',
            'cep.max' => 'O campo cep deve ter no máximo 255 caracteres',
            'bairro.required' => 'O campo bairro é obrigatório',
            'bairro.max' => 'O campo bairro deve ter no máximo 255 caracteres',
            'numero.required' => 'O campo número é obrigatório',
            'numero.max' => 'O campo número deve ter no máximo 255 caracteres',
            'cidade.required' => 'O campo cidade é obrigatório',
            'cidade.max' => 'O campo cidade deve ter no máximo 255 caracteres',
            'estado.required' => 'O campo estado é obrigatório',
            'estado.max' => 'O campo estado deve ter no máximo 255 caracteres',
            'uf.required' => 'O campo uf é obrigatório',
            'uf.max' => 'O campo uf deve ter no máximo 255 caracteres',
            'cep_comercio.required' => 'O campo cep é obrigatório',
            'cep_comercio.max' => 'O campo cep deve ter no máximo 255 caracteres',
            'bairro_comercio.required' => 'O campo bairro é obrigatório',
            'bairro_comercio.max' => 'O campo bairro deve ter no máximo 255 caracteres',
            'numero_comercio.required' => 'O campo número é obrigatório',
            'numero_comercio.max' => 'O campo número deve ter no máximo 255 caracteres',
            'cidade_comercio.required' => 'O campo cidade é obrigatório',
            'cidade_comercio.max' => 'O campo cidade deve ter no máximo 255 caracteres',
            'estado_comercio.required' => 'O campo estado é obrigatório',
            'estado_comercio.max' => 'O campo estado deve ter no máximo 255 caracteres',
            'uf_comercio.required' => 'O campo uf é obrigatório',
            'uf_comercio.max' => 'O campo uf deve ter no máximo 255 caracteres',
            'atividade_comercial.required' => 'O campo atividade comercial é obrigatório',
            'atividade_comercial.max' => 'O campo atividade comercial deve ter no máximo 255 caracteres',
            'atividade_comercial.string' => 'O campo atividade comercial deve ser uma string',
            'residuos_gerados.required' => 'O campo resíduos gerados é obrigatório',
            'residuos_gerados.max' => 'O campo resíduos gerados deve ter no máximo 255 caracteres',
            'residuos_gerados.string' => 'O campo resíduos gerados deve ser uma string',
            'protocolo_vigilancia_sanitaria.required' => 'O campo protocolo vigilância sanitária é obrigatório',
            'protocolo_vigilancia_sanitaria.max' => 'O campo protocolo vigilância sanitária deve ter no máximo 255 caracteres',
            'protocolo_vigilancia_sanitaria.string' => 'O campo protocolo vigilância sanitária deve ser uma string',
        ];
    }
}
