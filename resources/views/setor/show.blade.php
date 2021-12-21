<x-app-layout>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Cnaes da tipologia {{$setor->nome}} cadastrados no sistema</h4>
                        <h6 class="card-subtitle mb-2 text-muted">Tipologias > Cnaes da tipologia {{$setor->nome}}</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        <a title="Voltar" href="{{route('setores.index')}}"><img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar"></a>
                        <a title="Novo cnae" href="{{route('cnaes.create', $setor->id)}}"><img class="icon-licenciamento add-card-btn" src="{{asset('img/Grupo 1666.svg')}}" alt="Icone de adicionar cnae"></a>
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
                        <button type="submit" class="btn btn-danger submeterFormBotao" form="deletar-cnae-form-{{$cnae->id}}">Sim</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</x-app-layout>
