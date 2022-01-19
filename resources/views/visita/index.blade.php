<x-app-layout>

    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        @can('isSecretario', \App\Models\User::class)
                            <h4 class="card-title">Visitas</h4>
                        @else
                            <h4 class="card-title">Visitas programadas para você</h4>
                        @endcan
                    </div>
                    @can('isSecretario', \App\Models\User::class)
                        <div class="col-md-4" style="text-align: right;">
                            <a title="Criar visita" href="{{route('visitas.create')}}">
                                <img class="icon-licenciamento add-card-btn" src="{{asset('img/Grupo 1666.svg')}}" alt="Icone de adicionar documento">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-10">
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
                        </div>
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
                                                    @elseif($visita->relatorioAceito())
                                                        <a class="btn btn-success btn-color-dafault" href="{{route('licenca.create', ['requerimento' => $visita->id])}}">Criar licença</a>
                                                    @endif
                                                    @if($visita->notificacao != null)<a title="Notificações" href="{{route('notificacoes.show', ['notificacao' => $visita->notificacao])}}"><img class="icon-licenciamento" src="{{asset('img/notification-svgrepo-com.svg')}}" alt="Icone de notificações"></a>@endif
                                                    @if($visita->relatorio!=null)<a title="Relatório" href="{{route('relatorios.show', ['relatorio' => $visita->relatorio])}}"><img class="icon-licenciamento" src="{{asset('img/report-svgrepo-com.svg')}}" alt="Icone de relatório"></a>@endif
                                                    @if($visita->requerimento != null)<a title="Editar visita" href="{{route('visitas.edit', ['visita' => $visita->id])}}"><img class="icon-licenciamento" src="{{asset('img/edit-svgrepo-com.svg')}}" alt="Icone de editar visita"></a>@endif
                                                    <a title="Deletar visita" data-toggle="modal" data-target="#modalStaticDeletarVisita_{{$visita->id}}" style="cursor: pointer;"><img class="icon-licenciamento" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Icone de deletar visita"></a>
                                                @else
                                                    @if ($visita->requerimento != null)
                                                        <a title="Visualizar requerimento" href="{{route('visitas.requerimento.show', ['visita_id' => $visita->id, 'requerimento_id' => $visita->requerimento->id])}}"><img class="icon-licenciamento" src="{{asset('img/eye-svgrepo-com.svg')}}" alt="Icone de analisar requerimento"></a>

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
                                                        <a title="Descrição" data-toggle="modal" data-target="#modal-texto-{{$denuncia->id}}"><img class="icon-licenciamento" src="{{asset('img/eye.svg')}}"  alt="Descrição"></a>
                                                        <a title="Mídia" data-toggle="modal" data-target="#modal-imagens-{{$denuncia->id}}"><img class="icon-licenciamento" src="{{asset('img/media.svg')}}"  alt="Mídia"></a>
                                                    @elseif ($visita->solicitacao_poda != null)
                                                        <a title="Relatório" href="@if($visita->relatorio != null){{route('relatorios.edit', ['relatorio' => $visita->relatorio])}}@else{{route('relatorios.create', ['visita' => $visita->id])}}@endif"><img class="icon-licenciamento" src="{{asset('img/report-svgrepo-com.svg')}}" alt="Icone de relatório"></a>
                                                        <a title="Mídia" data-toggle="modal" style="cursor: pointer;" data-target="#modal-imagens-solicitacao-{{$visita->solicitacao_poda->id}}"><img class="icon-licenciamento" src="{{asset('img/media.svg')}}" alt="Mídia"></a>
                                                    @endif
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
                                    <h5 class="modal-title" style="font-size:20px; color:white; font-weight:bold; font-family: 'Roboto', sans-serif;">
                                        Mídias da solicitação
                                    </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12" style="font-family: 'Roboto', sans-serif;">Imagens anexadas junto a solicitação:</div>
                            </div>
                            <br>
                            <div class="row">
                                @foreach ($solicitacao->fotos as $foto)
                                    <div class="col-md-6">
                                        <div class="card" style="width: 100%;">
                                            <img src="{{asset('storage/' . $foto->caminho)}}" class="card-img-top" alt="...">
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
</x-app-layout>
