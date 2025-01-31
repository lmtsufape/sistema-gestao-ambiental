<x-app-layout>
    @section('content')
        <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
            <div class="form-row justify-content-between">
                <div class="col-md-9">
                    <div class="form-row d-flex justify-content-between align-items-center">
                        <div class="col-md-8">
                            <h4 class="card-title">Feirantes</h4>
                        </div>
                        <div class="col-xs-4">
                            <a title="Adicionar feirante" class="ml-2" href="{{ route('feirantes.create') }}">
                                <img class="icon-licenciamento" src="{{ asset('img/Grupo 1666.svg') }}" style="height: 35px" alt="Icone de adicionar documento">
                            </a>
                        </div>
                    </div>
                    @can('isAnalista', \App\Models\User::class)
                        <form action="{{ route('feirantes.index') }}" method="get">
                            @csrf
                            <div class="form-row mb-3">
                                <div class="col-md-7">
                                    <input type="text" class="form-control w-100" name="buscar" placeholder="Digite o nome ou CPF do feirante" value="{{ $buscar }}">
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
                                <div class="tab-pane fade show active" id="feirantes" role="tabpanel" aria-labelledby="feirantes-tab">
                                    @if ($feirante->isEmpty())
                                        <div class="alert alert-info" role="alert">
                                            Nenhum feirante correspondente cadastrado.
                                        </div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table mytable" id="feirantes_table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Nome</th>
                                                        <th scope="col">CPF</th>
                                                        <th scope="col">RG</th>
                                                        <th scope="col">Ações</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($feirante as $item)
                                                        <tr>
                                                            <td>{{ $item->nome }}</td>
                                                            <td>{{ $item->cpf ?? "Não Especificado" }}</td>
                                                            <td>{{ $item->rg ?? "Não Especificado" }} {{ $item->orgao_emissor }}</td>
                                                            <td>
                                                                <a href="{{ route('feirantes.show', ['id' => $item->id]) }}">
                                                                    <img class="icon-licenciamento" width="20px;" src="{{ asset('img/Visualizar.svg') }}" alt="Visualizar Feirante" title="Visualizar Feirante">
                                                                </a>
                                                                <a href="{{ route('feirantes.edit', ['id' => $item->id]) }}">
                                                                    <img class="icon-licenciamento" width="20px;" src="{{ asset('img/edit-svgrepo-com.svg') }}" alt="Editar Feirante" title="Editar Feirante">
                                                                </a>
                                                                <a title="Deletar Feirante" type="button" data-toggle="modal" data-target="#modalStaticDeletarFeirante_{{$item->id}}">
                                                                    <img class="icon-licenciamento" src="{{ asset('img/trash-svgrepo-com.svg') }}" alt="Icone de deletar Feirante">
                                                                </a>
                                                                <a href="{{ route('feirantes.comprovante_cadastro', ['id' => $item->id]) }}" target="_blank">
                                                                    <img class="icon-licenciamento" width="20px;" src="{{ asset('img/pdf-green.svg') }}" alt="Comprovante de Cadastro" title="Comprovante de Cadastro">
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
                                @can('isAnalista', \App\Models\User::class)
                                    <div title="Visualizar Feirante" class="d-flex align-items-center my-1 pt-0 pb-1">
                                        <img class="icon-licenciamento align-middle" width="20" src="{{ asset('img/Visualizar.svg') }}" alt="Visualizar Feirante">
                                        <div style="font-size: 15px;" class="align-middle mx-3">
                                            Visualizar Feirante
                                        </div>
                                    </div>
                                    <div title="Editar Beneficiario"class="d-flex align-items-center my-1 pt-0 pb-1">
                                        <img class="icon-licenciamento align-middle" width="20" src="{{ asset('img/edit-svgrepo-com.svg') }}" alt="Editar Feirante">
                                        <div style="font-size: 15px;" class="align-middle mx-3">
                                            Editar Feirante
                                        </div>
                                    </div>
                                    <div title="Excluir Feirante" class="d-flex align-items-center my-1 pt-0 pb-1">
                                        <img class="icon-licenciamento align-middle" width="20" src="{{ asset('img/trash-svgrepo-com.svg') }}" alt="Excluir Feirante">
                                        <div style="font-size: 15px;" class="align-middle mx-3">
                                            Excluir Feirante
                                        </div>
                                    </div>
                                    <div title="Comprovante de Cadastro" class="d-flex align-items-center my-1 pt-0 pb-1">
                                        <img class="icon-licenciamento align-middle" width="20" src="{{ asset('img/pdf-green.svg') }}" alt="Comprovante de Cadastro">
                                        <div style="font-size: 15px;" class="align-middle mx-3">
                                            Comprovante de Cadastro
                                        </div>
                                    </div>
                                @endcan
                            </li>
                        </ul>
                    </div>
                </div>
                @foreach ($feirante as $item)
                    <div class="modal fade" id="modalStaticDeletarFeirante_{{$item->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #dc3545;">
                                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Confirmação</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="deletar-feirante-form-{{$item->id}}" method="POST" action="{{route('feirantes.destroy', ['id' => $item->id])}}">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        Tem certeza que deseja deletar o feirante {{$item->nome}}?
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-danger submeterFormBotao" form="deletar-feirante-form-{{$item->id}}">Sim</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endsection
</x-app-layout>
