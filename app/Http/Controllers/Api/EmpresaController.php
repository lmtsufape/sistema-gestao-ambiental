<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Requerimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Documentos do requerimento
     *
     * Retorna os nomes e ids dos documentos requeridos para emissao da licenca.
     *
     * @urlParam id integer required O identificador da empresa.
     * @urlParam id_requerimento integer required O identificador do requerimento da visita.
     *
     * @response status=200 scenario="success" [{"id": 8, "nome": "Comprovante de fornecimento de água (Compesa), se outro tipo, apresentar recibo de pagamento"}, {"id": 3, "nome": "Comprovante de pagamento da taxa ambiental"}, {"id": 1, "nome": "Cópia da (s) Identidade (s) e CPF(s) do requerente"}]
     *
     * @response status=401 scenario="usuario nao autenticado" {"message": "Unauthenticated."}
     *
     * @responseField id integer O identificador do documento
     * @responseField nome string O nome do documento
     */
    public function getDocumentos(Request $request)
    {
        $requerimento = Requerimento::find($request->id_requerimento);
        return $requerimento->documentos->map->only(['id', 'nome']);
    }

    /**
     * Documento do requerimento
     *
     * Retorna o nome e id dos documento requerido para emissao da licenca.
     *
     * @urlParam id integer required O identificador da empresa.
     * @urlParam id_requerimento integer required O identificador do requerimento da visita.
     * @urlParam id_documento integer required O identificador do documento.
     *
     * @response status=200 scenario="success" {"id": 8, "nome": "Comprovante de fornecimento de água (Compesa), se outro tipo, apresentar recibo de pagamento"}
     *
     * @response status=401 scenario="usuario nao autenticado" {"message": "Unauthenticated."}
     *
     * @responseField id integer O identificador do documento
     * @responseField nome string O nome do documento
     */
    public function getDocumento(Request $request)
    {
        $requerimento = Requerimento::find($request->id_requerimento);
        return $requerimento->documentos()->where('documento_id', $request->id_documento)->first()->only(['id', 'nome']);
    }

    /**
     * Arquivo do documento enviado pelo requerente da licenca
     *
     * Retorna um .pdf do documento enviado pelo requerente da licenca.
     *
     * @urlParam id integer required O identificador da empresa.
     * @urlParam id_requerimento integer required O identificador do requerimento.
     * @urlParam id_documento integer required O identificador do documento.
     *
     * @response status=200 scenario="success" {file}
     *
     * @response status=401 scenario="usuario nao autenticado" {"message": "Unauthenticated."}
     *
     */
    public function getDocumentoRequerido(Request $request)
    {
        $requerimento = Requerimento::find($request->id_requerimento);
        $caminho = $requerimento->documentos()->where('documento_id', $request->id_documento)->first()->pivot->caminho;
        return Storage::download($caminho);
    }
}
