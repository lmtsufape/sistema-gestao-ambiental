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
    <div class="container" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Solicitações de poda/supressão @if($filtro == "concluidas") com relatório aprovado @else @can('isAnalistaPoda', \App\Models\User::class) atribuídas @else {{$filtro}} @endcan @endif</h4>
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
                <ul class="nav nav-tabs nav-tab-custom" id="myTab" role="tablist">
                    @can('isSecretario', \App\Models\User::class)
                        <li class="nav-item">
                            <a class="nav-link @if($filtro == 'pendentes') active @endif" id="solicitacoes-pendentes-tab"
                                type="button" role="tab" @if($filtro == 'pendentes') aria-selected="true" @endif href="{{route('podas.index', 'pendentes')}}">Pendentes</a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link @if($filtro == 'deferidas') active @endif" id="solicitacoes-aprovadas-tab"
                            type="button" role="tab" @if($filtro == 'deferidas') aria-selected="true" @endif href="{{route('podas.index', 'deferidas')}}">@can('isAnalistaPoda', \App\Models\User::class)  Atribuídas @else Deferidas @endcan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($filtro == 'concluidas') active @endif" id="solicitacoes-concluidas-tab"
                            type="button" role="tab" @if($filtro == 'concluidas') aria-selected="true" @endif href="{{route('podas.index', 'concluidas')}}">Concluídas</a>
                    </li>
                    @can('isSecretario', \App\Models\User::class)
                        <li class="nav-item">
                            <a class="nav-link @if($filtro == 'indeferidas') active @endif" id="solicitacoes-arquivadas-tab"
                                type="button" role="tab" @if($filtro == 'indeferidas') aria-selected="true" @endif href="{{route('podas.index', 'indeferidas')}}">Indeferidas</a>
                        </li>
                    @endcan
                </ul>
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="solicitacoes-pendentes" role="tabpanel" aria-labelledby="solicitacoes-pendentes-tab">
                                <div class="table-responsive">
                                <table class="table mytable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col" style="text-align: center">Nome</th>
                                            <th scope="col" style="text-align: center">Analista</th>
                                            <th scope="col" style="text-align: center">Endereço</th>
                                            <th scope="col" style="text-align: center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($solicitacoes as $i => $solicitacao)
                                            <tr>
                                                <th>{{($i+1)}}</th>
                                                <td style="text-align: center">{{ $solicitacao->requerente->user->name }}</td>
                                                <td style="text-align: center">@isset($solicitacao->analista){{ $solicitacao->analista->name }}</td>@endisset
                                                <td style="text-align: center">{{ $solicitacao->endereco->enderecoSimplificado() }}</td>
                                                <td style="text-align: center">
                                                    <a class="icon-licenciamento" title="Visualizar pedido" href=" {{route('podas.show', $solicitacao)}} " style="cursor: pointer;"><img  class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}"  alt="Visualizar"></a>
                                                    <a class="icon-licenciamento" title="Avaliar pedido" href=" {{route('podas.edit', $solicitacao)}} " style="cursor: pointer;"><img  class="icon-licenciamento" width="20px;" src="{{asset('img/Avaliação.svg')}}"  alt="Avaliar"></a>
                                                    @can('isAnalistaPoda', \App\Models\User::class)
                                                        @if($filtro ==  "concluidas")
                                                            <a title="Relatório" href="{{route('relatorios.show', ['relatorio' => $solicitacao->visita->relatorio])}}">
                                                                <img class="icon-licenciamento" src="{{asset('img/report-svgrepo-com.svg')}}" alt="Icone de relatório">
                                                            </a>
                                                        @endif
                                                    @endcan
                                                    @can('isSecretario', \App\Models\User::class)
                                                        @if($filtro != "indeferidas" && $filtro != "pendentes")
                                                            <a class="icon-licenciamento" title="Atribuir analista" data-toggle="modal" data-target="#modal-atribuir" onclick="adicionarIdAtribuir({{$solicitacao->id}})" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img  class="icon-licenciamento" width="20px;" src="{{asset('img/Atribuir analista.svg')}}"  alt="Atribuir a um analista"></a>
                                                            <a class="icon-licenciamento" title="Agendar visita" id="btn-criar-visita-{{$solicitacao->id}}" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"
                                                            data-toggle="modal" data-target="#modal-agendar-visita" onclick="adicionarId({{$solicitacao->id}})"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Agendar.svg')}}"  alt="Agendar uma visita"></a>
                                                        @endif
                                                        @if($filtro ==  "concluidas")
                                                            @if($solicitacao->visita->relatorio!=null)<a title="Relatório" href="{{route('relatorios.show', ['relatorio' => $solicitacao->visita->relatorio])}}"><img class="icon-licenciamento" @if($solicitacao->visita->relatorio->aprovacao == \App\Models\Relatorio::APROVACAO_ENUM['aprovado'])
                                                                src="{{asset('img/Relatório Aprovado.svg')}}"
                                                            @else
                                                                src="{{asset('img/Relatório Sinalizado.svg')}}"
                                                            @endif alt="Icone de relatório"></a>@endif
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
                            {{--<div class="tab-pane fade" id="solicitacoes-aprovadas" role="tabpanel" aria-labelledby="solicitacoes-aprovadas-tab">
                                <div class="table-responsive">
                                <table class="table mytable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col" style="text-align: center">Nome</th>
                                            <th scope="col" style="text-align: center">Analista</th>
                                            <th scope="col" style="text-align: center">Endereço</th>
                                            <th scope="col" style="text-align: center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($deferidas as $i => $solicitacao)
                                            <tr>
                                                <td>{{($i+1)}}</td>
                                                <td style="text-align: center">{{ $solicitacao->requerente->user->name }}</td>
                                                <td style="text-align: center">@isset($solicitacao->analista){{ $solicitacao->analista->name }}</td>@endisset
                                                <td style="text-align: center">{{ $solicitacao->endereco->enderecoSimplificado() }}</td>
                                                <td style="text-align: center">
                                                    <a class="icon-licenciamento" title="Visualizar pedido" href=" {{route('podas.show', $solicitacao)}} " type="submit" style="cursor: pointer;"><img  class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}"  alt="Visualizar"></a>
                                                    <a class="icon-licenciamento" title="Mídia da solicitação" data-toggle="modal" data-target="#modal-imagens-{{$solicitacao->id}}" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar mídia.svg')}}"  alt="Mídia"></a>
                                                    @can('isSecretario', \App\Models\User::class)
                                                        <a class="icon-licenciamento" title="Atribuir analista" data-toggle="modal" data-target="#modal-atribuir" onclick="adicionarIdAtribuir({{$solicitacao->id}})" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Atribuir analista.svg')}}"  alt="Atribuir a um analista"></a>
                                                        <a class="icon-licenciamento" title="Agendar visita" id="btn-criar-visita-{{$solicitacao->id}}" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"
                                                            data-toggle="modal" data-target="#modal-agendar-visita" onclick="adicionarId({{$solicitacao->id}})"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Agendar.svg')}}"  alt="Agendar uma visita"></a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                                @if($deferidas->first() == null)
                                    <div class="col-md-12 text-center" style="font-size: 18px;">
                                        Nenhuma solicitação de poda/supressão deferida
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="solicitacoes-arquivadas" role="tabpanel" aria-labelledby="solicitacoes-arquivadas-tab">
                                <div class="table-responsive">
                                <table class="table mytable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col" style="text-align: center">Nome</th>
                                            <th scope="col" style="text-align: center">Analista</th>
                                            <th scope="col" style="text-align: center">Endereço</th>
                                            <th scope="col" style="text-align: center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($indeferidas as $i => $solicitacao)
                                            <tr>
                                                <td>{{($i+1)}}</td>
                                                <td style="text-align: center">{{ $solicitacao->requerente->user->name }}</td>
                                                <td style="text-align: center">@isset($solicitacao->analista){{ $solicitacao->analista->name }}</td>@endisset
                                                <td style="text-align: center">{{ $solicitacao->endereco->enderecoSimplificado() }}</td>
                                                <td style="text-align: center">
                                                    <a class="icon-licenciamento" href=" {{route('podas.show', $solicitacao)}} " type="submit" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img  class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}"  alt="Visualizar"></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                                @if($indeferidas->first() == null)
                                    <div class="col-md-12 text-center" style="font-size: 18px;">
                                        Nenhuma solicitação de poda/supressão indeferida
                                    </div>
                                @endif
                            </div>--}}
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
                    <div style="font-size: 21px; text-align: right" class="tituloModal">
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
                            <div title="Avaliar solicitação" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Avaliação.svg')}}" alt="Avaliar solicitação">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Avaliar solicitação
                                </div>
                            </div>
                        {{--<li>
                            <div title="Mídia da solicitação" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Visualizar mídia.svg')}}" alt="Mídia da solicitação">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Mídia da solicitação
                                </div>
                            </div>
                        </li>--}}
                        @can('isSecretario', \App\Models\User::class)
                            <div title="Atribuir analista" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Atribuir analista.svg')}}" alt="Atribuir analista">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Atribuir solicitação a um analista
                                </div>
                            </div>
                            <div title="Agendar visita" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Agendar.svg')}}" alt="Agendar visita">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Agendar uma visita
                                </div>
                            </div>
                        @endcan
                        @if($filtro ==  "concluidas")
                            <div title="Visualizar relatório" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Relatório Aprovado.svg')}}" alt="Visualizar relatório">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Relatório aprovado
                                </div>
                            </div>
                            <div title="Visualizar relatório" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Relatório Sinalizado.svg')}}" alt="Visualizar relatório">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Relatório com pendências
                                </div>
                            </div>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{--
    @foreach ($solicitacoes as $solicitacao)
        <div class="modal fade bd-example-modal-lg" id="modal-imagens-{{$solicitacao->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelC" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Mídias da Solicitação
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    --}}
    <div class="modal fade" id="modal-agendar-visita" tabindex="-1" role="dialog" aria-labelledby="modal-imagens" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agendar visita para a solicitação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="alerta-agendar">
                        </div>
                    </div>
                    <form id="form-criar-visita-solicitacao" method="POST" action="{{route('solicitacoes.visita.create')}}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <label for="data">{{__('Data da visita')}}<span style="color: red; font-weight: bold;">*</span></label>
                                <input type="date" name="data" id="data" class="form-control @error('data') is-invalid @enderror" value="{{old('data')}}" required>

                                @error('data')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                 <input type="hidden" name="solicitacao_id" id="solicitacao_id" value="">
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
                    <button type="submit" class="submeterFormBotao btn btn-success btn-color-dafault" form="form-criar-visita-solicitacao">Agendar</button>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cancelar</button>
                        <button type="submit" id="submeterFormBotao" class="submeterFormBotao btn btn-success btn-color-dafault" form="form-atribuir-analista-solicitacao">Atribuir</button>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    @if (old('solicitacao_id') != null)
        <script>
            $(document).ready(function() {
                $('#link-solicitacoes-aprovados').click();
                $("#btn-criar-visita-{{old('solicitacao_id')}}").click();
            });
        </script>
    @endif
    <script>
        function adicionarId(id) {
            document.getElementById('solicitacao_id').value = id;
            $("#alerta-agendar").html("");
            $("#analista-visita").val("");
            document.getElementById('data').value = "";
            $.ajax({
                url:"{{route('podas.info.ajax')}}",
                type:"get",
                data: {"solicitacao_id": id},
                dataType:'json',
                success: function(solicitacao) {
                    if(solicitacao.analista_visita != null){
                        $("#analista-visita").val(solicitacao.analista_visita.id).change();
                        document.getElementById('data').value = solicitacao.marcada;
                        let alerta = `<div class="alert alert-success" role="alert">
                                        <p>Visita da solicitação agendada.</p>
                                      </div>`;
                        $("#alerta-agendar").append(alerta);
                    }
                }
            });
        }

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
    @endsection
</x-app-layout>
