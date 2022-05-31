<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Visitas à empresa {{$requerimento->empresa->nome}}</h4>
                        <h6 class="card-subtitle mb-2 text-muted">Visitas > Requerimento: @if($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['primeira_licenca']) Primeira licença @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['renovacao'])Renovação @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['autorizacao'])Autorização @endif</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        @can('isRequerente', \App\Models\User::class)
                            <a title="Voltar"  href="javascript:window.history.back();">
                                <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                            </a>
                        @else
                            <a title="Voltar" href="{{route('requerimentos.show', $requerimento)}}">
                                <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                            </a>
                        @endcan
                    </div>
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
                        <table class="table-responsive">
                                <thead>
                                    <tr>
                                        <th scope="col">Data marcada</th>
                                        <th scope="col">Data realizada</th>
                                        <th scope="col">Analista</th>
                                        @can('isSecretario', \App\Models\User::class)
                                            <th scope="col">Opções</th>
                                        @endcan
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
                                            <td>{{$visita->analista->name}}</td>
                                            @can('isSecretario', \App\Models\User::class)
                                                <td>
                                                    @if($visita->notificacao != null)<a title="Notificações" href="{{route('notificacoes.show', ['notificacao' => $visita->notificacao])}}"><img class="icon-licenciamento" src="{{asset('img/notification-svgrepo-com.svg')}}" alt="Icone de notificações"></a>@endif
                                                    @if($visita->relatorio!=null)<a title="Relatório" href="{{route('relatorios.show', ['relatorio' => $visita->relatorio])}}"><img class="icon-licenciamento" src="{{asset('img/report-svgrepo-com.svg')}}" alt="Icone de relatório"></a>@endif
                                                    @if($visita->requerimento != null)<a title="Editar visita" href="{{route('requerimento.visitas.edit', ['requerimento_id' => $visita->requerimento->id, 'visita_id' => $visita->id])}}"><img class="icon-licenciamento" src="{{asset('img/edit-svgrepo-com.svg')}}" alt="Icone de editar visita"></a>@endif
                                                    <a title="Deletar visita" data-toggle="modal" data-target="#modalStaticDeletarVisita_{{$visita->id}}" style="cursor: pointer;"><img class="icon-licenciamento" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Icone de deletar visita"></a>
                                                </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                            Tem certeza que deseja deletar a visita à empresa {{$visita->requerimento->empresa->nome}}?
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
    @endsection
</x-app-layout>
