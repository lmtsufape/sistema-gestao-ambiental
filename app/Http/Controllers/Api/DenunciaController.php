<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Denuncia;
use Illuminate\Http\Request;

class DenunciaController extends Controller
{
    /**
     * Denuncia
     *
     * Consulta a denúncia pelo id
     *
     * @urlParam id integer required O identificador da denúncia.
     *
     * @response status=200 scenario="success" {"id": 1,"empresa_id": 1,"empresa_nao_cadastrada": "","endereco": "","texto": "<p>aaaaaaaaaaaaaaaaaa<\/p>","denunciante": "Nostrum elit rerum","aprovacao": 2,"protocolo": "T1NT$yWfMjWL1zIgUbC2","analista_id": 2,"created_at": "2022-02-22T18:54:31.000000Z","updated_at": "2022-02-22T18:55:14.000000Z"}
     * @response status=401 scenario="usuario nao autenticado" {"message": "Unauthenticated."}
     *
     * @responseField id O identificador da denúncia
     * @responseField empresa_nao_cadastrada Nome da empresa, caso não esteja cadastrada no sistema.
     * @responseField endereco Endereco da empresa, caso não esteja cadastrada no sistema.
     * @responseField texto Texto informando o motivo da denúncia.
     * @responseField denunciante Nome do denunciante.
     * @responseField aprovacao Estado da avaliação da denúncia.
     * @responseField protocolo Protocolo gerado ao criar a denúncia.
     * @responseField empresa_id Identificador da empresa, caso esteja cadastrada no sistema.
     * @responseField analista_id Identificador do usuário analista atribuido a denúncia.
     */
    public function get(Request $request)
    {
        return Denuncia::find($request->id)->toArray();
    }
}
