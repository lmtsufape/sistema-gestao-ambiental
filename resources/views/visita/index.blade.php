<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="col-md-8">
                        @can('isSecretario', \App\Models\User::class)
                            <h4 class="card-title">Programação de visitas</h4>
                        @else
                            <h4 class="card-title">Visitas programadas para você</h4>
                        @endcan
                    </div>

                    <div class="col-md-4" style="text-align: right;">
                        <a class="btn btn-success btn-color-dafault" href="{{route('gerar.pdf.visitas')}}">Baixar</a>
                        @can('isSecretario', \App\Models\User::class)
                            @if($filtro == 'requerimento')
                                <a title="Criar visita" href="{{route('visitas.create')}}">
                                    <img class="icon-licenciamento " src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de adicionar documento">
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
                <ul class="nav nav-tabs nav-tab-custom" id="myTab" role="tablist">
                    @can('isSecretarioOrProcesso', \App\Models\User::class)
                        <li class="nav-item">
                            <a class="nav-link @if($filtro == 'requerimento') active @endif" id="visitas-atuais-tab" role="tab" type="button"
                                @if($filtro == 'requerimento') aria-selected="true" @endif href="{{route('visitas.index', 'requerimento')}}">Requerimentos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if($filtro == 'denuncia') active @endif" id="visitas-finalizados-tab" role="tab" type="button"
                                @if($filtro == 'denuncia') aria-selected="true" @endif href="{{route('visitas.index', 'denuncia')}}">Denúncias</a>
                        </li>
                    @endcan
                    @can('isAnalistaPodaOrSecretario', \App\Models\User::class)
                        <li class="nav-item">
                            <a class="nav-link @if($filtro == 'poda') active @endif" id="visitas-cancelados-tab" role="tab" type="button"
                                @if($filtro == 'poda') aria-selected="true" @endif href="{{route('visitas.index', 'poda')}}">Poda/Supressão</a>
                        </li>
                    @endcan
                </ul>
                <div class="card" style="width: 100%;">
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
                                        <th scope="col">#</th>
                                        <th scope="col" class="align-middle">Data de requerimento</th>
                                        <th scope="col" class="align-middle">Data marcada</th>
                                        <th scope="col" class="align-middle">Data realizada</th>
                                        @if($filtro == "requerimento" || $filtro == "denuncia")
                                            <th scope="col" class="align-middle">Empresa/serviço</th>
                                        @else
                                            <th scope="col" class="align-middle">Requerente</th>
                                        @endif
                                        @if($filtro == "requerimento")
                                            <th scope="col" class="align-middle">Tipo</th>
                                        @endif
                                        @can('isSecretario', \App\Models\User::class)
                                            <th scope="col" class="align-middle">Analista</th>
                                        @endcan
                                        <th scope="col" class="align-middle">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visitas as $i => $visita)
                                        <tr>
                                            <td scope="row" style="font-weight: bold">{{ ($visitas->currentpage()-1) * $visitas->perpage() + $loop->index + 1 }}</td>
                                            @if($visita->requerimento != null)
                                                <td>{{date('d/m/Y H:i', strtotime($visita->requerimento->created_at))}}</td>
                                            @elseif($visita->denuncia != null)
                                                <td>{{date('d/m/Y H:i', strtotime($visita->denuncia->created_at))}}</td>
                                            @elseif($visita->solicitacaoPoda != null)
                                                <td>{{date('d/m/Y H:i', strtotime($visita->solicitacaoPoda->created_at))}}</td>
                                            @endif
                                            <td>{{date('d/m/Y', strtotime($visita->data_marcada))}}</td>
                                            @if ($visita->data_realizada != null)
                                                <td>{{date('d/m/Y', strtotime($visita->data_realizada))}}</td>
                                            @else
                                                <td>{{__('Aguardando visita')}}</td>
                                            @endif

                                            @if($visita->requerimento != null)
                                                <td>{{$visita->requerimento->empresa->nome}}</td>
                                                <td>
                                                    {{ucfirst($visita->requerimento->tipoString())}}
                                                </td>
                                            @elseif($visita->denuncia != null)
                                                <td>{{$visita->denuncia->empresa_id ? $visita->denuncia->empresa->nome : $visita->denuncia->empresa_nao_cadastrada}}</td>
                                            @elseif ($visita->solicitacaoPoda != null)
                                                <td>{{$visita->solicitacaoPoda->requerente->user->name}}</td>
                                            @endif


                                            @can('isSecretario', \App\Models\User::class)
                                                <td>{{$visita->analista->name}}</td>
                                            @endcan
                                            <td>
                                                @can('isSecretario', \App\Models\User::class)

                                                    @if($visita->relatorio!=null)
                                                        <a title="Relatório" href="{{route('relatorios.show', ['relatorio' => $visita->relatorio])}}">
                                                            <img class="icon-licenciamento"
                                                            @if ($visita->relatorio->aprovacao == \App\Models\Relatorio::APROVACAO_ENUM['aprovado'])
                                                                src="{{asset('img/Relatório Aprovado.svg')}}"
                                                            @else
                                                                src="{{asset('img/Relatório Sinalizado.svg')}}"
                                                            @endif
                                                            alt="Icone de relatório">
                                                        </a>
                                                    @endif
                                                    @if($visita->requerimento_id != null)<a title="Notificações" href="{{route('empresas.notificacoes.index', ['empresa' => $visita->requerimento->empresa])}}"><img class="icon-licenciamento" src="{{asset('img/notification-svgrepo-com.svg')}}" alt="Icone de notificações"></a>@endif
                                                    @if($visita->requerimento != null)
                                                        <a title="Editar visita" href="{{route('visitas.edit', ['visita' => $visita->id])}}">
                                                            <img class="icon-licenciamento" src="{{asset('img/edit-svgrepo-com.svg')}}" alt="Icone de editar visita">
                                                        </a>
                                                    @else
                                                        <a class="icon-licenciamento" style="cursor: pointer;" title="Editar visita" id="btn-criar-visita-{{$visita->id}}" data-toggle="modal" data-target="#modal-agendar-visita" onclick="adicionarId({{$visita->id}})">
                                                            <img class="icon-licenciamento" src="{{asset('img/edit-svgrepo-com.svg')}}" alt="Icone de editar visita">
                                                        </a>
                                                    @endif
                                                    <a title="Deletar visita" data-toggle="modal" data-target="#modalStaticDeletarVisita_{{$visita->id}}" style="cursor: pointer;"><img class="icon-licenciamento" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Icone de deletar visita"></a>
                                                @else
                                                    @if ($visita->requerimento != null)
                                                        <a title="Visualizar requerimento" href="{{route('visitas.requerimento.show', ['visita_id' => $visita->id, 'requerimento_id' => $visita->requerimento->id])}}"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}" alt="Icone de analisar requerimento"></a>
                                                        <a title="Relatório" href="@if($visita->relatorio != null){{route('relatorios.edit', ['relatorio' => $visita->relatorio])}}@else{{route('relatorios.create', ['visita' => $visita->id])}}@endif"><img class="icon-licenciamento"
                                                            @if ($visita->relatorio != null && $visita->relatorio->aprovacao == \App\Models\Relatorio::APROVACAO_ENUM['aprovado'])
                                                                src="{{asset('img/Relatório Aprovado.svg')}}"
                                                            @else
                                                                src="{{asset('img/Relatório Sinalizado.svg')}}"
                                                            @endif alt="Icone de relatório">
                                                        @if($visita->requerimento_id != null)<a title="Notificações" href="{{route('empresas.notificacoes.index', ['empresa' => $visita->requerimento->empresa])}}"><img class="icon-licenciamento" src="{{asset('img/notification-svgrepo-com.svg')}}" alt="Icone de notificações"></a>@endif
                                                    @elseif ($visita->denuncia != null)
                                                        <a title="Descrição" data-toggle="modal" data-target="#modal-texto-{{$visita->denuncia->id}}" style="cursor: pointer;"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}"  alt="Descrição"></a>
                                                        <a title="Relatório" href="@if($visita->relatorio != null){{route('relatorios.edit', ['relatorio' => $visita->relatorio])}}@else{{route('relatorios.create', ['visita' => $visita->id])}}@endif"><img class="icon-licenciamento"
                                                            @if ($visita->relatorio != null && $visita->relatorio->aprovacao == \App\Models\Relatorio::APROVACAO_ENUM['aprovado'])
                                                                src="{{asset('img/Relatório Aprovado.svg')}}"
                                                            @else
                                                                src="{{asset('img/Relatório Sinalizado.svg')}}"
                                                            @endif alt="Icone de relatório"></a>
                                                    @elseif ($visita->solicitacaoPoda != null)
                                                        <a class="icon-licenciamento" title="Visualizar pedido" href=" {{route('podas.show', $visita->solicitacaoPoda)}} " style="cursor: pointer;"><img  class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}"  alt="Visualizar"></a>
                                                        <a title="Relatório" href="@if($visita->relatorio != null){{route('relatorios.edit', ['relatorio' => $visita->relatorio])}}@else{{route('relatorios.create', ['visita' => $visita->id])}}@endif"><img class="icon-licenciamento"
                                                            @if ($visita->relatorio != null && $visita->relatorio->aprovacao == \App\Models\Relatorio::APROVACAO_ENUM['aprovado'])
                                                                src="{{asset('img/Relatório Aprovado.svg')}}"
                                                            @else
                                                                src="{{asset('img/Relatório Sinalizado.svg')}}"
                                                            @endif alt="Icone de relatório"></a>
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
                <div class="col-md-12 shadow-sm p-2 px-3" style="background-color: #ffffff; border-radius: 00.5rem; margin-top: 5.2rem;">
                    <div style="font-size: 21px;" class="tituloModal">
                        Legenda
                    </div>
                    <div class="mt-2 borda-baixo"></div>
                    <ul class="list-group list-unstyled mt-2">
                        @can('isSecretario', \App\Models\User::class)
                            @if($filtro == 'requerimento')
                                <li>
                                    <div title="Criar visita" class="d-flex align-items-center my-1 pt-0 pb-1">
                                        <img class="icon-licenciamento aling-middle" style="border-radius: 50%;" width="20" src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de Criar visita">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Criar visita para requerimento
                                        </div>
                                    </div>
                                </li>
                            @endif
                            @if(\App\Models\Relatorio::select('relatorios.*')
                                    ->whereIn('visita_id', $visitas->pluck('id')->toArray())
                                    ->get()->count() > 0)
                                <li>
                                    <div title="Visualizar relatório" class="d-flex align-items-center my-1 pt-0 pb-1">
                                        <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Relatório Aprovado.svg')}}" alt="Visualizar relatório">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Relatório aprovado
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div title="Visualizar relatório" class="d-flex align-items-center my-1 pt-0 pb-1">
                                        <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Relatório Sinalizado.svg')}}" alt="Visualizar relatório">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Relatório com pendências
                                        </div>
                                    </div>
                                </li>
                            @endif
                            @if($filtro == 'requerimento')
                                <li>
                                    <div title="Notificação" class="d-flex align-items-center my-1 pt-0 pb-1">
                                        <img class="icon-licenciamento aling-middle" style="border-radius: 50%;" width="20" src="{{asset('img/notification-svgrepo-com.svg')}}" alt="Notificações">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Notificações à empresa
                                        </div>
                                    </div>
                                </li>
                            @endif
                            <li>
                                <div title="Editar visita" class="d-flex align-items-center my-1 pt-0 pb-1" ">
                                    <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/edit-svgrepo-com.svg')}}" alt="Editar visita">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Editar visita
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div title="Deletar visita" class="d-flex align-items-center my-1 pt-0 pb-1" ">
                                    <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Deletar visita">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Deletar visita
                                    </div>
                                </div>
                            </li>
                        @else
                            @if($filtro == 'requerimento')
                                <li>
                                    <div title="Visualizar requerimento" class="d-flex align-items-center my-1 pt-0 pb-1" ">
                                        <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Visualizar.svg')}}" alt="Visualizar requerimento">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Visualizar requerimento
                                        </div>
                                    </div>
                                </li>
                            @elseif($filtro == 'denuncia')
                                <li>
                                    <div title="Relato da denúncia" class="d-flex align-items-center my-1 pt-0 pb-1" ">
                                        <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Visualizar.svg')}}" alt="Relato da denúncia">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Relato da denúncia
                                        </div>
                                    </div>
                                </li>
                            @elseif($filtro == 'poda')
                                <li>
                                    <div title="Visualizar solicitação" class="d-flex align-items-center my-1 pt-0 pb-1" ">
                                        <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Visualizar.svg')}}" alt="Visualizar solicitação">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Visualizar solicitação
                                        </div>
                                    </div>
                                </li>
                            @endif
                            <li>
                                <li>
                                    <div title="Visualizar relatório" class="d-flex align-items-center my-1 pt-0 pb-1">
                                        <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Relatório Aprovado.svg')}}" alt="Visualizar relatório">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Relatório aprovado
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div title="Visualizar relatório" class="d-flex align-items-center my-1 pt-0 pb-1">
                                        <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Relatório Sinalizado.svg')}}" alt="Visualizar relatório">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Relatório com pendências
                                        </div>
                                    </div>
                                </li>
                            </li>
                            @if($filtro == 'requerimento')
                                <li>
                                    <div title="Notificação" class="d-flex align-items-center my-1 pt-0 pb-1">
                                        <img class="icon-licenciamento aling-middle" style="border-radius: 50%;" width="20" src="{{asset('img/notification-svgrepo-com.svg')}}" alt="Notificações">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Notificações à empresa
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
    @can('isSecretario', \App\Models\User::class)
        <div class="modal fade" id="modal-agendar-visita" tabindex="-1" role="dialog" aria-labelledby="modal-imagens" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar visita</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-criar-visita-denuncia" method="POST" action="{{route('visitas.visita.edit')}}">
                            @csrf
                            <input type="hidden" name="filtro" id="filtro" value="{{$filtro}}">
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="data">{{__('Data da visita')}}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input type="date" name="data" id="data" class="form-control @error('data') is-invalid @enderror" required value="{{old('data')}}">

                                    @error('data')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <input type="hidden" name="visita_id" id="visita_id" value="">
                                    <label for="analista">{{__('Selecione o analista da visita')}}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select name="analista" id="analista-visita" class="form-control @error('analista') is-invalid @enderror" required>
                                        <option value="" selected disabled>-- {{__('Selecione o analista da visita')}} --</option>
                                        @foreach ($analistas as $analista)
                                            <option @if(old('analista') == $analista->id) selected @endif value="{{$analista->id}}">{{$analista->name}}</option>
                                        @endforeach
                                    </select>

                                    @error('analista')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cancelar</button>
                        <button type="submit" class="submeterFormBotao btn btn-success btn-color-dafault" form="form-criar-visita-denuncia">Editar</button>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    @foreach ($visitas as $visita)
        @if ($visita->solicitacaoPoda != null)
            @php
                $solicitacao = $visita->solicitacaoPoda;
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
    @push ('scripts')
        <script>
            function adicionarId(id) {
                document.getElementById('visita_id').value = id;
                $("#analista-visita").val("");
                document.getElementById('data').value = "";
                $.ajax({
                    url:"{{route('visitas.info.ajax')}}",
                    type:"get",
                    data: {"visita_id": id},
                    dataType:'json',
                    success: function(visita) {
                        if(visita.analista_visita != null){
                            $("#analista-visita").val(visita.analista_visita.id).change();
                            document.getElementById('data').value = visita.marcada;
                        }
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
