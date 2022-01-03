<x-app-layout>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Usuários cadastrados no sistema</h4>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        <a title="Novo usuário" href="{{route('usuarios.create')}}">
                            <img class="icon-licenciamento add-card-btn" src="{{asset('img/Grupo 1666.svg')}}" alt="Icone de adicionar usuário">
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
</x-app-layout>
