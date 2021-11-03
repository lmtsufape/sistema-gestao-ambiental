<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Documentos') }}
        </h2>
    </x-slot>

    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">Documentos cadastrados no sistema</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Documentos</h6>
                            </div>
                            <div class="col-md-4" style="text-align: right">
                                <a class="btn btn-primary" href="{{route('documentos.create')}}">Criar Documento</a>
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
                                    <th scope="col">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documentos as $documento)
                                    <tr>
                                        <td>{{$documento->nome}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-light dropdown-toggle shadow-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <img class="filter-green" src="{{asset('img/icon_acoes.svg')}}" style="width: 4px;">
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                    @if ($documento->documento_modelo != null)
                                                        <a type="button" class="btn btn-primary dropdown-item" target="_blank" href="{{route("documentos.show", $documento->id)}}">
                                                            Visualizar
                                                        </a>
                                                    @endif
                                                    <a type="button" class="btn btn-primary dropdown-item" href="{{ route("documentos.edit", $documento->id) }}">
                                                        Editar
                                                    </a>
                                                    <button type="button" class="btn btn-danger dropdown-item" data-toggle="modal" data-target="#modalStaticDeletarDocumento_{{$documento->id}}">
                                                        Deletar
                                                    </button>
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

    @foreach ($documentos as $documento)
    <!-- Modal deletar user -->
        <div class="modal fade" id="modalStaticDeletarDocumento_{{$documento->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #dc3545;">
                        <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Confirmação</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="deleta-documento-form-{{$documento->id}}" method="POST" action="{{route('documentos.destroy', ['documento' => $documento])}}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            Tem certeza que deseja deletar o documento {{$documento->nome}}?
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="submeterFormBotao" class="btn btn-danger" form="deleta-documento-form-{{$documento->id}}">Sim</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</x-app-layout>
