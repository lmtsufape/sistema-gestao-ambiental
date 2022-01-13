<x-app-layout>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Podas</h4>
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
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="solicitacoes-pendentes-tab" data-toggle="tab" href="#solicitacoes-pendentes"
                            type="button" role="tab" aria-controls="solicitacoes-pendentes" aria-selected="true">Pendentes</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="solicitacoes-aprovadas-tab" data-toggle="tab" role="tab" type="button"
                            aria-controls="solicitacoes-aprovadas" aria-selected="false" href="#solicitacoes-aprovadas">Deferidas</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" type="button" id="solicitacoes-arquivadas-tab" data-toggle="tab" role="tab"
                            aria-controls="solicitacoes-arquivadas" aria-selected="false" href="#solicitacoes-arquivadas">Indeferidas</button>
                    </li>
                </ul>
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="solicitacoes-pendentes" role="tabpanel" aria-labelledby="solicitacoes-pendentes-tab">
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
                                        @foreach ($registradas as $i => $solicitacao)
                                            <tr>
                                                <td>{{($i+1)}}</td>
                                                <td style="text-align: center">{{ $solicitacao->cidadao->user->name }}</td>
                                                <td style="text-align: center">@isset($solicitacao->analista){{ $solicitacao->analista->name }}</td>@endisset
                                                <td style="text-align: center">{{ $solicitacao->endereco->enderecoSimplificado() }}</td>
                                                <td style="text-align: center">
                                                    @can('isSecretario', \App\Models\User::class)
                                                        <a class="icon-licenciamento" title="Atribuir analista" data-toggle="modal" data-target="#modal-atribuir" onclick="adicionarIdAtribuir({{$solicitacao->id}})" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img  width="25" src="{{asset('img/task-svgrepo-com.svg')}}"  alt="Atribuir a um analista"></a>
                                                        <a class="icon-licenciamento" title="Agendar visita" id="btn-criar-visita-{{$solicitacao->id}}" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"
                                                            data-toggle="modal" data-target="#modal-agendar-visita" onclick="adicionarId({{$solicitacao->id}})"><img width="25" src="{{asset('img/agenda-svgrepo-com.svg')}}"  alt="Agendar uma visita"></a>
                                                    @endcan
                                                    <a class="icon-licenciamento" title="Mídia da solicitação" data-toggle="modal" data-target="#modal-imagens-{{$solicitacao->id}}" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img width="25" src="{{asset('img/media.svg')}}"  alt="Mídia"></a>
                                                    <a class="icon-licenciamento" title="Visualizar pedido" href=" {{route('podas.show', $solicitacao)}} " type="submit" style="cursor: pointer;"><img  width="25" src="{{asset('img/eye-svgrepo-com.svg')}}"  alt="Visualizar"></a>
                                                    <a class="icon-licenciamento" title="Avaliar pedido" href=" {{route('podas.edit', $solicitacao)}} " type="submit" style="cursor: pointer;"><img  width="25" src="{{asset('img/file-warning-svgrepo-com.svg')}}"  alt="Avaliar"></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="solicitacoes-aprovadas" role="tabpanel" aria-labelledby="solicitacoes-aprovadas-tab">
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
                                                <td style="text-align: center">{{ $solicitacao->cidadao->user->name }}</td>
                                                <td style="text-align: center">@isset($solicitacao->analista){{ $solicitacao->analista->name }}</td>@endisset
                                                <td style="text-align: center">{{ $solicitacao->endereco->enderecoSimplificado() }}</td>
                                                <td style="text-align: center">
                                                    @can('isSecretario', \App\Models\User::class)
                                                        <a class="icon-licenciamento" title="Atribuir analista" data-toggle="modal" data-target="#modal-atribuir" onclick="adicionarIdAtribuir({{$solicitacao->id}})" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img  width="25" src="{{asset('img/task-svgrepo-com.svg')}}"  alt="Atribuir a um analista"></a>
                                                        <a class="icon-licenciamento" title="Agendar visita" id="btn-criar-visita-{{$solicitacao->id}}" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"
                                                            data-toggle="modal" data-target="#modal-agendar-visita" onclick="adicionarId({{$solicitacao->id}})"><img width="25" src="{{asset('img/agenda-svgrepo-com.svg')}}"  alt="Agendar uma visita"></a>
                                                    @endcan
                                                    <a class="icon-licenciamento" title="Mídia da solicitação" data-toggle="modal" data-target="#modal-imagens-{{$solicitacao->id}}" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img width="25" src="{{asset('img/media.svg')}}"  alt="Mídia"></a>
                                                    <a class="icon-licenciamento" title="Visualizar pedido" href=" {{route('podas.show', $solicitacao)}} " type="submit" style="cursor: pointer;"><img  width="25" src="{{asset('img/eye-svgrepo-com.svg')}}"  alt="Visualizar"></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="solicitacoes-arquivadas" role="tabpanel" aria-labelledby="solicitacoes-arquivadas-tab">
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
                                                <td style="text-align: center">{{ $solicitacao->cidadao->user->name }}</td>
                                                <td style="text-align: center">@isset($solicitacao->analista){{ $solicitacao->analista->name }}</td>@endisset
                                                <td style="text-align: center">{{ $solicitacao->endereco->enderecoSimplificado() }}</td>
                                                <td style="text-align: center">
                                                    <a class="icon-licenciamento" href=" {{route('podas.show', $solicitacao)}} " type="submit" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img  width="25" src="{{asset('img/eye-svgrepo-com.svg')}}"  alt="Visualizar"></a>
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
        </div>
    </div>
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
    <div class="modal fade" id="modal-agendar-visita" tabindex="-1" role="dialog" aria-labelledby="modal-imagens" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agendar visita para a solicitação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="form-criar-visita-solicitacao" method="POST" action="{{route('solicitacoes.visita.create')}}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <label for="data">{{__('Data da visita')}}</label>
                                <input type="date" name="data" id="data" class="form-control @error('data') is-invalid @enderror" value="{{old('data')}}">

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
                                <label for="analista">{{__('Selecione o analista da visita')}}</label>
                                <select name="analista" id="analista" class="form-control @error('analista') is-invalid @enderror">
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
                    <button type="submit" class="btn btn-success" form="form-criar-visita-solicitacao">Criar</button>
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
                        <form id="form-atribuir-analista-solicitacao" method="POST" action="{{route('solicitacoes.atribuir.analista')}}">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <input type="hidden" name="solicitacao_id_analista" id="solicitacao_id_analista" value="">
                                    <label for="analista">{{__('Selecione o analista')}}</label>
                                    <select name="analista" id="analista" class="form-control @error('analista') is-invalid @enderror">
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
                        <button type="submit" id="submeterFormBotao" class="btn btn-success" form="form-atribuir-analista-solicitacao">Criar</button>
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
        }

        function adicionarIdAtribuir(id) {
            document.getElementById('solicitacao_id_analista').value = id;
        }
    </script>
</x-app-layout>
