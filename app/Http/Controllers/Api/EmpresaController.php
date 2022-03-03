<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    /**
     * Empresa
     *
     * Consulta a empresa pelo identificador.
     *
     * @urlParam id integer required O identificador da empresa.
     *
     * @response status=200 scenario="success" {"id": 1,"nome": "Info mundo tecnologia","cpf_cnpj": "32.970.478\/0001-30","eh_cnpj": true,"porte": 1,"user_id": 4,"telefone_id": 2,"endereco_id": 2,"created_at": null,"updated_at": null,"represetante_legal_id": null}
     * @response status=401 scenario="usuario nao autenticado" {"message": "Unauthenticated."}
     *
     * @responseField id O identificador da empresa
     * @responseField nome Nome da empresa.
     * @responseField eh_cnpj Indica se o campo cpf_cnpj é um cnpj.
     * @responseField cpf_cnpj CPF ou CNPJ da empresa.
     * @responseField porte Porte da empresa.
     * @responseField represetante_legal_id Identificador do representante legal da empresa.
     * @responseField user_id Identificador do usuário que criou a empresa.
     * @responseField telefone_id Identificador do telefone da empresa.
     * @responseField endereco_id Identificador do endereço da empresa.
     */
    public function get(Request $request)
    {
        return Empresa::find($request->id)->toArray();
    }
}
