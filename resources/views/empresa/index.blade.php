<x-app-layout>
    @section('content')
    <div class="container" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Suas empresas/serviços cadastradas(os)</h4>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        <a title="Adicionar empresa/serviço" href="{{route('empresas.create')}}">
                            <img class="icon-licenciamento " src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de adicionar empresa/serviço">
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
                                        <th scope="col">CPF/CNPJ</th>
                                        <th scope="col">Grupo</th>
                                        <th scope="col">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($empresas as $i => $empresa)
                                        <tr>
                                            <th scope="row">{{$i+1}}</th>
                                            <td>{{$empresa->nome}}</td>
                                            <td>{{$empresa->cpf_cnpj}}</td>
                                            <td>{{$empresa->cnaes()->first()->setor->nome}}</td>
                                            <td>
                                                <a title="Notificações" href="{{route('empresas.notificacoes.index', ['empresa' => $empresa])}}"><img class="icon-licenciamento" src="{{asset('img/notification-svgrepo-com.svg')}}" alt="Icone de notificações da empresa/serviço"></a>
                                                <a title="Editar empresa/serviço" href="{{route('empresas.edit', ['empresa' => $empresa])}}"><img class="icon-licenciamento" src="{{asset('img/edit-svgrepo-com.svg')}}" alt="Icone de editar empresa/serviço"></a>
                                                <a title="Deletar empresa/serviço" type="button" data-toggle="modal" data-target="#modalStaticDeletarEmpresa_{{$empresa->id}}"><img class="icon-licenciamento" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Icone de deletar empresa/serviço"></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                        </div>
                        @if($empresas->first() == null)
                            <div class="col-md-12 text-center" style="font-size: 18px;">
                                Nenhuma empresa cadastrada
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="col-md-12 shadow-sm p-2 px-3" style="background-color: #ffffff; border-radius: 00.5rem; margin-top: 2.6rem;">
                    <div style="font-size: 21px;" class="tituloModal">
                        Legenda
                    </div>
                    <div class="mt-2 borda-baixo"></div>
                    @if($empresas->first() != null)
                        <ul class="list-group list-unstyled">
                            <li>
                                <div title="Adicionar empresa/serviço" class="d-flex align-items-center my-1 pt-0 pb-1">
                                    <img class="icon-licenciamento aling-middle" style="border-radius: 50%;" width="20" src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de adicionar empresa/serviço">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Adicionar empresa/serviço
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div title="Notificações" class="d-flex align-items-center my-1 pt-0 pb-1">
                                    <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/notification-svgrepo-com.svg')}}" alt="Notificações">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Notificações
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div title="Editar empresa/serviço" class="d-flex align-items-center my-1 pt-0 pb-1">
                                    <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/edit-svgrepo-com.svg')}}" alt="Editar empresa/serviço">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Editar empresa/serviço
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div title="Deletar empresa/serviço" class="d-flex align-items-center my-1 pt-0 pb-1">
                                    <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Deletar empresa/serviço">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Deletar empresa/serviço
                                    </div>
                                </div>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @foreach ($empresas as $empresa)
    <!-- Modal deletar user -->
    <div class="modal fade" id="modalStaticDeletarEmpresa_{{$empresa->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #dc3545;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Confirmação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="deletar-empresa-form-{{$empresa->id}}" method="POST" action="{{route('empresas.destroy', ['empresa' => $empresa])}}">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        Tem certeza que deseja deletar a empresa {{$empresa->nome}}?
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger submeterFormBotao" form="deletar-empresa-form-{{$empresa->id}}">Sim</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endsection
</x-app-layout>
