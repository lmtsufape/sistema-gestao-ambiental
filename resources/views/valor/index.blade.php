<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Valores de licenças') }}
        </h2>
    </x-slot>

    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">Valores das licenças cadastradas</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Valores de licenças</h6>
                            </div>
                            <div class="col-md-4" style="text-align: right">
                                <a class="btn btn-primary" href="{{route('valores.create')}}">Criar novo valor</a>
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
                                            <td>
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
                                                        {{__('Prêvia')}}
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
                                                <a class="btn btn-info" href="{{route('valores.edit', ['valore' => $valor->id])}}">Editar</a>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deletar_valor_{{$valor->id}}">
                                                    Deletar
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
                    <button type="submit" id="submeterFormBotao" class="btn btn-danger" form="deletar-valor-form-{{$valor->id}}">Sim</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</x-app-layout>
