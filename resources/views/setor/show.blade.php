<x-app-layout>
    @section('content')
    <div class="container" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Cnaes do grupo {{$setor->nome}} cadastrados no sistema</h4>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <a class="text-muted" href="{{route('setores.index')}}">Grupos</a> > Cnaes do grupo {{$setor->nome}}</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        {{-- <a title="Voltar" href="{{route('setores.index')}}"><img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar"></a> --}}
                        <a title="Novo cnae" href="{{route('cnaes.create', $setor->id)}}"><img class="icon-licenciamento " src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de adicionar cnae"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
            </div>
            <div class="col-md-9">
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
                                        <th scope="col">Código</th>
                                        <th scope="col">Potencial Poluidor</th>
                                        <th scope="col">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cnaes as $i => $cnae)
                                        <tr>
                                            <td scope="row">{{$i+1}}</td>
                                            <td>{{$cnae->nome}}</td>
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
                                                    @case(4)
                                                        A definir
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>
                                                @if(Auth::user()->role == \App\Models\User::ROLE_ENUM['secretario'])
                                                    <a title="Editar cnae"  href="{{route('cnaes.edit', ['cnae' => $cnae->id])}}"><img class="icon-licenciamento" src="{{asset('img/edit-svgrepo-com.svg')}}" alt="Icone editar cnae"></a>
                                                    <a title="Deletar cnae"  data-toggle="modal" data-target="#modalStaticDeletarCnae_{{$cnae->id}}" style="cursor: pointer;"><img class="icon-licenciamento" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Icone deletar cnae"></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="col-md-12 shadow-sm p-2 px-3" style="background-color: #f8f9fa; border-radius: 00.5rem;">
                    <div style="font-size: 21px; text-align: right" class="tituloModal">
                        Legenda
                    </div>
                    <div class="mt-2 borda-baixo"></div>
                    <ul class="list-group list-unstyled">
                        <li>
                            <div title="Adicionar grupo" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" style="border-radius: 50%;" width="20" src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de adicionar CNAE">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Adicionar CNAE
                                </div>
                            </div>
                        </li>
                        <li>
                            <div title="Editar grupo" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/edit-svgrepo-com.svg')}}" alt="Editar CNAE">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Editar CNAE
                                </div>
                            </div>
                        </li>
                        <li>
                            <div title="Deletar grupo" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Deletar CNAE">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Deletar CNAE
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                {{$cnaes->links()}}
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
                            Tem certeza que deseja deletar o cnae {{$cnae->nome}} do grupo {{$setor->nome}}?
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger submeterFormBotao" form="deletar-cnae-form-{{$cnae->id}}">Sim</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @endsection
</x-app-layout>
