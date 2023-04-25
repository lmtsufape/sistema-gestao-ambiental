<x-app-layout>
    @section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="col-md-12">
                        <h4 class="card-title">Solicitações de poda/supressão @if($filtro == "concluidas") com laudo enviado @else @can('isAnalistaPoda', \App\Models\User::class) atribuídas @else {{$filtro}} @endcan @endif</h4>
                    </div>
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

                <form action="{{route('podas.index', '$filtro')}}" method="get">
                    @csrf
                    <div class="form-row mb-3">
                        <div class="col-md-7">
                            <input type="text" class="form-control w-100" name="buscar" placeholder="Digite o nome do requerente/endereço" value="{{ $busca }}">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn" style="background-color: #00883D; color: white;">Buscar</button>
                        </div>
                    </div>
                </form>

                <ul class="nav nav-tabs nav-tab-custom" id="myTab" role="tablist">
                    @can('isSecretario', \App\Models\User::class)
                        <li class="nav-item">
                            <a class="nav-link @if($filtro == 'pendentes') active @endif" id="solicitacoes-pendentes-tab"
                                type="button" role="tab" @if($filtro == 'pendentes') aria-selected="true" @endif href="{{route('podas.index', 'pendentes')}}">Pendentes</a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link @if($filtro == 'encaminhadas') active @endif" id="solicitacoes-arquivadas-tab"
                            type="button" role="tab" @if($filtro == 'encaminhadas') aria-selected="true" @endif href="{{route('podas.index', 'encaminhadas')}}">Encaminhadas</a>
                    </li>
                    @can ('isSecretario', \App\Models\User::class)
                        <li class="nav-item">
                            <a class="nav-link @if($filtro == 'deferidas') active @endif" id="solicitacoes-aprovadas-tab"
                                type="button" role="tab" @if($filtro == 'deferidas') aria-selected="true" @endif href="{{route('podas.index', 'deferidas')}}">@can('isAnalistaPoda', \App\Models\User::class)  Atribuídas @else Deferidas @endcan</a>
                        </li>
                    @endcan
                    @can ('isAnalistaPoda', \App\Models\User::class)
                        <li class="nav-item">
                            <a class="nav-link @if($filtro == 'concluidas') active @endif" id="solicitacoes-concluidas-tab"
                                type="button" role="tab" @if($filtro == 'concluidas') aria-selected="true" @endif href="{{route('podas.index', 'concluidas')}}">Concluídas</a>
                        </li>
                    @endcan
                    @can ('isSecretario', \App\Models\User::class)
                        <li class="nav-item">
                            <a class="nav-link @if($filtro == 'indeferidas') active @endif" id="solicitacoes-indeferidas-tab"
                                type="button" role="tab" @if($filtro == 'indeferidas') aria-selected="true" @endif href="{{route('podas.index', 'indeferidas')}}">Indeferidas</a>
                        </li>
                    @endcan
                </ul>
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="solicitacoes-pendentes" role="tabpanel" aria-labelledby="solicitacoes-pendentes-tab">
                                <div class="table-responsive">
                                <table class="table mytable" id="podas-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col" style="text-align: center">Nome</th>
                                            <th scope="col" style="text-align: center">Analista</th>
                                            <th scope="col" style="text-align: center">Endereço</th>
                                            <th scope="col" style="text-align: center">Data</th>
                                            <th scope="col" style="text-align: center">Status</th>
                                            <th scope="col" style="text-align: center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($solicitacoes as $i => $solicitacao)
                                            <tr>
                                                <th>{{ ($solicitacoes->currentpage()-1) * $solicitacoes->perpage() + $loop->index + 1 }}</th>
                                                <td style="text-align: center">{{ $solicitacao->requerente->user->name }}</td>
                                                <td style="text-align: center">@isset($solicitacao->analista){{ $solicitacao->analista->name }}</td>@endisset
                                                <td style="text-align: center">{{ $solicitacao->endereco->enderecoSimplificado() }}</td>
                                                <td style="text-align: center">{{$solicitacao->created_at->format('d/m/Y H:i')}}</td>
                                                <td style="text-align: center">{{ucfirst($solicitacao->statusSolicitacao())}}</td>
                                                <td style="text-align: center">
                                                    <a class="icon-licenciamento" title="Visualizar pedido" href=" {{route('podas.show', $solicitacao)}} " style="cursor: pointer;"><img  class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}"  alt="Visualizar"></a>
                                                    @can ('isAnalistaPoda', \App\Models\User::class)
                                                        <a class="icon-licenciamento" title="Avaliar pedido" href=" {{route('podas.edit', $solicitacao)}} " style="cursor: pointer;">
                                                            @if ($solicitacao->laudo()->exists())
                                                                <img  class="icon-licenciamento" width="20px;" src="{{asset('img/Relatório Aprovado.svg')}}" alt="Avaliar">
                                                            @else
                                                                <img  class="icon-licenciamento" width="20px;" src="{{asset('img/Relatório Sinalizado.svg')}}" alt="Avaliar">
                                                            @endif
                                                        </a>
                                                    @endcan
                                                    @can('isSecretario', \App\Models\User::class)
                                                        <a class="icon-licenciamento" title="Avaliar pedido" href=" {{route('podas.edit', $solicitacao)}} " style="cursor: pointer;">
                                                            @if ($solicitacao->laudo()->exists())
                                                                <img  class="icon-licenciamento" width="20px;" src="{{asset('img/Relatório Aprovado.svg')}}" alt="Avaliar">
                                                            @else
                                                                <img  class="icon-licenciamento" width="20px;" src="{{asset('img/Relatório Sinalizado.svg')}}" alt="Avaliar">
                                                            @endif
                                                        </a>
                                                        @if($filtro != "indeferidas")
                                                            <a class="icon-licenciamento" title="Atribuir analista" data-toggle="modal" data-target="#modal-atribuir" onclick="adicionarIdAtribuir({{$solicitacao->id}})" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img  class="icon-licenciamento" width="20px;" src="{{asset('img/Atribuir analista.svg')}}"  alt="Atribuir a um analista"></a>
                                                        @endif
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                                @if($solicitacoes->first() == null)
                                    <div class="col-md-12 text-center" style="font-size: 18px;">
                                        Nenhuma solicitação de poda/supressão @switch($filtro) @case('pendentes')pendente @break @case('deferidas') @can('isAnalistaPoda', \App\Models\User::class) atribuída @else deferida @endcan @break @case('concluidas')concluída @break @case('indeferidas')indeferida @break @endswitch
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row justify-content-center">
                    <div class="col-md-9">
                        {{$solicitacoes->links()}}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="col-md-12 shadow-sm p-2 px-3" style="background-color: #ffffff; border-radius: 00.5rem; margin-top: 5.2rem;">
                    <div style="font-size: 21px;" class="tituloModal">
                        Legenda
                    </div>
                    <div class="mt-2 borda-baixo"></div>
                    <ul class="list-group list-unstyled">
                        <li>
                            <div title="Visualizar solicitação" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Visualizar.svg')}}" alt="Visualizar solicitação">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Visualizar solicitação
                                </div>
                            </div>
                        @can('isSecretario', \App\Models\User::class)
                            <div title="Avaliar solicitação" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Relatório Sinalizado.svg')}}" alt="Avaliar solicitação">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Avaliar solicitação (laudo não enviado)
                                </div>
                            </div>
                            <div title="Avaliar solicitação" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Relatório Aprovado.svg')}}" alt="Avaliar solicitação">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Avaliar solicitação (laudo enviado)
                                </div>
                            </div>
                            <div title="Atribuir analista" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Atribuir analista.svg')}}" alt="Atribuir analista">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Atribuir solicitação a um analista
                                </div>
                            </div>
                        @endcan
                        @can ('isAnalistaPoda', \App\Models\User::class)
                            <div title="Visualizar relatório" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Relatório Aprovado.svg')}}" alt="Visualizar laudo">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Avaliar solicitação (Laudo enviado)
                                </div>
                            </div>
                            <div title="Visualizar relatório" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Relatório Sinalizado.svg')}}" alt="Laudo com pendências">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Avaliar solicitação (Laudo com pendências)
                                </div>
                            </div>
                        @endcan
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @can('isSecretario', \App\Models\User::class)
        <div class="modal fade" id="modal-atribuir" tabindex="-1" role="dialog" aria-labelledby="modal-imagens" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Atribuir solicitação a um analista</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12" id="alerta-atribuida">
                            </div>
                        </div>
                        <form id="form-atribuir-analista-solicitacao" method="POST" action="{{route('solicitacoes.atribuir.analista')}}">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <input type="hidden" name="solicitacao_id_analista" id="solicitacao_id_analista" value="">
                                    <label for="analista">{{__('Selecione o analista')}}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select name="analista" id="analista-atribuido" class="form-control @error('analista') is-invalid @enderror" required>
                                        <option value="" selected disabled>-- {{__('Selecione o analista')}} --</option>
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
                    @if($filtro !=  "concluidas")
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cancelar</button>
                            <button type="submit" id="submeterFormBotao" class="submeterFormBotao btn btn-success btn-color-dafault" form="form-atribuir-analista-solicitacao">Atribuir</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endcan
    @push ('scripts')
        <script>
            function adicionarIdAtribuir(id) {
                document.getElementById('solicitacao_id_analista').value = id;
                $("#alerta-atribuida").html("");
                $("#analista-atribuido").val("");
                $.ajax({
                    url:"{{route('podas.info.ajax')}}",
                    type:"get",
                    data: {"solicitacao_id": id},
                    dataType:'json',
                    success: function(solicitacao) {
                        if(solicitacao.analista_atribuido != null){
                            $("#analista-atribuido").val(solicitacao.analista_atribuido.id).change();
                            let alerta = `<div class="alert alert-success" role="alert">
                                            <p>Solicitação atribuída a um analista.</p>
                                        </div>`;
                            $("#alerta-atribuida").append(alerta);
                        }
                    }
                });
            }
        </script>
    @endpush
    @endsection
</x-app-layout>
