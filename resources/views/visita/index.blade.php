<x-app-layout>
    @section('content')
    <div class="container" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="col-md-8">
                        @can('isSecretario', \App\Models\User::class)
                            <h4 class="card-title">Visitas</h4>
                        @else
                            <h4 class="card-title">Visitas programadas para você</h4>
                        @endcan
                    </div>

                    <div class="col-md-4" style="text-align: right;">
                        <a class="btn btn-success btn-color-dafault" href="{{route('gerar.pdf.visitas')}}">Baixar</a>
                        @can('isSecretario', \App\Models\User::class)
                            <a title="Criar visita" href="{{route('visitas.create')}}">
                                <img class="icon-licenciamento add-card-btn" src="{{asset('img/Grupo 1666.svg')}}" alt="Icone de adicionar documento">
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card card-borda-esquerda" style="width: 100%;">
                    <div class="card-body">
                        <div div class="form-row">
                            @if(session('success'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-success" role="alert">
                                        <p>{{session('success')}}</p>
                                    </div>
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-danger" role="alert">
                                        <p>{{session('error')}}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="table-responsive">
                        <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Data marcada</th>
                                        <th scope="col">Data realizada</th>
                                        <th scope="col">Requerimento</th>
                                        <th scope="col">Empresa/serviço</th>
                                        @can('isSecretario', \App\Models\User::class)
                                            <th scope="col">Analista</th>
                                        @endcan
                                        <th scope="col">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visitas as $visita)
                                        <tr>
                                            <td>{{date('d/m/Y', strtotime($visita->data_marcada))}}</td>
                                            @if ($visita->data_realizada != null)
                                                <td>{{date('d/m/Y', strtotime($visita->data_realizada))}}</td>
                                            @else
                                                <td>{{$visita->data_realizada}}</td>
                                            @endif

                                            @if($visita->requerimento != null)
                                                @if($visita->requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['primeira_licenca'])
                                                    <td> Primeira licença</td>
                                                @elseif($visita->requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['renovacao'])
                                                    <td>Renovação</td>
                                                @elseif($visita->requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['autorizacao'])
                                                    <td>Autorização</td>
                                                @endif

                                                <td>{{$visita->requerimento->empresa->nome}}</td>
                                            @elseif($visita->denuncia != null)
                                                <td>Denúncia</td>
                                                <td>{{$visita->denuncia->empresa_id ? $visita->denuncia->empresa->nome : $visita->denuncia->empresa_nao_cadastrada}}</td>
                                            @elseif ($visita->solicitacao_poda != null)
                                                <td>Solicitação de poda</td>
                                                <td>{{$visita->solicitacao_poda->nome}}</td>
                                            @endif


                                            @can('isSecretario', \App\Models\User::class)
                                                <td>{{$visita->analista->name}}</td>
                                            @endcan
                                            <td>
                                                @can('isSecretario', \App\Models\User::class)
                                                    @if($visita->requerimento != null && $visita->requerimento->licenca != null)
                                                        @if ($visita->requerimento->licenca->status == \App\Models\Licenca::STATUS_ENUM['aprovada'])
                                                            <a class="btn btn-success btn-color-dafault" href="{{route('licenca.show', ['licenca' => $visita->requerimento->licenca])}}">Visualizar licença</a>
                                                        @else
                                                            <a class="btn btn-success btn-color-dafault" href="{{route('licenca.revisar', ['visita' => $visita, 'licenca' => $visita->requerimento->licenca])}}">Editar licença</a>
                                                        @endif
                                                    @elseif($visita->relatorioAceito() && $visita->requerimento_id  != null)
                                                        <a class="btn btn-success btn-color-dafault" href="{{route('licenca.create', ['requerimento' => $visita->id])}}">Criar licença</a>
                                                    @endif
                                                    @if($visita->requerimento_id != null && $visita->requerimento->empresa->notificacoes->first() != null)<a title="Notificações" href="{{route('empresas.notificacoes.index', ['empresa' => $visita->requerimento->empresa])}}"><img class="icon-licenciamento" src="{{asset('img/notification-svgrepo-com.svg')}}" alt="Icone de notificações"></a>@endif
                                                    @if($visita->relatorio!=null)<a title="Relatório" href="{{route('relatorios.show', ['relatorio' => $visita->relatorio])}}"><img class="icon-licenciamento" src="{{asset('img/report-svgrepo-com.svg')}}" alt="Icone de relatório"></a>@endif
                                                    @if($visita->requerimento != null)<a title="Editar visita" href="{{route('visitas.edit', ['visita' => $visita->id])}}"><img class="icon-licenciamento" src="{{asset('img/edit-svgrepo-com.svg')}}" alt="Icone de editar visita"></a>@endif
                                                    <a title="Deletar visita" data-toggle="modal" data-target="#modalStaticDeletarVisita_{{$visita->id}}" style="cursor: pointer;"><img class="icon-licenciamento" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Icone de deletar visita"></a>
                                                @else
                                                    @if ($visita->requerimento != null)
                                                        <a title="Visualizar requerimento" href="{{route('visitas.requerimento.show', ['visita_id' => $visita->id, 'requerimento_id' => $visita->requerimento->id])}}"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}" alt="Icone de analisar requerimento"></a>

                                                        <a title="Notificações" href="{{route('empresas.notificacoes.index', ['empresa' => $visita->requerimento->empresa])}}"><img class="icon-licenciamento" src="{{asset('img/notification-svgrepo-com.svg')}}" alt="Icone de notificações"></a>
                                                        <a title="Relatório" href="@if($visita->relatorio != null){{route('relatorios.edit', ['relatorio' => $visita->relatorio])}}@else{{route('relatorios.create', ['visita' => $visita->id])}}@endif"><img class="icon-licenciamento" src="{{asset('img/report-svgrepo-com.svg')}}" alt="Icone de relatório">
                                                        @if($visita->requerimento->licenca != null)
                                                            <a class="btn btn-success btn-color-dafault" href="{{route('licenca.revisar', ['licenca' => $visita->requerimento->licenca, 'visita' => $visita])}}">Revisar licença</a>
                                                        @endif
                                                    @elseif ($visita->denuncia != null)
                                                        <a title="Relatório" href="@if($visita->relatorio != null){{route('relatorios.edit', ['relatorio' => $visita->relatorio])}}@else{{route('relatorios.create', ['visita' => $visita->id])}}@endif"><img class="icon-licenciamento" src="{{asset('img/report-svgrepo-com.svg')}}" alt="Icone de relatório"></a>
                                                        @if ($visita->denuncia->empresa != null)
                                                            <a title="Notificações" href="{{route('empresas.notificacoes.index', ['empresa' => $visita->denuncia->empresa])}}"><img class="icon-licenciamento" src="{{asset('img/notification-svgrepo-com.svg')}}" alt="Icone de notificações"></a>
                                                        @endif
                                                        <a title="Descrição" data-toggle="modal" data-target="#modal-texto-{{$visita->denuncia->id}}" style="cursor: pointer;"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}"  alt="Descrição"></a>
                                                    @elseif ($visita->solicitacao_poda != null)
                                                        <a class="icon-licenciamento" title="Visualizar pedido" href=" {{route('podas.show', $visita->solicitacao_poda)}} " type="submit" style="cursor: pointer;"><img  class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}"  alt="Visualizar"></a>
                                                        <a title="Relatório" href="@if($visita->relatorio != null){{route('relatorios.edit', ['relatorio' => $visita->relatorio])}}@else{{route('relatorios.create', ['visita' => $visita->id])}}@endif"><img class="icon-licenciamento" src="{{asset('img/report-svgrepo-com.svg')}}" alt="Icone de relatório"></a>
                                                    @endif
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                        </div>
                        @if($visitas->first() == null)
                            <div class="col-md-12 text-center" style="font-size: 18px;">
                                @can('isSecretario', \App\Models\User::class)
                                    {{__('Nenhuma visita criada')}}
                                @else
                                    {{__('Nenhuma visita programada para você')}}
                                @endcan
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-row justify-content-center">
                    <div class="col-md-10">
                        {{$visitas->links()}}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="col-md-12 shadow-sm p-2 px-3" style="background-color: #f8f9fa; border-radius: 00.5rem; margin-top: 2.6rem;">
                    <div style="font-size: 21px;" class="tituloModal">
                        Legenda
                    </div>
                    <ul class="list-group list-unstyled">
                        @can('isSecretario', \App\Models\User::class)
                            <li>
                                <div title="Criar visita" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                    <img class="aling-middle" style="border-radius: 50%;" width="20" src="{{asset('img/Grupo 1666.svg')}}" alt="Icone de Criar visita">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Criar visita
                                    </div>
                                </div>
                            </li>
                            {{--consulta necessaria pra verificar se tem notificacao feitas--}}
                            <li>
                                <div title="Visualizar notificações" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                    <img class="aling-middle" width="20" src="{{asset('img/notification-svgrepo-com.svg')}}" alt="Visualizar notificações">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Visualizar notificações
                                    </div>
                                </div>
                            </li>
                            @if(\App\Models\Relatorio::select('relatorios.*')
                                    ->whereIn('visita_id', $visitas->pluck('id')->toArray())
                                    ->get()->count() > 0)
                                <li>
                                    <div title="Visualizar relatório" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                        <img class="aling-middle" width="20" src="{{asset('img/report-svgrepo-com.svg')}}" alt="Visualizar relatório">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Visualizar relatório
                                        </div>
                                    </div>
                                </li>
                            @endif
                            @if($visitas->where('requerimento_id', '!=', null)->first() != null || $visitas->where('denuncia_id', '!=', null)->first() != null)
                                <li>
                                    <div title="Deletar visita" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                        <img class="aling-middle" width="20" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Deletar visita">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Deletar visita
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @else
                            @if($visitas->where('requerimento_id', '!=', null)->first() != null)
                                <li>
                                    <div title="Visualizar requerimento" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                        <img class="aling-middle" width="20" src="{{asset('img/Visualizar.svg')}}" alt="Visualizar requerimento">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Visualizar requerimento
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div title="Notificações" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                        <img class="aling-middle" width="20" src="{{asset('img/notification-svgrepo-com.svg')}}" alt="Notificações">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Notificações
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div title="Criar/editar relatório" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                        <img class="aling-middle" width="20" src="{{asset('img/report-svgrepo-com.svg')}}" alt="Criar/editar relatório">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Criar/editar relatório
                                        </div>
                                    </div>
                                </li>
                            @elseif($visitas->where('denuncia_id', '!=', null)->first() != null && $visitas->where('requerimento_id', '=', null)->first() != null)
                                <li>
                                    <div title="Criar/editar relatório" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                        <img class="aling-middle" width="20" src="{{asset('img/report-svgrepo-com.svg')}}" alt="Criar/editar relatório">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Criar/editar relatório
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div title="Notificações" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                        <img class="aling-middle" width="20" src="{{asset('img/notification-svgrepo-com.svg')}}" alt="Notificações">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Notificações
                                        </div>
                                    </div>
                                </li>
                            @endif
                            @if($visitas->where('denuncia_id', '!=', null)->first() != null)
                                <li>
                                    <div title="Relato da denúncia" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                        <img class="aling-middle" width="20" src="{{asset('img/Visualizar.svg')}}" alt="Relato da denúncia">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Relato da denúncia
                                        </div>
                                    </div>
                                </li>
                            @elseif($visitas->where('solicitacao_poda_id', '!=', null)->first() != null)
                                <li>
                                    <div title="Visualizar solicitação" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                        <img class="aling-middle" width="20" src="{{asset('img/Visualizar.svg')}}" alt="Visualizar solicitação">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Visualizar solicitação
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div title="Criar/editar relatório" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                        <img class="aling-middle" width="20" src="{{asset('img/report-svgrepo-com.svg')}}" alt="Criar/editar relatório">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Criar/editar relatório
                                        </div>
                                    </div>
                                </li>
                            @elseif ($visitas->where('denuncia_id', '=', null)->first() != null && $visitas->where('requerimento_id', '=', null)->first() != null && $visitas->where('solicitacao_poda', '!=', null)->first() != null)
                                <li>
                                    <div title="Criar/editar relatório" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                        <img class="aling-middle" width="20" src="{{asset('img/report-svgrepo-com.svg')}}" alt="Criar/editar relatório">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Criar/editar relatório
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endcan
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @can('isSecretario', \App\Models\User::class)
        @foreach ($visitas as $visita)
        <!-- Modal deletar visita -->
        <div class="modal fade" id="modalStaticDeletarVisita_{{$visita->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #dc3545;">
                        <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Confirmação</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="deletar-visita-form-{{$visita->id}}" method="POST" action="{{route('visitas.destroy', ['visita' => $visita])}}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            Tem certeza que deseja deletar a visita?
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger submeterFormBotao" form="deletar-visita-form-{{$visita->id}}">Sim</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else

    @endcan

    @foreach ($visitas as $visita)
        @if ($visita->denuncia != null)
            @php
                $denuncia = $visita->denuncia;
            @endphp
            <div class="modal fade" id="modal-texto-{{$denuncia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel2">
                                Descrição
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row form-row">
                                <label for="relato">{{__('Relato descrito pelo denunciante:')}}</label>
                                <div class="col-md-12 form-group">
                                    <div class="texto-denuncia">
                                        {!! $denuncia->texto !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                @if ($denuncia->denunciante != null)
                                    <div class="col-md-12 form-group">
                                        <label for="denunciante">{{__('Denunciante')}}</label>
                                        <input class="form-control" type="text" value="{{$denuncia->denunciante}}" disabled>
                                    </div>
                                @endif
                            </div>
                            @if($denuncia->fotos->first() != null)
                                <div class="row form-row">
                                    <div class="col-md-12 form-group">
                                        <label for="imagens_anexadas">{{__('Imagens anexadas:')}}</label>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                @foreach ($denuncia->fotos as $foto)
                                    <div class="col-md-6">
                                        <div class="card" style="width: 100%;">
                                            <img src="{{route('denuncias.imagem', $foto->id)}}" class="card-img-top" alt="...">
                                            @if ($foto->comentario != null)
                                                <div class="card-body">
                                                    <p class="card-text">{{$foto->comentario}}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--<div class="modal fade bd-example-modal-lg" id="modal-imagens-{{$denuncia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelC" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#2a9df4;">
                                <img src="{{ asset('img/logo_atencao3.png') }}" alt="Logo" style=" margin-right:15px;"/>
                                    <h5 class="modal-title" style="font-size:20px; color:white; font-weight:bold; font-family: 'Roboto', sans-serif;">
                                        Mídias da Denúncia
                                    </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12" style="font-family: 'Roboto', sans-serif;">Imagens anexadas:</div>
                            </div>
                            <br>
                            <div class="row">
                                @foreach ($denuncia->fotos as $foto)
                                    <div class="col-md-6">
                                        <div class="card" style="width: 100%;">
                                            <img src="{{asset('storage/' . $foto->caminho)}}" class="card-img-top" alt="...">
                                            @if ($foto->comentario != null)
                                                <div class="card-body">
                                                    <p class="card-text">{{$foto->comentario}}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if ($denuncia->videos->first() != null)
                                <div class="row">
                                    <div class="col-12" style="font-family: 'Roboto', sans-serif;">Vídeos anexados junto a denúncia:</div>
                                </div>
                                <br>
                                <div class="row">
                                    @foreach ($denuncia->videos as $video)
                                        <div class="col-md-6">
                                            <video width="320" height="240" controls>
                                                <source src="{{asset('storage/' . $video->caminho)}}" >
                                                Seu navegador não suporta o tipo de vídeo.
                                            </video>
                                            <div class="card" style="width: 100%;">
                                                @if ($video->comentario != null)
                                                    <div class="card-body">
                                                        <p class="card-text">{{$video->comentario}}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>--}}
        @endif
    @endforeach

    @foreach ($visitas as $visita)
        @if ($visita->solicitacao_poda != null)
            @php
                $solicitacao = $visita->solicitacao_poda;
            @endphp
            <div class="modal fade bd-example-modal-lg" id="modal-imagens-solicitacao-{{$solicitacao->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelC" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#2a9df4;">
                                <img src="{{ asset('img/logo_atencao3.png') }}" alt="Logo" style=" margin-right:15px;"/>
                                    <h5 class="modal-title" style="font-size:20px; color:white; font-weight:bold;">
                                        Mídias da solicitação
                                    </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">Imagens anexadas:</div>
                            </div>
                            <br>
                            <div class="row">
                                @foreach ($solicitacao->fotos as $foto)
                                    <div class="col-md-6">
                                        <div class="card" style="width: 100%;">
                                            <img src="{{route('podas.foto', ['solicitacao' => $solicitacao->id, 'foto' => $foto->id])}}" class="card-img-top" alt="...">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    @endsection
</x-app-layout>
