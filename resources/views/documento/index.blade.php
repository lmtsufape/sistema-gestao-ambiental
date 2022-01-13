<x-app-layout>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Documentos cadastrados no sistema</h4>
                    </div>
                    <div class="col-md-4" style="text-align: right;">
                        <a title="Adicionar documento" href="{{route('documentos.create')}}">
                            <img class="icon-licenciamento add-card-btn" src="{{asset('img/Grupo 1666.svg')}}" alt="Icone de adicionar documento">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card card-borda-esquerda" style="width: 100%;">
                    <div class="card-body">
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
                                    <th scope="col">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col" style="width: 125px;">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documentos as $i => $documento)
                                    <tr>
                                        <td scope="row">{{$i+1}}</td>
                                        <td>{{$documento->nome}}</td>
                                        <td>
                                            @if ($documento->documento_modelo != null)
                                                <a title="Visualizar documento" target="_blank" href="{{route("documentos.show", $documento->id)}}"><img class="icon-licenciamento" src="{{asset('img/eye-svgrepo-com.svg')}}" alt="Icone de visualizar documento"></a>
                                            @endif
                                            <a title="Editar documento" href="{{route("documentos.edit", $documento->id)}}"><img class="icon-licenciamento" src="{{asset('img/edit-svgrepo-com.svg')}}" alt="Icone de editar documento"></a>
                                            <a title="Deletar documento" data-toggle="modal" data-target="#modalStaticDeletarDocumento_{{$documento->id}}" style="cursor: pointer;"><img class="icon-licenciamento" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Icone de deletar documento"></a>
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
                        <button type="submit" class="btn btn-danger submeterFormBotao" form="deleta-documento-form-{{$documento->id}}">Sim</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</x-app-layout>
