<x-app-layout>
    @section('content')
        <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
            <div class="form-row justify-content-start">
                <div class="col-md-9 col-span-3">
                    <div class="form-row justify-content-between">
                        <div class="col-xs-8">
                            <h4 class="card-title">Caminhão Pipa</h4>
                        </div>
                        <div class="col-xs-4">
                            <a title="Solicitar serviço" class="ml-2" href="{{ route('solicitacao_servicos.create') }}">
                                <img class="icon-licenciamento" src="{{ asset('img/Grupo 1666.svg') }}" style="height: 35px"
                                    alt="Icone de solicitação de serviço">
                            </a>
                        </div>
                    </div>
                    @can('isSecretarioOrBeneficiario', \App\Models\User::class)
                        <form action="{{ route('solicitacao_servicos.index') }}" method="get">
                            @csrf
                            <div class="form-row mb-3">
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="buscar"
                                        placeholder="Digite o nome do Beneficiário, Código ou nome do Motorista">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn"
                                        style="background-color: #00883D; color: white;">Buscar</button>
                                </div>
                            </div>
                        </form>
                    @endcan
                    <div div class="form-row">
                        @if (session('success'))
                            <div class="col-md-12" style="margin-top: 5px;">
                                <div class="alert alert-success" role="alert">
                                    <p>{{ session('success') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="form-row">
                        @if (session('error'))
                            <div class="col-md-12" style="margin-top: 5px;">
                                <div class="alert alert-danger" role="alert">
                                    <p>{{ session('error') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="form-row justify-content-center">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs nav-tab-custom" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @if ($filtro == 'andamento') active @endif" id="andamento-tab"
                                        data-toggle="tab" href="#andamento" role="tab" aria-controls="andamento"
                                        aria-selected="@if ($filtro == 'andamento') true @else false @endif">Em
                                        andamento</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if ($filtro == 'finalizados') active @endif" id="finalizado-tab"
                                        data-toggle="tab" href="#finalizados" role="tab" aria-controls="finalizados"
                                        aria-selected="@if ($filtro == 'finalizados') true @else false @endif">Finalizados</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if ($filtro == 'cancelados') active @endif" id="cancelados-tab"
                                        data-toggle="tab" href="#cancelados" role="tab" aria-controls="cancelados"
                                        aria-selected="@if ($filtro == 'cancelados') true @else false @endif">Cancelados</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content" id="statusTabsContent">
                        <div class="tab-pane fade show @if ($filtro == 'andamento') active @endif" id="andamento"
                            role="tabpanel" aria-labelledby="andamento-tab">
                            <div class="card" style="width: 100%;">
                                <div class="card-body">
                                    <form action="{{ route('solicitacao_servicos.gerarPedidosServicos') }}" method="post">
                                        @method('POST')
                                        @csrf
                                        <div class="table-responsive">
                                            <table class="table mytable" id="beneficiarios_table_andamento">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Selecionar</th>
                                                        <th scope="col">Beneficiário</th>
                                                        <th scope="col">Data Solicitação</th>
                                                        <th scope="col">Data Saída</th>
                                                        <th scope="col">Data Entrega</th>
                                                        <th scope="col">Ações</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($solicitacao_servicos as $item)
                                                        @if (
                                                            $item->status == \App\Models\SolicitacaoServico::STATUS_ENUM['solicitacao_em_aberto'] ||
                                                                $item->status == \App\Models\SolicitacaoServico::STATUS_ENUM['rota_de_entrega']
                                                        )
                                                            <tr>
                                                                <td>
                                                                    <input type="checkbox" name="selected_items[]"
                                                                        value="{{ $item->id }}">
                                                                </td>
                                                                <td>{{ $item->beneficiario->nome }}</td>
                                                                <td>{{ date('d/m/Y', strtotime($item->data_solicitacao)) }}
                                                                </td>
                                                                @if ($item->data_saida == null)
                                                                    <td> Aguardando </td>
                                                                @else
                                                                    <td>{{ date('d/m/Y', strtotime($item->data_saida)) }}
                                                                    </td>
                                                                @endif
                                                                @if ($item->data_entrega == null)
                                                                    <td> Aguardando </td>
                                                                @else
                                                                    <td>{{ date('d/m/Y', strtotime($item->data_entrega)) }}
                                                                    </td>
                                                                @endif
                                                                <td>
                                                                    <a
                                                                        href="{{ route('solicitacao_servicos.show', ['id' => $item->id]) }}">
                                                                        <img class="icon-licenciamento" width="20px;"
                                                                            src="{{ asset('img/Visualizar.svg') }}"
                                                                            alt="Visualizar Serviço"
                                                                            title="Visualizar Serviço">
                                                                    </a>
                                                                    <a
                                                                        href="{{ route('solicitacao_servicos.edit', ['id' => $item->id]) }}">
                                                                        <img class="icon-licenciamento" width="20px;"
                                                                            src="{{ asset('img/edit-svgrepo-com.svg') }}"
                                                                            alt="Editar Serviço" title="Editar Serviço">
                                                                    </a>
                                                                    <a title="Deletar Serviço" type="button"
                                                                        data-toggle="modal"
                                                                        data-target="#modalStaticDeletarServico_{{ $item->id }}">
                                                                        <img class="icon-licenciamento"
                                                                            src="{{ asset('img/trash-svgrepo-com.svg') }}"
                                                                            alt="Icone de deletar Serviço">
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <input type="hidden" name="motorista_id" id="motorista_id" value="">
                                        <button type="button" class="btn btn-success btn-color-dafault submeterFormBotao"
                                            style="background-color: #00883D; color: white;" data-toggle="modal"
                                            data-target="#modalStaticAtribuirMotorista_">Gerar nota</button>
                                        <div class="modal fade" id="modalStaticAtribuirMotorista_" data-backdrop="static"
                                            data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background-color: #00883D;">
                                                        <h5 class="modal-title" id="staticBackdropLabel"
                                                            style="color: white;">Selecione um Motorista</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                            <select name="motorista_id" class="form-control" required
                                                                onchange="updateMotoristaId(this)">
                                                                <option value="" disabled selected>Selecione um
                                                                    motorista</option>
                                                                @foreach ($motoristas as $motorista)
                                                                    <option value="{{ $motorista->id }}">
                                                                        {{ $motorista->nome_apelido }}</option>
                                                                @endforeach
                                                            </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-success" style="background-color: #00883D; color: white;">Gerar nota</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show @if ($filtro == 'finalizados') active @endif" id="finalizados"
                            role="tabpanel" aria-labelledby="finalizados-tab">
                            <div class="card" style="width: 100%;">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mytable" id="beneficiarios_table_finalizado">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Selecionar</th>
                                                    <th scope="col">Motorista</th>
                                                    <th scope="col">Beneficiário</th>
                                                    <th scope="col">Data Solicitação</th>
                                                    <th scope="col">Data Saída</th>
                                                    <th scope="col">Data Entrega</th>
                                                    <th scope="col">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($solicitacao_servicos as $item)
                                                    @if ($item->status == \App\Models\SolicitacaoServico::STATUS_ENUM['entregue'])
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" name="selected_items[]"
                                                                    value="{{ $item->id }}">
                                                            </td>
                                                            <td>{{ $item->motorista }}</td>
                                                            <td>{{ $item->beneficiario->nome }}</td>
                                                            <td>{{ date('d/m/Y', strtotime($item->data_solicitacao)) }}
                                                            </td>
                                                            @if ($item->data_saida == null)
                                                                <td> Aguardando </td>
                                                            @else
                                                                <td>{{ date('d/m/Y', strtotime($item->data_saida)) }}</td>
                                                            @endif
                                                            @if ($item->data_entrega == null)
                                                                <td> Aguardando </td>
                                                            @else
                                                                <td>{{ date('d/m/Y', strtotime($item->data_entrega)) }}
                                                                </td>
                                                            @endif
                                                            <td>
                                                                <a
                                                                    href="{{ route('solicitacao_servicos.show', ['id' => $item->id]) }}">
                                                                    <img class="icon-licenciamento" width="20px;"
                                                                        src="{{ asset('img/Visualizar.svg') }}"
                                                                        alt="Visualizar Serviço"
                                                                        title="Visualizar Serviço">
                                                                </a>
                                                                <a
                                                                    href="{{ route('solicitacao_servicos.edit', ['id' => $item->id]) }}">
                                                                    <img class="icon-licenciamento" width="20px;"
                                                                        src="{{ asset('img/edit-svgrepo-com.svg') }}"
                                                                        alt="Editar Serviço" title="Editar Serviço">
                                                                </a>
                                                                <a title="Deletar Serviço" type="button"
                                                                    data-toggle="modal"
                                                                    data-target="#modalStaticDeletarServico_{{ $item->id }}">
                                                                    <img class="icon-licenciamento"
                                                                        src="{{ asset('img/trash-svgrepo-com.svg') }}"
                                                                        alt="Icone de deletar Serviço">
                                                                </a>
                                                            </td>
                                                        <tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show @if ($filtro == 'cancelados') active @endif" id="cancelados"
                            role="tabpanel" aria-labelledby="cancelados-tab">
                            <div class="card" style="width: 100%;">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mytable" id="beneficiarios_table_cancelados">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Selecionar</th>
                                                    <th scope="col">Motorista</th>
                                                    <th scope="col">Beneficiário</th>
                                                    <th scope="col">Data Solicitação</th>
                                                    <th scope="col">Data Saída</th>
                                                    <th scope="col">Data Entrega</th>
                                                    <th scope="col">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($solicitacao_servicos as $item)
                                                    @if ($item->status == \App\Models\SolicitacaoServico::STATUS_ENUM['cancelada'])
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" name="selected_items[]"
                                                                    value="{{ $item->id }}">
                                                            </td>
                                                            <td>{{ $item->motorista }}</td>
                                                            <td>{{ $item->beneficiario->nome }}</td>
                                                            <td>{{ date('d/m/Y', strtotime($item->data_solicitacao)) }}
                                                            </td>
                                                            @if ($item->data_saida == null)
                                                                <td> Aguardando </td>
                                                            @else
                                                                <td>{{ date('d/m/Y', strtotime($item->data_saida)) }}</td>
                                                            @endif
                                                            @if ($item->data_entrega == null)
                                                                <td> Aguardando </td>
                                                            @else
                                                                <td>{{ date('d/m/Y', strtotime($item->data_entrega)) }}
                                                                </td>
                                                            @endif
                                                            <td>
                                                                <a
                                                                    href="{{ route('solicitacao_servicos.show', ['id' => $item->id]) }}">
                                                                    <img class="icon-licenciamento" width="20px;"
                                                                        src="{{ asset('img/Visualizar.svg') }}"
                                                                        alt="Visualizar Serviço"
                                                                        title="Visualizar Serviço">
                                                                </a>
                                                                <a
                                                                    href="{{ route('solicitacao_servicos.edit', ['id' => $item->id]) }}">
                                                                    <img class="icon-licenciamento" width="20px;"
                                                                        src="{{ asset('img/edit-svgrepo-com.svg') }}"
                                                                        alt="Editar Serviço" title="Editar Serviço">
                                                                </a>
                                                                <a title="Deletar Serviço" type="button"
                                                                    data-toggle="modal"
                                                                    data-target="#modalStaticDeletarServico_{{ $item->id }}">
                                                                    <img class="icon-licenciamento"
                                                                        src="{{ asset('img/trash-svgrepo-com.svg') }}"
                                                                        alt="Icone de deletar Serviço">
                                                                </a>
                                                            </td>
                                                        <tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="col-md-12 shadow-sm p-2 px-3"
                        style="background-color: #ffffff; border-radius: 0.5rem; margin-top: 5.2rem;">
                        <div style="font-size: 21px;" class="tituloModal">
                            Legenda
                        </div>
                        <div class="mt-2 borda-baixo"></div>
                        <ul class="list-group list-unstyled">
                            <li>
                                @can('isSecretarioOrBeneficiario', \App\Models\User::class)
                                    <div title="Visualizar Serviço" class="d-flex align-items-center my-1 pt-0 pb-1">
                                        <img class="icon-licenciamento align-middle" width="20"
                                            src="{{ asset('img/Visualizar.svg') }}" alt="Visualizar Serviço">
                                        <div style="font-size: 15px;" class="align-middle mx-3">
                                            Visualizar Serviço
                                        </div>
                                    </div>
                                    <div title="Editar Serviço"class="d-flex align-items-center my-1 pt-0 pb-1">
                                        <img class="icon-licenciamento align-middle" width="20"
                                            src="{{ asset('img/edit-svgrepo-com.svg') }}" alt="Editar Serviço">
                                        <div style="font-size: 15px;" class="align-middle mx-3">
                                            Editar Serviço
                                        </div>
                                    </div>
                                    <div title="Excluir Serviço" class="d-flex align-items-center my-1 pt-0 pb-1">
                                        <img class="icon-licenciamento align-middle" width="20"
                                            src="{{ asset('img/trash-svgrepo-com.svg') }}" alt="Excluir Serviço">
                                        <div style="font-size: 15px;" class="align-middle mx-3">
                                            Excluir Serviço
                                        </div>
                                    </div>
                                @endcan
                            </li>
                        </ul>
                    </div>
                </div>
                @foreach ($solicitacao_servicos as $item)
                    <div class="modal fade" id="modalStaticDeletarServico_{{ $item->id }}" data-backdrop="static"
                        data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #dc3545;">
                                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">
                                        Confirmação</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="deletar-servico-form-{{ $item->id }}" method="POST"
                                        action="{{ route('solicitacao_servicos.destroy', ['id' => $item->id]) }}">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        Tem certeza que deseja deletar o serviço do beneficiário
                                        {{ $item->beneficiario->nome }}?
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-danger submeterFormBotao"
                                        form="deletar-servico-form-{{ $item->id }}">Sim</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @push('scripts')
            <script>
                function updateMotoristaId(select) {
                    var motoristaId = select.value;
                    document.getElementById('motorista_id').value = motoristaId;
                }
            </script>
        @endpush
    @endsection
</x-app-layout>
