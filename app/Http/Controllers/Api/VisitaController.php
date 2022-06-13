<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VisitaCollection;
use App\Http\Resources\VisitaResource;
use App\Models\FotoVisita;
use App\Models\Visita;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VisitaController extends Controller
{
    /**
     * Visitas
     *
     * Consulta todas as visitas do usuário autenticado.
     *
     * @response status=200 scenario="visita de solicitacao de poda" [{"id": 4,"data_marcada": "2022-03-17","data_realizada": null,"requerimento_id": null,"denuncia_id": null,"analista_id": 2,"created_at": "2022-03-03T13:23:21.000000Z","updated_at": "2022-03-03T13:23:21.000000Z","solicitacao_poda_id": 1,"denuncia": null,"requerimento": null,"solicitacao_poda": {	"id": 1,	"protocolo": "2UBmH6cog6e0.nCudR54",	"motivo_indeferimento": null,	"autorizacao_ambiental": null,	"status": 1,	"analista_id": 2,	"endereco_id": 3,	"requerente_id": 1,	"created_at": "2022-03-03T13:22:46.000000Z",	"updated_at": "2022-03-03T13:23:15.000000Z",	"comentario": "Voluptatibus ullam n",	"endereco": {"id": 3,"rua": "Rua Manoel Pessoal Juvenal","numero": "20","bairro": "Severiano de Moraes Filho","cidade": "Garanhuns","estado": "PE","complemento": "Dolorem rem magni ve","cep": "55299-400","created_at": "2022-03-03T13:22:46.000000Z","updated_at": "2022-03-03T13:22:46.000000Z"	},	"analista": {"id": 2,"name": "Analista","email": "analista@analista.com","email_verified_at": "2022-02-21T14:09:31.000000Z","role": 3,"current_team_id": null,"profile_photo_path": null,"created_at": null,"updated_at": null,"profile_photo_url": "https:\/\/ui-avatars.com\/api\/?name=A&color=7F9CF5&background=EBF4FF"	},	"requerente": {"id": 1,"cpf": "872.117.185-87","rg": "38.291.584-7","orgao_emissor": "SDS-PE","user_id": 4,"telefone_id": 1,"endereco_id": 1,"created_at": null,"updated_at": null,"user": {	"id": 4,	"name": "Empresario",	"email": "empresa@empresa.com",	"email_verified_at": "2022-02-21T14:09:31.000000Z",	"role": 1,	"current_team_id": null,	"profile_photo_path": null,	"created_at": null,	"updated_at": null,	"profile_photo_url": "https:\/\/ui-avatars.com\/api\/?name=E&color=7F9CF5&background=EBF4FF"}	}}	}]
     * @response status=200 scenario="visita de denúncia" [{"id": 1,"data_marcada": "2022-02-23","data_realizada": null,"requerimento_id": null,"denuncia_id": 2,"analista_id": 2,"created_at": "2022-02-22T18:55:21.000000Z","updated_at": "2022-02-22T18:55:21.000000Z","solicitacao_poda_id": null,"denuncia": {	"id": 2,	"empresa_id": 1,	"empresa_nao_cadastrada": "",	"endereco": "",	"texto": "<p>aaaaaaaaaaaaaaaa<\/p>",	"denunciante": "aaaaaaaa",	"aprovacao": 2,	"protocolo": "7iyIcASIu8I\/7pEeFruU",	"analista_id": 2,	"created_at": "2022-02-22T18:54:42.000000Z",	"updated_at": "2022-03-03T11:22:57.000000Z",	"empresa": {"id": 1,"nome": "Info mundo tecnologia","cpf_cnpj": "32.970.478\/0001-30","eh_cnpj": true,"porte": 1,"user_id": 4,"telefone_id": 2,"endereco_id": 2,"created_at": null,"updated_at": null,"represetante_legal_id": null,"user": {	"id": 4,	"name": "Empresario",	"email": "empresa@empresa.com",	"email_verified_at": "2022-02-21T14:09:31.000000Z",	"role": 1,	"current_team_id": null,	"profile_photo_path": null,	"created_at": null,	"updated_at": null,	"profile_photo_url": "https:\/\/ui-avatars.com\/api\/?name=E&color=7F9CF5&background=EBF4FF"},"telefone": {	"id": 2,	"numero": "(34) 98192-2518",	"created_at": null,	"updated_at": null},"endereco": {	"id": 2,	"rua": "Rua do Cateté",	"numero": "588",	"bairro": "Jardim Monte Líbano",	"cidade": "Garanhuns",	"estado": "PE",	"complemento": "Casa",	"cep": "55292-000",	"created_at": null,	"updated_at": null}	},	"analista": {"id": 2,"name": "Analista","email": "analista@analista.com","email_verified_at": "2022-02-21T14:09:31.000000Z","role": 3,"current_team_id": null,"profile_photo_path": null,"created_at": null,"updated_at": null,"profile_photo_url": "https:\/\/ui-avatars.com\/api\/?name=A&color=7F9CF5&background=EBF4FF"	}},"requerimento": null,"solicitacao_poda": null	}]
     * @response status=200 scenario="visita de requerimento" [{"id": 3,"data_marcada": "2022-03-17","data_realizada": null,"requerimento_id": 7,"denuncia_id": null,"analista_id": 2,"created_at": "2022-03-03T11:25:45.000000Z","updated_at": "2022-03-03T11:25:45.000000Z","solicitacao_poda_id": null,"denuncia": null,"requerimento": {	"id": 7,	"status": 6,	"tipo": 1,	"tipo_licenca": 1,	"valor": "1",	"potencial_poluidor_atribuido": null,	"definicao_valor": "Definir de forma manual",	"valor_juros": null,	"analista_id": 3,	"represetante_id": null,	"empresa_id": 1,	"created_at": "2022-02-21T15:19:35.000000Z",	"updated_at": "2022-03-03T11:25:45.000000Z",	"analista": {"id": 3,"name": "Protocolista","email": "protocolista@protocolista.com","email_verified_at": "2022-02-21T14:09:31.000000Z","role": 3,"current_team_id": null,"profile_photo_path": null,"created_at": null,"updated_at": null,"profile_photo_url": "https:\/\/ui-avatars.com\/api\/?name=P&color=7F9CF5&background=EBF4FF"	},	"empresa": {"id": 1,"nome": "Info mundo tecnologia","cpf_cnpj": "32.970.478\/0001-30","eh_cnpj": true,"porte": 1,"user_id": 4,"telefone_id": 2,"endereco_id": 2,"created_at": null,"updated_at": null,"represetante_legal_id": null,"user": {	"id": 4,	"name": "Empresario",	"email": "empresa@empresa.com",	"email_verified_at": "2022-02-21T14:09:31.000000Z",	"role": 1,	"current_team_id": null,	"profile_photo_path": null,	"created_at": null,	"updated_at": null,	"profile_photo_url": "https:\/\/ui-avatars.com\/api\/?name=E&color=7F9CF5&background=EBF4FF"},"endereco": {	"id": 2,	"rua": "Rua do Cateté",	"numero": "588",	"bairro": "Jardim Monte Líbano",	"cidade": "Garanhuns",	"estado": "PE",	"complemento": "Casa",	"cep": "55292-000",	"created_at": null,	"updated_at": null},"telefone": {	"id": 2,	"numero": "(34) 98192-2518",	"created_at": null,	"updated_at": null}	}},"solicitacao_poda": null	}]
     *
     * @response status=401 scenario="usuario nao autenticado" {"message": "Unauthenticated."}
     *
     * @responseField id integer O identificador da visita
     * @responseField data_marcada A data marcada para realização da visita
     * @responseField data_realizada A data em que a visita foi realizada
     * @responseField requerimento_id integer O identificador do requerimento, se a visita não for para um requerimento o valor é null
     * @responseField denuncia_id integer O identificador da denúncia, se a visita não for para uma denúncia o valor é null
     * @responseField solicitacao_poda_id integer O identificador da solicitação de poda/supressão, se a visita não for para uma solicitação de poda/supressão o valor é null
     * @responseField denuncia.id O identificador da denúncia
     * @responseField denuncia.empresa_nao_cadastrada Nome da empresa, caso não esteja cadastrada no sistema.
     * @responseField denuncia.endereco Endereco da empresa, caso não esteja cadastrada no sistema.
     * @responseField denuncia.texto Texto informando o motivo da denúncia.
     * @responseField denuncia.denunciante Nome do denunciante.
     * @responseField denuncia.aprovacao Estado da avaliação da denúncia.
     * @responseField denuncia.protocolo Protocolo gerado ao criar a denúncia.
     * @responseField denuncia.empresa_id Identificador da empresa, caso esteja cadastrada no sistema.
     * @responseField denuncia.analista_id Identificador do usuário analista atribuido a denúncia.
     * @responseField denuncia.empresa object Empresa que está sendo denunciada.
     * @responseField denuncia.empresa.id O identificador da empresa
     * @responseField denuncia.empresa.nome Nome da empresa.
     * @responseField denuncia.empresa.eh_cnpj Indica se o campo cpf_cnpj é um cnpj.
     * @responseField denuncia.empresa.cpf_cnpj CPF ou CNPJ da empresa.
     * @responseField denuncia.empresa.porte Porte da empresa.
     * @responseField denuncia.empresa.represetante_legal_id Identificador do representante legal da empresa.
     * @responseField denuncia.empresa.user_id Identificador do usuário que criou a empresa.
     * @responseField denuncia.empresa.telefone_id Identificador do telefone da empresa.
     * @responseField denuncia.empresa.endereco_id Identificador do endereço da empresa.
     * @responseField denuncia.empresa.telefone object Telefone da empresa
     * @responseField denuncia.empresa.telefone.id interger Identificador do telefone
     * @responseField denuncia.empresa.telefone.numero string Número do telefone.
     * @responseField denuncia.empresa.endereco object Endereco da empresa.
     * @responseField denuncia.empresa.endereco.id integer Identificador do endereço.
     * @responseField denuncia.empresa.endereco.rua string Nome da rua.
     * @responseField denuncia.empresa.endereco.numero string Número do endereço.
     * @responseField denuncia.empresa.endereco.bairro string Bairro do endereço.
     * @responseField denuncia.empresa.endereco.cidade string Cidade do endereço.
     * @responseField denuncia.empresa.endereco.estado string Estado do endereço.
     * @responseField denuncia.empresa.endereco.complemento string Complemento do endereço.
     * @responseField denuncia.empresa.endereco.cep string CEP do endereço.
     * @responseField denuncia.empresa.user object Usuário que criou a empresa no sistema.
     * @responseField denuncia.empresa.user.id Identificador do usuário
     * @responseField denuncia.empresa.user.name Nome do usuário
     * @responseField denuncia.empresa.user.email E-mail do usuário
     * @responseField denuncia.analista object Usuário analista.
     * @responseField denuncia.analista.id Identificador do usuário analista.
     * @responseField denuncia.analista.name Nome do usuário analista.
     * @responseField denuncia.analista.email E-mail do usuário analista.
     * @responseField requerimento object Requerimento da visita.
     * @responseField requerimento.id integer Identificador do requerimento.
     * @responseField requerimento.status integer Status do requerimento.
     * @responseField requerimento.tipo integer Tipo de requerimento.
     * @responseField requerimento.tipo_licenca integer Tipo de licença do requerimento.
     * @responseField requerimento.valor string Valor a ser pago.
     * @responseField requerimento.potencial_poluidor_atribuido string Potencial poluidor atribuido pelo protocolista.
     * @responseField requerimento.definicao_valor string Tipo da definição do valor.
     * @responseField requerimento.valor_juros string Juros a cobrado do requerimento.
     * @responseField requerimento.analista_id integer Identificador do analista.
     * @responseField requerimento.represetante_id integer Identificador do representante legal da empresa.
     * @responseField requerimento.empresa_id integer Identificador da empresa.
     * @responseField requerimento.empresa object Empresa que solicitou a licença.
     * @responseField requerimento.empresa.id O identificador da empresa
     * @responseField requerimento.empresa.nome Nome da empresa.
     * @responseField requerimento.empresa.eh_cnpj Indica se o campo cpf_cnpj é um cnpj.
     * @responseField requerimento.empresa.cpf_cnpj CPF ou CNPJ da empresa.
     * @responseField requerimento.empresa.porte Porte da empresa.
     * @responseField requerimento.empresa.represetante_legal_id Identificador do representante legal da empresa.
     * @responseField requerimento.empresa.user_id Identificador do usuário que criou a empresa.
     * @responseField requerimento.empresa.telefone_id Identificador do telefone da empresa.
     * @responseField requerimento.empresa.endereco_id Identificador do endereço da empresa.
     * @responseField requerimento.empresa.telefone object Telefone da empresa
     * @responseField requerimento.empresa.telefone.id interger Identificador do telefone
     * @responseField requerimento.empresa.telefone.numero string Número do telefone.
     * @responseField requerimento.empresa.endereco object Endereco da empresa.
     * @responseField requerimento.empresa.endereco.id integer Identificador do endereço.
     * @responseField requerimento.empresa.endereco.rua string Nome da rua.
     * @responseField requerimento.empresa.endereco.numero string Número do endereço.
     * @responseField requerimento.empresa.endereco.bairro string Bairro do endereço.
     * @responseField requerimento.empresa.endereco.cidade string Cidade do endereço.
     * @responseField requerimento.empresa.endereco.estado string Estado do endereço.
     * @responseField requerimento.empresa.endereco.complemento string Complemento do endereço.
     * @responseField requerimento.empresa.endereco.cep string CEP do endereço.
     * @responseField requerimento.empresa.user object Usuário que criou a empresa no sistema.
     * @responseField requerimento.empresa.user.id Identificador do usuário
     * @responseField requerimento.empresa.user.name Nome do usuário
     * @responseField requerimento.empresa.user.email E-mail do usuário
     * @responseField requerimento.analista object Usuário analista.
     * @responseField requerimento.analista.id Identificador do usuário analista.
     * @responseField requerimento.analista.name Nome do usuário analista.
     * @responseField requerimento.analista.email E-mail do usuário analista.
     * @responseField solicitacao_poda object Solicitação de poda/supressão
     * @responseField solicitacao_poda.id Identificador da solicitação de poda/supressão
     * @responseField solicitacao_poda.protocolo Protocolo gerado.
     * @responseField solicitacao_poda.motivo_indeferimento Motivo do indeferimento, caso tenha sido indeferida.
     * @responseField solicitacao_poda.status Situação da solicitação.
     * @responseField solicitacao_poda.analista_id Identificador do usuário analista atribuido a solicitação.
     * @responseField solicitacao_poda.endereco_id Endereço para a solicitação.
     * @responseField solicitacao_poda.comentario Comentário feito pelo requerente.
     * @responseField solicitacao_poda.requerente_id Identificador do requerente.
     * @responseField solicitacao_poda.requerente object Requerente da solicitação.
     * @responseField solicitacao_poda.requerente.id Identificador do requerente.
     * @responseField solicitacao_poda.requerente.cpf CPF do requerente.
     * @responseField solicitacao_poda.requerente.rg RG do requerente.
     * @responseField solicitacao_poda.requerente.orgao_emissor Orgão emisso do RG do requerente.
     * @responseField solicitacao_poda.requerente.user_id Usuário requerente.
     * @responseField solicitacao_poda.requerente.telefone_id Telefone do requerente.
     * @responseField solicitacao_poda.requerente.endereco_id Endereço requerente.
     * @responseField solicitacao_poda.requerente.telefone object Telefone da empresa
     * @responseField solicitacao_poda.requerente.telefone.id interger Identificador do telefone
     * @responseField solicitacao_poda.requerente.telefone.numero string Número do telefone.
     * @responseField solicitacao_poda.requerente.endereco object Endereco da empresa.
     * @responseField solicitacao_poda.requerente.endereco.id integer Identificador do endereço.
     * @responseField solicitacao_poda.requerente.endereco.rua string Nome da rua.
     * @responseField solicitacao_poda.requerente.endereco.numero string Número do endereço.
     * @responseField solicitacao_poda.requerente.endereco.bairro string Bairro do endereço.
     * @responseField solicitacao_poda.requerente.endereco.cidade string Cidade do endereço.
     * @responseField solicitacao_poda.requerente.endereco.estado string Estado do endereço.
     * @responseField solicitacao_poda.requerente.endereco.complemento string Complemento do endereço.
     * @responseField solicitacao_poda.requerente.endereco.cep string CEP do endereço.
     * @responseField solicitacao_poda.requerente.user object Usuário do requerente.
     * @responseField solicitacao_poda.requerente.user.id Identificador do usuário
     * @responseField solicitacao_poda.requerente.user.name Nome do usuário
     * @responseField solicitacao_poda.requerente.user.email E-mail do usuário
     */
    public function index(Request $request)
    {
        $dados = $request->user()->visitas()->with(
            'denuncia.empresa',
            'denuncia.empresa.user',
            'denuncia.empresa.telefone',
            'denuncia.empresa.endereco',
            'denuncia.analista',
            'requerimento',
            'requerimento.analista',
            'requerimento.empresa',
            'requerimento.empresa.user',
            'requerimento.empresa.endereco',
            'requerimento.empresa.telefone',
            'solicitacao_poda',
            'solicitacao_poda.endereco',
            'solicitacao_poda.analista',
            'solicitacao_poda.requerente',
            'solicitacao_poda.requerente.user',
        )->get()->toArray();
        $tz = 'America/Recife';
        foreach($dados as $i => $visita){
            $dt = new DateTime($visita['data_marcada'], new DateTimeZone($tz));
            $visita['data_marcada'] = ($dt->format('Y-m-d\TH:i:s.u'));

            if($visita['data_realizada'] != null){
                $dt1 = new DateTime($visita['data_realizada'], new DateTimeZone($tz));
                $visita['data_realizada'] = ($dt1->format('Y-m-d\TH:i:s.u'));
            }

            if($visita['denuncia'] != null){
                $visita['denuncia']['texto'] = strip_tags($visita['denuncia']['texto']);
            }
            $dados[$i] = $visita;
        }
        return $dados;
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
     * @responseField solicitacao_poda_id integer O identificador da solicitação de poda/supressão, se a visita não for para uma solicitação de poda/supressão o valor é null
     */
    public function get(Request $request)
    {
        return Visita::find($request->id)->toArray();
    }

    /**
     * Salvar imagem da visita
     *
     * Salva uma imagem da visita.
     *
     * @response status=200 scenario="success" {"success": "success"}
     *
     * @bodyParam id integer required O identificador da visita
     * @bodyParam image file required O arquivo da foto capturada
     * @bodyParam comentario string nullable O comentario opcional para a imagem
     */
    public function imageUpload(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            "image"      => "required|file|mimes:jpg,jpeg,bmp,png|max:2048",
            "comentario" => "nullable|string|max:1000",
        ]);

        $visita =  Visita::find($request->id);
        $arquivo = $request->image;
        $foto = new FotoVisita();
        $foto->visita_id = $visita->id;
        $foto->caminho = $arquivo->store("visitas/{$visita->id}");
        if($request->comentario != null){
            $foto->comentario = $request->comentario;
        }
        $foto->save();

        return response()->json(['success' => 'success'], 200);
    }

    /**
     * Edita o comentario da foto da visita
     *
     * @urlParam id integer required O identificador da visita.
     * @urlParam id_foto integer required O identificador da foto da visita
     *
     * @response status=200 scenario="success" {"success": "success"}
     *
     * @bodyParam comentario string nullable O comentario opcional para a imagem
     */
    public function comentarioUpdate(Request $request)
    {
        $request->validate([
            "comentario" => "nullable|string|max:1000",
        ]);

        $foto =  FotoVisita::find($request->id_foto);
        if($request->comentario != null){
            $foto->comentario = $request->comentario;
        }else{
            $foto->comentario = null;
        }
        $foto->update();

        return response()->json(['success' => 'success'], 200);
    }

    /**
     * Deletar imagem da visita
     *
     * Deleta uma imagem da visita.
     *
     * @response status=200 scenario="success" {"success": "success"}
     *
     * @urlParam id integer required O identificador da visita.
     * @urlParam id_foto integer required O identificador da foto da visita
     *
     */
    public function imageDelete(Request $request)
    {
        $foto =  FotoVisita::find($request->id_foto);
        $foto->delete();

        return response()->json(['success' => 'success'], 200);
    }

    /**
     * Concluir a visita
     *
     * Salva a informacao de que a visita foi realizada.
     *
     * @response status=200 scenario="success" {"success": "success"}
     *
     * @urlParam id integer required O identificador da visita.
     *
     */
    public function concluirVisita(Request $request)
    {
        $visita =  Visita::find($request->id);
        $visita->update(['data_realizada' => now()]);

        return response()->json(['success' => 'success'], 200);
    }

    /**
     * Fotos da visita
     *
     * Retorna as fotos anexadas a visita.
     *
     * @urlParam id integer required O identificador da visita.
     *
     * @response status=200 scenario="success" [{"id": 1, "caminho": "visitas/1/histoSiga2021.jpg", "comentario": null, "visita_id": 1, "created_at": "2022-04-08T19:08:54.000000Z", "updated_at": "2022-04-08T19:08:54.000000Z"}, {"id": 2, "caminho": "visitas/1/pizzacalabresaacebolada.jpg", "comentario": "algum comentario aqui", "visita_id": 1, "created_at": "2022-04-11T10:54:40.000000Z", "updated_at": "2022-04-11T10:54:40.000000Z"}]
     *
     * @response status=401 scenario="usuario nao autenticado" {"message": "Unauthenticated."}
     *
     * @responseField id integer O identificador da foto
     * @responseField caminho string O caminho de onde a imagem esta salva
     * @responseField comentario string O comentário opcional feito a imagem
     * @responseField visita_id integer O identificador da visita
     */
    public function getFotos(Request $request)
    {
        return Visita::find($request->id)->fotos->toArray();
    }

    /**
     * Foto da visita
     *
     * Retorna uma foto anexada a visita.
     *
     * @urlParam id integer required O identificador da visita.
     * @urlParam id_foto integer required O identificador da foto da visita.
     *
     * @response status=200 scenario="success" {"id": 2, "caminho": "visitas/1/pizzacalabresaacebolada.jpg", "comentario": "algum comentario aqui", "visita_id": 1, "created_at": "2022-04-11T10:54:40.000000Z", "updated_at": "2022-04-11T10:54:40.000000Z"}
     *
     * @response status=401 scenario="usuario nao autenticado" {"message": "Unauthenticated."}
     *
     * @responseField id integer O identificador da foto
     * @responseField caminho string O caminho de onde a imagem esta salva
     * @responseField comentario string O comentário opcional feito a imagem
     * @responseField visita_id integer O identificador da visita
     */
    public function getFotoVisita(Request $request)
    {
        return FotoVisita::find($request->id_foto)->toArray();
    }

    /**
     * Arquivo da foto da visita
     *
     * Retorna uma o arquivo da foto anexada a visita.
     *
     * @urlParam id integer required O identificador da visita.
     * @urlParam id_foto integer required O identificador da foto da visita.
     *
     * @response status=200 scenario="success" {file}
     *
     * @response status=401 scenario="usuario nao autenticado" {"message": "Unauthenticated."}
     *
     */
    public function getArquivoFotoVisita(Request $request)
    {
        $foto = FotoVisita::find($request->id_foto);
        return Storage::download($foto['caminho']);
    }
}
