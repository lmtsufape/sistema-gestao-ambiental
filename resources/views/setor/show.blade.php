<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tipologia') }}
        </h2>
    </x-slot>

    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">Cnaes da tipologia {{$setor->nome}} cadastrados no sistema</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Cnaes</h6>
                            </div>
                            <div class="col-md-4" style="text-align: right">
                                <a class="btn btn-primary" href="{{route('cnaes.create', $setor->id)}}">Criar novo cnae</a>
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
                        <div div class="form-row">
                            <div class="col-sm-12">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Código</th>
                                        <th scope="col">Potencial Poluidor</th>
                                        <th scope="col">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cnaes as $cnae)
                                        <tr>
                                            <td> {{$cnae->nome}}</td>
                                            <td>{{$cnae->codigo}}</td>
                                            <td>
                                                @switch($cnae->potencial_poluidor)
                                                    @case(1)
                                                        Baixo
                                                        @break
                                                    @case(2)
                                                        Médio
                                                        @break
                                                    @case(3)
                                                        Alto
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <div class="dropdown">
                                                        <button class="btn btn-light dropdown-toggle shadow-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <img class="filter-green" src="{{asset('img/icon_acoes.svg')}}" style="width: 4px;">
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                            @if(Auth::user()->role == \App\Models\User::ROLE_ENUM['secretario'])
                                                                <a class="dropdown-item" href="{{route('cnaes.edit', ['cnae' => $cnae->id])}}">Editar Cnae</a>
                                                                <a class="dropdown-item" data-toggle="modal" data-target="#modalStaticDeletarCnae_{{$cnae->id}}" style="color: red; cursor: pointer;">Deletar cnae</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
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


    @foreach ($cnaes as $cnae)
        <!-- Modal deletar cnae -->
        <div class="modal fade" id="modalStaticDeletarCnae_{{$cnae->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #dc3545;">
                        <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Confirmação</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="deletar-cnae-form-{{$cnae->id}}" method="POST" action="{{route('cnaes.destroy', ['cnae' => $cnae])}}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            Tem certeza que deseja deletar o cnae {{$cnae->nome}} da tipologia {{$setor->nome}}?
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="submeterFormBotao" class="btn btn-danger" form="deletar-cnae-form-{{$cnae->id}}">Sim</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</x-app-layout>
