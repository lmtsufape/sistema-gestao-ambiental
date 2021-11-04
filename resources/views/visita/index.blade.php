<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Visitas') }}
        </h2>
    </x-slot>

    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                @can('isSecretario', \App\Models\User::class)
                                    <h5 class="card-title">Visitas cadastradas no sistema</h5>
                                @else
                                    <h5 class="card-title">Visitas programadas para você</h5>
                                @endcan
                                <h6 class="card-subtitle mb-2 text-muted">Visitas</h6>
                            </div>
                            @can('isSecretario', \App\Models\User::class)
                                <div class="col-md-4" style="text-align: right">
                                    <a class="btn btn-primary" href="{{route('visitas.create')}}">Criar visita</a>
                                </div>
                            @endif
                        </div>
                        <div div class="form-row">
                            @if(session('success'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-success" role="alert">
                                        <p>{{session('success')}}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Data marcada</th>
                                        <th scope="col">Data realizada</th>
                                        <th scope="col">Requerimento</th>
                                        <th scope="col">Empresa</th>
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
                                            @endif


                                            @can('isSecretario', \App\Models\User::class)
                                                <td>{{$visita->analista->name}}</td>
                                            @endcan
                                            <td>
                                                @can('isSecretario', \App\Models\User::class)
                                                    <div class="btn-group">
                                                        <div class="dropdown">
                                                            <button class="btn btn-light dropdown-toggle shadow-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <img class="filter-green" src="{{asset('img/icon_acoes.svg')}}" style="width: 4px;">
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                                @if($visita->relatorio!=null)<a class="dropdown-item" href="{{route('relatorios.show', ['relatorio' => $visita->relatorio])}}">Relatório</a>@endif
                                                                <hr>
                                                                @if($visita->notificacao != null)<a class="dropdown-item" href="{{route('notificacoes.show', ['notificacao' => $visita->notificacao])}}">Notificação</a>@endif
                                                                @if($visita->requerimento != null)<a class="dropdown-item" href="{{route('visitas.edit', ['visita' => $visita->id])}}">Editar visita</a>@endif
                                                                <a class="dropdown-item" data-toggle="modal" data-target="#modalStaticDeletarVisita_{{$visita->id}}" style="color: red; cursor: pointer;">Deletar visita</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-ligth dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <img src="{{asset('img/icon_acoes.svg')}}" alt="ações" style="margin-right: 10px;">
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            @if ($visita->requerimento != null)
                                                                <a class="dropdown-item" href="{{route('requerimentos.show', ['requerimento' => $visita->requerimento])}}">Visualizar</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" href="{{route('empresas.notificacoes.index', ['empresa' => $visita->requerimento->empresa])}}">Notificações</a>
                                                                <a href="@if($visita->relatorio != null){{route('relatorios.edit', ['relatorio' => $visita->relatorio])}}@else{{route('relatorios.create', ['visita' => $visita->id])}}@endif" class="dropdown-item">Relatório</a>
                                                                @if($visita->requerimento->licenca != null) <a class="dropdown-item" href="{{route('licenca.show', ['licenca' => $visita->requerimento->licenca])}}">Visualizar licença</a> @elseif($visita->relatorioAceito()) <a class="dropdown-item" href="{{route('licenca.create', ['requerimento' => $visita->id])}}">Emitir licença</a> @endif
                                                            @elseif ($visita->denuncia != null)
                                                                <a href="@if($visita->relatorio != null){{route('relatorios.edit', ['relatorio' => $visita->relatorio])}}@else{{route('relatorios.create', ['visita' => $visita->id])}}@endif" class="dropdown-item">Relatório</a>
                                                                @if ($visita->denuncia->empresa != null)
                                                                    <a class="dropdown-item" href="{{route('empresas.notificacoes.index', ['empresa' => $visita->denuncia->empresa])}}">Notificações</a>
                                                                @endif
                                                                <button type="button" class="btn btn-primary btn-sm dropdown-item" style="font-size:15px;"
                                                                    data-toggle="modal" data-target="#modal-texto-{{$visita->denuncia->id}}">Descrição</button>
                                                                <button type="button" class="btn btn-primary btn-sm dropdown-item" style="font-size:15px;"
                                                                    data-toggle="modal" data-target="#modal-imagens-{{$visita->denuncia->id}}">Imagens</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
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
                            Tem certeza que deseja deletar a visita à empresa
                            @if ($visita->denuncia != null)@if ($visita->denuncia->empresa_id != null){{$visita->denuncia->empresa->nome}}@else{{$visita->denuncia->empresa_nao_cadastrada}}@endif @elseif($visita->requerimento != null){{$visita->requerimento->empresa->nome}}@endif?
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="submeterFormBotao" class="btn btn-danger" form="deletar-visita-form-{{$visita->id}}">Sim</button>
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
                        <div class="modal-header" style="background-color:#2a9df4;">
                                <img src="{{ asset('img/logo_atencao3.png') }}" width="30px;" alt="Logo" style=" margin-right:15px; margin-top:10px;"/>
                                    <h5 class="modal-title" id="exampleModalLabel2" style="font-size:20px; margin-top:7px; color:white;
                                        font-weight:bold; font-family: 'Roboto', sans-serif;">
                                        Descrição
                                    </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="formRequerimento" method="POST" action="">
                            @csrf
                            <div class="modal-body">
                                <div class="row form-row">
                                    <div id="avisoReq" class="col-12" style="font-family: 'Roboto', sans-serif; margin-bottom:10px;">Relato descrito pelo denunciante:</div>
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
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade bd-example-modal-lg" id="modal-imagens-{{$denuncia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelC" aria-hidden="true">
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
                                <div class="col-12" style="font-family: 'Roboto', sans-serif;">Imagens anexadas junto a denúncia:</div>
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
            </div>
        @endif
    @endforeach
</x-app-layout>
