<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Requerimentos') }}
        </h2>
    </x-slot>

    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">
                                    @can('isSecretario', \App\Models\User::class)
                                        {{__('Requerimentos')}}
                                    @elsecan('isAnalista', \App\Models\User::class)
                                        {{__('Requerimentos atribuidos a você')}}
                                    @elsecan('isRequerente', \App\Models\User::class)
                                        {{__('Requerimentos criados por você')}}
                                    @endcan
                                </h5>
                                <h6 class="card-subtitle mb-2 text-muted">Requerimentos</h6>
                            </div>
                            @can('isRequerente', \App\Models\User::class)
                                <div class="col-md-4" style="text-align: right">
                                    <a class="btn btn-primary" data-toggle="modal" data-target="#novo_requerimento">Novo requerimento</a>
                                </div>
                            @endcan
                        </div>
                        <div div class="form-row">
                            @if(session('success'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-success" role="alert">
                                        <p>{{session('success')}}</p>
                                    </div>
                                </div>
                            @endif
                            @error('error')
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-danger" role="alert">
                                        <p>{{$message}}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Empresa</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Valor</th>
                                        <th scope="col">Data</th>
                                        <th scope="col">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requerimentos as $i => $requerimento)
                                        <tr>
                                            <th scope="row">{{($i+1)}}</th>
                                            <td>{{$requerimento->empresa->nome}}</td>
                                            <td>
                                                @if($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['requerida'])
                                                    {{__('Requerida')}}
                                                @elseif($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['em_andamento'])
                                                    {{__('Em andamento')}}
                                                @elseif($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['documentos_requeridos'])
                                                    {{__('Documentos requeridos')}}
                                                @elseif($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['documentos_enviados'])
                                                    {{__('Documentos enviados')}}
                                                @elseif($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['documentos_aceitos'])
                                                    {{__('Documentos aceitos')}}
                                                @elseif($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['visita_marcada'])
                                                    {{__('Visita marcada para ')}}{{date('d/m/Y', strtotime($requerimento->ultimaVisitaMarcada()->data_marcada))}}
                                                @elseif($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['visita_realizada'])
                                                    {{__('Visita feita em ')}}{{date('d/m/Y', strtotime($requerimento->ultimaVisitaMarcada()->data_realizada))}}
                                                @elseif($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['finalizada'])
                                                    {{__('Finalizada')}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['primeira_licenca'])
                                                    {{__('Primeira licença')}}
                                                @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['renovacao'])
                                                    {{__('Renovação')}}
                                                @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['autorizacao'])
                                                    {{__('Autorização')}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($requerimento->valor == null)
                                                    {{__('Em definição')}}
                                                @else
                                                    R$ {{number_format($requerimento->valor, 2, ',', ' ')}} <a href="{{route('boleto.create', ['requerimento' => $requerimento])}}" target="_blanck"><img src="{{asset('img/boleto.png')}}" alt="Baixar boleto de cobrança" width="40px;" style="display: inline;"></a>
                                                @endif
                                            </td>
                                            <td>{{$requerimento->created_at->format('d/m/Y H:i')}}</td>
                                            <td>
                                                @can('isSecretarioOrAnalista', \App\Models\User::class)
                                                    <a type="button" class="btn btn-primary" href="{{route('requerimentos.show', ['requerimento' => $requerimento])}}">
                                                        Analisar
                                                    </a>
                                                @endcan
                                                @if($requerimento->visitas->count() > 0)
                                                    @can('isSecretario', \App\Models\User::class)
                                                        <a type="button" class="btn btn-primary" href="{{route('requerimento.visitas', ['id' => $requerimento])}}">
                                                            Visitas
                                                        </a>
                                                    @else
                                                        @can('isRequerente', \App\Models\User::class)
                                                            <a type="button" class="btn btn-primary" href="{{route('requerimento.visitas', ['id' => $requerimento])}}">
                                                                Visitas
                                                            </a>
                                                        @endcan
                                                    @endcan
                                                @endif
                                                @can('isRequerente', \App\Models\User::class)
                                                    @if ($requerimento->status != \App\Models\Requerimento::STATUS_ENUM['cancelada'])
                                                        @if ($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['documentos_requeridos'])
                                                            <a type="button" class="btn btn-primary" href="{{route('requerimento.documentacao', $requerimento->id)}}">
                                                                Enviar documentação
                                                            </a>
                                                        @elseif($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['documentos_enviados'])
                                                            <a type="button" class="btn btn-primary" href="{{route('requerimento.documentacao', $requerimento->id)}}">
                                                                Documentação em análise
                                                            </a>
                                                        @elseif($requerimento->status >= \App\Models\Requerimento::STATUS_ENUM['documentos_aceitos'])
                                                            <a type="button" class="btn btn-primary" href="{{route('requerimento.documentacao', $requerimento->id)}}">
                                                                Documentação aceita
                                                            </a>
                                                        @endif
                                                    @endif
                                                @endcan
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancelar_requerimento_{{$requerimento->id}}">
                                                    Cancelar
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

    {{-- Criar requerimento --}}
    <div class="modal fade" id="novo_requerimento" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Novo requerimento</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="novo-requerimento-form" method="POST" action="{{route('requerimentos.store')}}">
                    <div class="col-md-12 form-group">
                        @csrf
                        <label for="name">{{ __('Tipo de requerimento') }}</label>
                        <select name="tipo" id="tipo" class="form-control @error('tipo') is-invalid @enderror" required>
                            <option value="" selected disabled>{{__('-- Selecione o tipo de requerimento --')}}</option>
                            @if (isset($primeiroRequerimento) && $primeiroRequerimento)
                                <option value="1">{{__('Primeira licença')}}</option>
                            @else
                                <option value="2">{{__('Renovação')}}</option>
                                <option value="3">{{__('Autorização')}}</option>
                            @endif
                        </select>

                        @error('tipo')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary" form="novo-requerimento-form">Salvar</button>
            </div>
          </div>
        </div>
    </div>

    @foreach ($requerimentos as $requerimento)
        {{-- Criar requerimento --}}
        <div class="modal fade" id="cancelar_requerimento_{{$requerimento->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #dc3545;">
                <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Cancelar requerimento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form id="cancelar-requerimento-form-{{$requerimento->id}}" method="POST" action="{{route('requerimentos.destroy', ['requerimento' => $requerimento])}}">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        Tem certeza que deseja cancelar esse requerimento?
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger" form="cancelar-requerimento-form-{{$requerimento->id}}">Salvar</button>
                </div>
            </div>
            </div>
        </div>
    @endforeach
    @error('error_modal')
    <script>
        $('#novo_requerimento').modal('show');
    </script>
    @enderror
</x-app-layout>
