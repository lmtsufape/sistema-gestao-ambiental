<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Requerimentos') }}
        </h2>
    </x-slot>

    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">
                                    @can('isSecretario', \App\Models\User::class)
                                        {{__('Requerimentos')}}
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
                                            <td>
                                                @if($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['requerida'])
                                                    {{__('Requerida')}}
                                                @elseif($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['em_andamento'])
                                                    {{__('Em andamento')}}
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
                                                    {{$requerimento->valor}}
                                                @endif
                                            </td>
                                            <td>{{$requerimento->created_at->format('d/m/Y H:i')}}</td>
                                            <td>
                                                @can('isSecretario', \App\Models\User::class)
                                                <a type="button" class="btn btn-primary" href="{{route('requerimentos.show', ['requerimento' => $requerimento])}}">
                                                    Analisar
                                                </a>
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
                            @if ($primeiroRequerimento)
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