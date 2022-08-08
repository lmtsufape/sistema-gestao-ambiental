<x-app-layout>
    @section('content')
    <div class="container" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Espécies de muda</h4>
                    </div>
                    <div class="col-md-4" style="text-align: right;">
                        <a title="Adicionar espécie" href="{{route('especies.create')}}">
                            <img class="icon-licenciamento " src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de adicionar especie">
                        </a>
                    </div>
                </div>
                <div class="card card-borda-esquerda" style="width: 100%;">
                    <div class="card-body">
                        <div div class="form-row">
                            @if(session('success'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-success" role="alert">
                                        <p>{{session('success')}}</p>
                                    </div>
                                </div>
                            @elseif(session('error'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-danger" role="alert">
                                        <p>{{session('error')}}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($especies as $i => $especie)
                                    <tr>
                                        <th scope="row">{{$i+1}}</th>
                                        <td>{{$especie->nome}}</td>
                                        <td>
                                            <a title="Editar espécie" href="{{route("especies.edit", $especie->id)}}"><img class="icon-licenciamento" src="{{asset('img/edit-svgrepo-com.svg')}}" alt="Icone de editar especie"></a>
                                            <a title="Deletar espécie" data-toggle="modal" data-target="#modalStaticDeletarEspecie_{{$especie->id}}" style="cursor: pointer;"><img class="icon-licenciamento" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Icone de deletar especie"></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <div class="form-row justify-content-center">
                    <div class="col-md-10">
                        {{$especies->links()}}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="col-md-12 shadow-sm p-2 px-3" style="background-color: #ffffff; border-radius: 00.5rem; margin-top: 2.6rem; text-align: right">
                    <div style="font-size: 21px;" class="tituloModal">
                        Legenda
                    </div>
                    <ul class="list-group list-unstyled">
                        <li>
                            <div title="Adicionar espécie" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" style="border-radius: 50%;" width="20" src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de adicionar espécie">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Adicionar espécie
                                </div>
                            </div>
                        </li>
                        <li>
                            <div title="Editar espécie" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/edit-svgrepo-com.svg')}}" alt="Editar espécie">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Editar espécie
                                </div>
                            </div>
                        </li>
                        <li>
                            <div title="Deletar espécie" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Deletar espécie">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Deletar espécie
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @foreach ($especies as $especie)
    <!-- Modal deletar especie -->
        <div class="modal fade" id="modalStaticDeletarEspecie_{{$especie->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #dc3545;">
                        <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Confirmação</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="deleta-especie-form-{{$especie->id}}" method="POST" action="{{route('especies.destroy', $especie)}}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            Tem certeza que deseja deletar a espécie {{$especie->nome}}?
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger submeterFormBotao" form="deleta-especie-form-{{$especie->id}}">Sim</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @endsection
</x-app-layout>
