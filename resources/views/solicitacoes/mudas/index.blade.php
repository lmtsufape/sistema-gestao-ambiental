<x-app-layout>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Mudas</h4>
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
                                            <th scope="col" style="text-align: center">Endereço</th>
                                            <th scope="col" style="text-align: center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($registradas as $i => $solicitacao)
                                            <tr>
                                                <td>{{($i+1)}}</td>
                                                <td style="text-align: center">{{ $solicitacao->nome }}</td>
                                                <td style="text-align: center">{{ $solicitacao->endereco }}</td>
                                                <td style="text-align: center">
                                                    <a title="Visualizar pedido" href=" {{route('mudas.show', $solicitacao)}} " type="submit" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img  width="25" src="{{asset('img/eye-svgrepo-com.svg')}}"  alt="Visualizar"></a>
                                                    <a title="Avaliar pedido" href=" {{route('mudas.edit', $solicitacao)}} " type="submit" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img  width="25" src="{{asset('img/file-warning-svgrepo-com.svg')}}"  alt="Avaliar"></a>
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
                                            <th scope="col" style="text-align: center">Endereço</th>
                                            <th scope="col" style="text-align: center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($deferidas as $i => $solicitacao)
                                            <tr>
                                                <td>{{($i+1)}}</td>
                                                <td style="text-align: center">{{ $solicitacao->nome }}</td>
                                                <td style="text-align: center">{{ $solicitacao->endereco }}</td>
                                                <td style="text-align: center">
                                                    <a href=" {{route('mudas.show', $solicitacao)}} " type="submit" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img  width="25" src="{{asset('img/eye-svgrepo-com.svg')}}"  alt="Visualizar"></a>
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
                                            <th scope="col" style="text-align: center">Endereço</th>
                                            <th scope="col" style="text-align: center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($indeferidas as $i => $solicitacao)
                                            <tr>
                                                <td>{{($i+1)}}</td>
                                                <td style="text-align: center">{{ $solicitacao->nome }}</td>
                                                <td style="text-align: center">{{ $solicitacao->endereco }}</td>
                                                <td style="text-align: center">
                                                    <a href=" {{route('mudas.show', $solicitacao)}} " type="submit" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img  width="25" src="{{asset('img/eye-svgrepo-com.svg')}}"  alt="Visualizar"></a>
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
</x-app-layout>
