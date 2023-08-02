<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BeneficiarioRequest extends FormRequest{
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {   
        $user = Auth::user();

        return $user->role == User::ROLE_ENUM['beneficiario'] || $user->role == User::ROLE_ENUM['secretario'];
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:255|unique:beneficiario',
            'rg' => 'required|string|max:255|unique:beneficiario',
            'nis' => 'required|string|max:255|unique:beneficiario',
            'orgao_emissor' => 'required|string|max:255',
            'quantidade_pessoas' => 'required|integer|max:255',
            'observacao' => 'nullable|string|max:255',
            'cep' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'uf' => 'required|string|max:255',
                 
        ];
    }

    public function messages()
    {
        return [ 
        'name.required' => 'O campo nome é obrigatório',
        'name.max' => 'O campo nome deve ter no máximo 255 caracteres',
        'name.string' => 'O campo nome deve ser uma string',
        'cpf.required' => 'O campo cpf é obrigatório',
        'cpf.max' => 'O campo cpf deve ter no máximo 255 caracteres',
        'cpf.string' => 'O campo cpf deve ser uma sequencia númerica',
        'cpf.unique' => 'O cpf já está cadastrado',
        'rg.required' => 'O campo rg é obrigatório',
        'rg.max' => 'O campo rg deve ter no máximo 255 caracteres',
        'rg.string' => 'O campo rg deve ser uma sequencia númerica',
        'rg.unique' => 'O rg já está cadastrado',
        'nis.required' => 'O campo nis é obrigatório',
        'nis.max' => 'O campo nis deve ter no máximo 255 caracteres',
        'nis.string' => 'O campo nis deve ser uma sequencia númerica',
        'nis.unique' => 'O nis já está cadastrado',
        'orgao_emissor.required' => 'O campo orgão emissor é obrigatório',
        'orgao_emissor.max' => 'O campo orgão emissor deve ter no máximo 255 caracteres',
        'quantidade_pessoas.required' => 'O campo quantidade de pessoas é obrigatório',
        'quantidade_pessoas.max' => 'O campo quantidade de pessoas deve ter no máximo 255 caracteres',
        'quantidade_pessoas.integer' => 'O campo quantidade de pessoas deve ser um número',
        'observacao.max' => 'O campo observação deve ter no máximo 255 caracteres',
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
        ];
    }
}