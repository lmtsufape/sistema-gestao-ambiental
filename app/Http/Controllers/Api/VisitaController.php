<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VisitaCollection;
use App\Http\Resources\VisitaResource;
use App\Models\Visita;
use Illuminate\Http\Request;

class VisitaController extends Controller
{
    /**
     * Visitas
     *
     * Consulta todas as visitas do usuário autenticado.
     *
     * @response status=200 scenario="success" {   "id": 1,   "data_marcada": "2022-02-23",   "data_realizada": null,   "requerimento_id": null,   "denuncia_id": 2,   "analista_id": 2,   "created_at": "2022-02-22T18:55:21.000000Z",   "updated_at": "2022-02-22T18:55:21.000000Z",   "solicitacao_poda_id": null  }
     *
     * @response status=401 scenario="usuario nao autenticado" {"message": "Unauthenticated."}
     *
     * @responseField id integer O identificador da visita
     * @responseField data_marcada A data marcada para realização da visita
     * @responseField data_realizada A data em que a visita foi realizada
     * @responseField requerimento_id integer O identificador do requerimento, se a visita não for para um requerimento o valor é null
     * @responseField denuncia_id integer O identificador da denúncia, se a visita não for para uma denúncia o valor é null
     * @responseField solicitacao_poda_id integer O identificador da solicitação de poda/corte, se a visita não for para uma solicitação de poda/corte o valor é null
     */
    public function index(Request $request)
    {
        return $request->user()->visitas()->get()->toArray();
    }

    /**
     * Visita
     *
     * Consulta a visita pelo identificador.
     *
     * @response status=200 scenario="success" {   "id": 1,   "data_marcada": "2022-02-23",   "data_realizada": null,   "requerimento_id": null,   "denuncia_id": 2,   "analista_id": 2,   "created_at": "2022-02-22T18:55:21.000000Z",   "updated_at": "2022-02-22T18:55:21.000000Z",   "solicitacao_poda_id": null  }
     *
     * @response status=401 scenario="usuario nao autenticado" {"message": "Unauthenticated."}
     *
     * @responseField id integer O identificador da visita
     * @responseField data_marcada A data marcada para realização da visita
     * @responseField data_realizada A data em que a visita foi realizada
     * @responseField analista_id Identificador do usuário analista atribuido a visita.
     * @responseField requerimento_id integer O identificador do requerimento, se a visita não for para um requerimento o valor é null
     * @responseField denuncia_id integer O identificador da denúncia, se a visita não for para uma denúncia o valor é null
     * @responseField solicitacao_poda_id integer O identificador da solicitação de poda/corte, se a visita não for para uma solicitação de poda/corte o valor é null
     */
    public function get(Request $request)
    {
        return Visita::find($request->id)->toArray();
    }
}
