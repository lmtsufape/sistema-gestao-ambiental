<x-app-layout>
    @section('content')
        <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
            <div class="form-row justify-content-between">
                <div class="col-md-9">
                    <div class="form-row d-flex justify-content-between align-items-center">
                        <div class="col-md-8">
                            <h4 class="card-title">Beneficiários</h4>
                        </div>
                        <div class="col-xs-4">
                            <a title="Adicionar beneficiario" class="ml-2" href="{{ route('beneficiarios.create') }}">
                                <img class="icon-licenciamento" src="{{ asset('img/Grupo 1666.svg') }}" style="height: 35px" alt="Icone de adicionar documento">
                            </a>
                        </div>
                    </div>
                    @can('isSecretarioOrBeneficiario', \App\Models\User::class)
                        <form action="{{ route('beneficiarios.index') }}" method="get">
                            @csrf
                            <div class="form-row mb-3">
                                <div class="col-md-7">
                                    <input type="text" class="form-control w-100" name="buscar" placeholder="Digite o nome ou o código do Beneficiário" value="{{ $buscar }}">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn" style="background-color: #00883D; color: white;">Buscar</button>
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
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <div class="tab-content tab-content-custom" id="myTabContent">
                                <div class="tab-pane fade show active" id="beneficiarios" role="tabpanel" aria-labelledby="beneficiarios-tab">
                                    @if ($beneficiario->isEmpty())
                                        <div class="alert alert-info" role="alert">
                                            Nenhum beneficiário correspondente cadastrado.
                                        </div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table mytable" id="beneficiarios_table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Nome</th>
                                                        <th scope="col">Tipo</th>
                                                        <th scope="col">CPF</th>
                                                        <th scope="col">RG</th>
                                                        <th scope="col">Código</th>
                                                        <th scope="col">Ações</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($beneficiario as $item)
                                                        <tr>
                                                            <td>{{ $item->nome }}</td>
                                                            <td>@if($item->tipo_beneficiario == \App\Models\Beneficiario::ROLE_ENUM['aracao']) Aração @elseif ($item->tipo_beneficiario == \App\Models\Beneficiario::ROLE_ENUM['carro_pipa']) Carro-pipa @else Ambos @endif</td>
                                                            <td>{{ $item->cpf ?? "Não Especificado" }}</td>
                                                            <td>{{ $item->rg ?? "Não Especificado" }} {{ $item->orgao_emissor }}</td>
                                                            <td>{{ $item->codigo }}</td>
                                                            <td>
                                                                <a href="{{ route('beneficiarios.show', ['id' => $item->id]) }}">
                                                                    <img class="icon-licenciamento" width="20px;" src="{{ asset('img/Visualizar.svg') }}" alt="Visualizar Beneficiário" title="Visualizar Beneficiário">
                                                                </a>
                                                                <a href="{{ route('beneficiarios.edit', ['id' => $item->id]) }}">
                                                                    <img class="icon-licenciamento" width="20px;" src="{{ asset('img/edit-svgrepo-com.svg') }}" alt="Editar Beneficiário" title="Editar Beneficiário">
                                                                </a>
                                                                <a title="Deletar Beneficário" type="button" data-toggle="modal" data-target="#modalStaticDeletarBeneficiario_{{$item->id}}">
                                                                    <img class="icon-licenciamento" src="{{ asset('img/trash-svgrepo-com.svg') }}" alt="Icone de deletar Beneficiário">
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="col-md-12 shadow-sm p-2 px-3" style="background-color: #ffffff; border-radius: 0.5rem; margin-top: 5.2rem;">
                        <div style="font-size: 21px;" class="tituloModal">
                            Legenda
                        </div>
                        <div class="mt-2 borda-baixo"></div>
                        <ul class="list-group list-unstyled">
                            <li>
                                @can('isSecretarioOrBeneficiario', \App\Models\User::class)
                                    <div title="Visualizar Beneficiario" class="d-flex align-items-center my-1 pt-0 pb-1">
                                        <img class="icon-licenciamento align-middle" width="20" src="{{ asset('img/Visualizar.svg') }}" alt="Visualizar Beneficiario">
                                        <div style="font-size: 15px;" class="align-middle mx-3">
                                            Visualizar Beneficiário
                                        </div>
                                    </div>
                                    <div title="Editar Beneficiario"class="d-flex align-items-center my-1 pt-0 pb-1">
                                        <img class="icon-licenciamento align-middle" width="20" src="{{ asset('img/edit-svgrepo-com.svg') }}" alt="Editar Beneficiario">
                                        <div style="font-size: 15px;" class="align-middle mx-3">
                                            Editar Beneficiário
                                        </div>
                                    </div>
                                    <div title="Excluir Beneficiario" class="d-flex align-items-center my-1 pt-0 pb-1">
                                        <img class="icon-licenciamento align-middle" width="20" src="{{ asset('img/trash-svgrepo-com.svg') }}" alt="Excluir Beneficiario">
                                        <div style="font-size: 15px;" class="align-middle mx-3">
                                            Excluir Beneficiário
                                        </div>
                                    </div>
                                @endcan
                            </li>
                        </ul>
                    </div>
                </div>
                @foreach ($beneficiario as $item)
                    <div class="modal fade" id="modalStaticDeletarBeneficiario_{{$item->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #dc3545;">
                                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Confirmação</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="deletar-beneficiario-form-{{$item->id}}" method="POST" action="{{route('beneficiarios.destroy', ['id' => $item->id])}}">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        Tem certeza que deseja deletar o beneficiário {{$item->nome}}?
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-danger submeterFormBotao" form="deletar-beneficiario-form-{{$item->id}}">Sim</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endsection
</x-app-layout>
