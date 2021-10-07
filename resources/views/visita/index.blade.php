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
                                                                <a class="dropdown-item">Notificar</a>
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
                                                            <a class="dropdown-item" href="{{route('requerimentos.show', ['requerimento' => $visita->requerimento])}}">Visualizar</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item">Notificar</a>
                                                            <a href="@if($visita->relatorio != null){{route('relatorios.edit', ['relatorio' => $visita->relatorio])}}@else{{route('relatorios.create', ['visita' => $visita->id])}}@endif" class="dropdown-item">Relatório</a>
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
                            Tem certeza que deseja deletar a visita à empresa {{$visita->denuncia->empresa_id ? $visita->denuncia->empresa->nome : $visita->denuncia->empresa_nao_cadastrada}}?
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger" form="deletar-visita-form-{{$visita->id}}">Sim</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @else

    @endcan
</x-app-layout>
