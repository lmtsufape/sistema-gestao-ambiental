<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-between">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Solicitações de mudas {{$filtro}}</h4>
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

                <form action="{{route('mudas.index', $filtro)}}" method="get">
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
                    <li class="nav-item">
                        <a class="nav-link @if($filtro == 'pendentes') active @endif" id="solicitacoes-pendentes-tab"
                            type="button" role="tab" @if($filtro == 'pendentes') aria-selected="true" @endif href="{{route('mudas.index', 'pendentes')}}">Pendentes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($filtro == 'deferidas') active @endif" id="solicitacoes-aprovadas-tab"
                            type="button" role="tab" @if($filtro == 'deferidas') aria-selected="true" @endif href="{{route('mudas.index', 'deferidas')}}">Deferidas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($filtro == 'indeferidas') active @endif" id="solicitacoes-arquivadas-tab"
                            type="button" role="tab" @if($filtro == 'indeferidas') aria-selected="true" @endif href="{{route('mudas.index', 'indeferidas')}}">Indeferidas</a>
                    </li>
                </ul>
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="solicitacoes-pendentes" role="tabpanel" aria-labelledby="solicitacoes-pendentes-tab">
                                <div class="table-responsive">
                                <table class="table mytable" id="mudas-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col" style="text-align: center">Nome</th>
                                            <th scope="col" style="text-align: center">Endereço</th>
                                            <th scope="col" style="text-align: center">Data</th>
                                            <th scope="col" style="text-align: center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mudas as $i => $solicitacao)
                                            <tr>
                                                <th>{{ ($mudas->currentpage()-1) * $mudas->perpage() + $loop->index + 1 }}</th>
                                                <td style="text-align: center">{{ $solicitacao->requerente->user->name }}</td>
                                                <td style="text-align: center">{{ $solicitacao->requerente->endereco->rua }}</td>
                                                <td style="text-align: center">{{ $solicitacao->created_at->format('d/m/Y H:i') }}</td>
                                                <td style="text-align: center">
                                                    <a class="icon-licenciamento" title="Visualizar pedido" href=" {{route('mudas.show', $solicitacao)}} " style="cursor: pointer;"><img  class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}"  alt="Visualizar"></a>
                                                    <a class="icon-licenciamento" title="Avaliar pedido" href=" {{route('mudas.edit', $solicitacao)}} " style="cursor: pointer;"><img  class="icon-licenciamento" src="{{asset('img/Avaliação.svg')}}"  alt="Avaliar"></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                                @if($mudas->first() == null)
                                    <div class="col-md-12 text-center" style="font-size: 18px;">
                                        Nenhuma solicitação de muda @switch($filtro) @case('pendentes')pendente @break @case('deferidas')deferida @break @case('indeferidas')indeferida @break @endswitch
                                    </div>
                                @endif
                            </div>
                            {{--<div class="tab-pane fade" id="solicitacoes-aprovadas" role="tabpanel" aria-labelledby="solicitacoes-aprovadas-tab">
                                <div class="table-responsive">
                                <table class="table mytable" id="mudas-table">
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
                                </div>
                                @if($deferidas->first() == null)
                                    <div class="col-md-12 text-center" style="font-size: 18px;">
                                        Nenhuma solicitação de muda deferida
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
                                </div>
                                @if($indeferidas->first() == null)
                                    <div class="col-md-12 text-center" style="font-size: 18px;">
                                        Nenhuma solicitação de muda indeferida
                                    </div>
                                @endif
                            </div>--}}
                        </div>
                    </div>
                </div>
                <div class="form-row justify-content-center">
                    <div class="col-md-9">
                        {{$mudas->links()}}
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
                        </li>
                        <li>
                            <div title="Avaliar solicitação" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Avaliação.svg')}}" alt="Avaliar solicitação">
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
    @endsection
    @push ('scripts')
    @endpush
</x-app-layout>
