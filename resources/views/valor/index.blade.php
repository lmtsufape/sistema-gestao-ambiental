<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="col-md-8">
                        <h3 class="card-title">Valores das licenças</h3>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        <a title="Novo valor de licença" href="{{route('valores.create')}}">
                            <img class="icon-licenciamento " src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de adicionar licenciamento">
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
                                        <th scope="col">Porte</th>
                                        <th scope="col">Potencial poluidor</th>
                                        <th scope="col">Tipo de licença</th>
                                        <th scope="col">Valor</th>
                                        <th scope="col">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($valores as $i => $valor)
                                        <tr>
                                            <th scope="row">{{$i+1}}</th>
                                            <td>
                                                @switch($valor->porte)
                                                    @case($portes['micro'])
                                                        {{__('Micro')}}
                                                        @break
                                                    @case($portes['pequeno'])
                                                        {{__('Pequeno')}}
                                                        @break
                                                    @case($portes['medio'])
                                                        {{__('Médio')}}
                                                        @break
                                                    @case($portes['grande'])
                                                        {{__('Grande')}}
                                                        @break
                                                    @case($portes['especial'])
                                                        {{__('Especial')}}
                                                        @break
                                                @endswitch
                                            </td>
                                            <td style="text-align: center">
                                                @switch($valor->potencial_poluidor)
                                                    @case($potenciais_poluidores['baixo'])
                                                        {{__('Baixo')}}
                                                        @break
                                                    @case($potenciais_poluidores['medio'])
                                                        {{__('Médio')}}
                                                        @break
                                                    @case($potenciais_poluidores['alto'])
                                                        {{__('Alto')}}
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>
                                                @switch($valor->tipo_de_licenca)
                                                    @case($tipos_licenca['simplificada'])
                                                        {{__('Simplificada')}}
                                                        @break
                                                    @case($tipos_licenca['previa'])
                                                        {{__('Prévia')}}
                                                        @break
                                                    @case($tipos_licenca['instalacao'])
                                                        {{__('Instalação')}}
                                                        @break
                                                    @case($tipos_licenca['operacao'])
                                                        {{__('Operação')}}
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>{{'R$ ' . number_format($valor->valor, 2, ',', ' ')}}</td>
                                            <td>
                                                <a href="{{route('valores.edit', ['valore' => $valor->id])}}" title="Editar valor de licença"><img class="icon-licenciamento" src="{{asset('img/edit-svgrepo-com.svg')}}" alt="Editar valor de licença"></a>
                                                <button title="Deletar valor de licença"  type="button" data-toggle="modal" data-target="#deletar_valor_{{$valor->id}}"><img class="icon-licenciamento" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Deletar valor de licença"></button>
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
                        {{$valores->links()}}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="col-md-12 shadow-sm p-2 px-3" style="background-color: #ffffff; border-radius: 00.5rem; margin-top: 2.6rem;">
                    <div style="font-size: 21px;" class="tituloModal">
                        Legenda
                    </div>
                    <div class="mt-2 borda-baixo"></div>
                    <ul class="list-group list-unstyled">
                        <li>
                            <div title="Adicionar valor de licença" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" style="border-radius: 50%;" width="20" src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de adicionar valor de licença">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Adicionar valor de licença
                                </div>
                            </div>
                        </li>
                        <li>
                            <div title="Editar valor de licença" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/edit-svgrepo-com.svg')}}" alt="Editar valor de licença">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Editar valor de licença
                                </div>
                            </div>
                        </li>
                        <li>
                            <div title="Deletar valor de licença" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Deletar valor de licença">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Deletar valor de licença
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    @foreach ($valores as $valor)
    <!-- Modal deletar user -->
    <div class="modal fade" id="deletar_valor_{{$valor->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #dc3545;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Confirmação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="deletar-valor-form-{{$valor->id}}" method="POST" action="{{route('valores.destroy', ['valore' => $valor])}}">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        Tem certeza que deseja deletar valor?
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger submeterFormBotao" form="deletar-valor-form-{{$valor->id}}">Sim</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endsection
</x-app-layout>
