<x-app-layout>
    @section('content')
    <div class="container" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Usuários cadastrados no sistema</h4>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        <a title="Novo usuário" href="{{route('usuarios.create')}}">
                            <img class="icon-licenciamento " src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de adicionar usuário">
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
                            @endif
                        </div>
                        <div class="table-responsive">
                        <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nome</th>
                                        <th scope="col">E-mail</th>
                                        <th scope="col">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $i => $user)
                                        <tr>
                                            <th scope="row">{{$i+1}}</th>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>
                                                <a title="Editar usuário" href="{{route("usuarios.edit", $user->id)}}"><img class="icon-licenciamento" src="{{asset('img/edit-svgrepo-com.svg')}}" alt="Icone de editar usuario"></a>
                                                <button title="Deletar usuário" type="button" data-toggle="modal" data-target="#modalStaticDeletarUser_{{$user->id}}">
                                                    <img class="icon-licenciamento" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Deletar usuário">
                                                </button>
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
                        {{$users->links()}}
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
                            <div title="Adicionar usuário" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" style="border-radius: 50%;" width="20" src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de adicionar usuário">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Adicionar usuário
                                </div>
                            </div>
                        </li>
                        <li>
                            <div title="Editar usuário" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/edit-svgrepo-com.svg')}}" alt="Editar usuário">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Editar usuário
                                </div>
                            </div>
                        </li>
                        <li>
                            <div title="Deletar usuário" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Deletar usuário">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Deletar usuário
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    @foreach ($users as $user)
    <!-- Modal deletar user -->
    <div class="modal fade" id="modalStaticDeletarUser_{{$user->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #dc3545;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Confirmação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="deletar-user-form-{{$user->id}}" method="POST" action="{{route('usuarios.destroy', ['usuario' => $user])}}">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        Tem certeza que deseja deletar o analista {{$user->name}}?
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger submeterFormBotao" form="deletar-user-form-{{$user->id}}">Sim</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endsection
</x-app-layout>
