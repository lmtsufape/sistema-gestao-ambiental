<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Solicitações de mudas
        </h2>
    </x-slot>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">Solicitações cadastradas no sistema</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Solicitações</h6>
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
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
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
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="solicitacoes-pendentes" role="tabpanel" aria-labelledby="solicitacoes-pendentes-tab">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="text-align: center">Nome</th>
                                            <th scope="col" style="text-align: center">Endereço</th>
                                            <th scope="col" style="text-align: center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($registradas as $solicitacao)
                                            <tr>
                                                <td style="text-align: center">{{ $solicitacao->nome }}</td>
                                                <td style="text-align: center">{{ $solicitacao->endereco }}</td>
                                                <td style="text-align: center">
                                                    <a href=" {{route('mudas.show', $solicitacao)}} " type="submit" >Visualizar</a>
                                                    <a href=" {{route('mudas.edit', $solicitacao)}} " type="submit" >Avaliar</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="solicitacoes-aprovadas" role="tabpanel" aria-labelledby="solicitacoes-aprovadas-tab">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="text-align: center">Nome</th>
                                            <th scope="col" style="text-align: center">Endereço</th>
                                            <th scope="col" style="text-align: center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($deferidas as $solicitacao)
                                            <tr>
                                                <td style="text-align: center">{{ $solicitacao->nome }}</td>
                                                <td style="text-align: center">{{ $solicitacao->endereco }}</td>
                                                <td style="text-align: center">
                                                    <a href=" {{route('mudas.show', $solicitacao)}} " type="submit" >Visualizar</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="solicitacoes-arquivadas" role="tabpanel" aria-labelledby="solicitacoes-arquivadas-tab">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="text-align: center">Nome</th>
                                            <th scope="col" style="text-align: center">Endereço</th>
                                            <th scope="col" style="text-align: center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($indeferidas as $solicitacao)
                                            <tr>
                                                <td style="text-align: center">{{ $solicitacao->nome }}</td>
                                                <td style="text-align: center">{{ $solicitacao->endereco }}</td>
                                                <td style="text-align: center">
                                                    <a href=" {{route('mudas.show', $solicitacao)}} " type="submit" >Visualizar</a>
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
