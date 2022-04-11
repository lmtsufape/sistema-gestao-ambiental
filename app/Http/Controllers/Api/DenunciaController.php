<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Denuncia;
use App\Models\FotoDenuncia;
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

    /**
     * Fotos da denuncia
     *
     * Retorna as fotos anexadas a denuncia.
     * 
     * @urlParam id integer required O identificador da denuncia.
     *
     * @response status=200 scenario="success" [{"id": 1, "caminho": "denuncias/1/histoSiga2021.jpg", "comentario": null, "denuncia_id": 1, "created_at": "2022-04-08T19:08:54.000000Z", "updated_at": "2022-04-08T19:08:54.000000Z"}, {"id": 2, "caminho": "denuncias/1/pizzacalabresaacebolada.jpg", "comentario": "algum comentario aqui", "denuncia_id": 1, "created_at": "2022-04-11T10:54:40.000000Z", "updated_at": "2022-04-11T10:54:40.000000Z"}]
     *
     * @response status=401 scenario="usuario nao autenticado" {"message": "Unauthenticated."}
     * 
     * @responseField id integer O identificador da foto
     * @responseField caminho string O caminho de onde a imagem esta salva
     * @responseField comentario string O comentário opcional feito a imagem
     * @responseField denuncia_id integer O identificador da denuncia
     */
    public function getFotos(Request $request)
    {
        return Denuncia::find($request->id)->fotos->toArray();
    }

    /**
     * Foto da denuncia
     *
     * Retorna uma foto anexada a denuncia.
     *
     * @urlParam id integer required O identificador da denuncia.
     * @urlParam id_foto integer required O identificador da foto da denuncia.
     *
     * @response status=200 scenario="success" {"id": 2, "caminho": "denuncias/1/pizzacalabresaacebolada.jpg", "comentario": "algum comentario aqui", "denuncia_id": 1, "created_at": "2022-04-11T10:54:40.000000Z", "updated_at": "2022-04-11T10:54:40.000000Z"}
     *
     * @response status=401 scenario="usuario nao autenticado" {"message": "Unauthenticated."}
     * 
     * @responseField id integer O identificador da foto
     * @responseField caminho string O caminho de onde a imagem esta salva
     * @responseField comentario string O comentário opcional feito a imagem
     * @responseField denuncia_id integer O identificador da denuncia
     */
    public function getFotoDenuncia(Request $request)
    {
        return FotoDenuncia::find($request->id_foto)->toArray();
    }

    /**
     * Arquivo da foto da denuncia
     *
     * Retorna uma o arquivo da foto anexada a denuncia.
     *
     * @urlParam id integer required O identificador da denuncia.
     * @urlParam id_foto integer required O identificador da foto da denuncia.
     *
     * @response status=200 scenario="success" {file}
     *
     * @response status=401 scenario="usuario nao autenticado" {"message": "Unauthenticated."}
     * 
     */
    public function getArquivoFotoDenuncia(Request $request)
    {
        $foto = FotoDenuncia::find($request->id_foto);
        $arquivo = response()->file(storage_path('app/public/'.$foto['caminho']));
        return $arquivo;
    }
}
