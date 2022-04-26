<x-app-layout>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-between">
            <div class="col-md-9">
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
                                                <td style="text-align: center">{{ $solicitacao->requerente->user->name }}</td>
                                                <td style="text-align: center">{{ $solicitacao->requerente->endereco->rua }}</td>
                                                <td style="text-align: center">
                                                    <a class="icon-licenciamento" title="Visualizar pedido" href=" {{route('mudas.show', $solicitacao)}} " type="submit" style="cursor: pointer;"><img  class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}"  alt="Visualizar"></a>
                                                    <a class="icon-licenciamento" title="Avaliar pedido" href=" {{route('mudas.edit', $solicitacao)}} " type="submit" style="cursor: pointer;"><img  class="icon-licenciamento" src="{{asset('img/Avaliação.svg')}}"  alt="Avaliar"></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if($registradas->first() == null)
                                    <div class="col-md-12 text-center" style="font-size: 18px;">
                                        Nenhuma solicitação de muda pendente
                                    </div>
                                @endif
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
                                                <td style="text-align: center">{{ $solicitacao->requerente->user->name }}</td>
                                                <td style="text-align: center">{{ $solicitacao->requerente->endereco->rua }}</td>
                                                <td style="text-align: center">
                                                    <a class="icon-licenciamento" href=" {{route('mudas.show', $solicitacao)}} " type="submit" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img  class="icon-licenciamento" src="{{asset('img/Visualizar.svg')}}"  alt="Visualizar"></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if($deferidas->first() == null)
                                    <div class="col-md-12 text-center" style="font-size: 18px;">
                                        Nenhuma solicitação de muda deferida
                                    </div>
                                @endif
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
                                                <td style="text-align: center">{{ $solicitacao->requerente->user->name }}</td>
                                                <td style="text-align: center">{{ $solicitacao->requerente->endereco->rua }}</td>
                                                <td style="text-align: center">
                                                    <a class="icon-licenciamento" href=" {{route('mudas.show', $solicitacao)}} " type="submit" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img  class="icon-licenciamento" src="{{asset('img/Visualizar.svg')}}"  alt="Visualizar"></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if($indeferidas->first() == null)
                                    <div class="col-md-12 text-center" style="font-size: 18px;">
                                        Nenhuma solicitação de muda indeferida
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="col-md-12 shadow-sm p-2 px-3" style="background-color: #f8f9fa; border-radius: 00.5rem; margin-top: 5.2rem;">
                    <div style="font-size: 21px;" class="tituloModal">
                        Legenda
                    </div>
                    <ul class="list-group list-unstyled">
                        <li>
                            <div title="Visualizar solicitação" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                <img class="aling-middle" width="20" src="{{asset('img/Visualizar.svg')}}" alt="Visualizar solicitação">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Visualizar solicitação
                                </div>
                            </div>
                        </li>
                        <li>
                            <div title="Avaliar solicitação" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                <img class="aling-middle" width="20" src="{{asset('img/Avaliação.svg')}}" alt="Avaliar solicitação">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Avaliar solicitação
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
