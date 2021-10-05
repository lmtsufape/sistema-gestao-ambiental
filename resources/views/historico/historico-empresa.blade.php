<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Histórico') }}
        </h2>
    </x-slot>

    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">Histórico de modificações da empresa {{$empresa->nome}}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Empresa > Histórico</h6>
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
                        <div div class="form-row">
                            @error('error')
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-danger" role="alert">
                                        <p>{{$message}}</p>
                                    </div>
                                </div>
                            @enderror
                        </div>

                        @foreach ($historico as $modificacao)
                            <div class="accordion" id="accordion{{$modificacao->id}}">
                                <div class="card">
                                    <div class="card-header" id="heading{{$modificacao->id}}">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse{{$modificacao->id}}" aria-expanded="false" aria-controls="collapse{{$modificacao->id}}">
                                                {{__('Modificação feita em ')}}{{ date('d/m/Y - h:i', strtotime($modificacao->created_at)) }}
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapse{{$modificacao->id}}" class="collapse" aria-labelledby="heading{{$modificacao->id}}" data-parent="#accordion{{$modificacao->id}}">
                                        <div class="card-body">
                                            <hr><div class="col-md-6">
                                                <h6 style="color: rgb(202, 28, 28)">Modificações feitas por {{$modificacao->user->name}}</h6>
                                            </div><hr>
                                            @if ($modificacao->porte != null)
                                                <hr><div class="col-md-6">
                                                    <h5>Porte</h5>
                                                </div><hr>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Porte modificado</th>
                                                            <th scope="col">Porte anterior</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            @switch($modificacao->porte()->first()->porte_atual)
                                                                @case(\App\Models\Empresa::PORTE_ENUM['micro'])
                                                                    <td>{{__('Micro')}}</td>
                                                                    @break
                                                                @case(\App\Models\Empresa::PORTE_ENUM['pequeno'])
                                                                    <td>{{__('Pequeno')}}</td>
                                                                    @break
                                                                @case(\App\Models\Empresa::PORTE_ENUM['medio'])
                                                                    <td>{{__('Médio')}}</td>
                                                                    @break
                                                                @case(\App\Models\Empresa::PORTE_ENUM['grande'])
                                                                    <td>{{__('Grande')}}</td>
                                                                    @break
                                                                @case(\App\Models\Empresa::PORTE_ENUM['especial'])
                                                                    <td>{{__('Especial')}}</td>
                                                                    @break
                                                            @endswitch
                                                            @switch($modificacao->porte()->first()->porte_antigo)
                                                                @case(\App\Models\Empresa::PORTE_ENUM['micro'])
                                                                    <td>{{__('Micro')}}</td>
                                                                    @break
                                                                @case(\App\Models\Empresa::PORTE_ENUM['pequeno'])
                                                                    <td>{{__('Pequeno')}}</td>
                                                                    @break
                                                                @case(\App\Models\Empresa::PORTE_ENUM['medio'])
                                                                    <td>{{__('Médio')}}</td>
                                                                    @break
                                                                @case(\App\Models\Empresa::PORTE_ENUM['grande'])
                                                                    <td>{{__('Grande')}}</td>
                                                                    @break
                                                                @case(\App\Models\Empresa::PORTE_ENUM['especial'])
                                                                    <td>{{__('Especial')}}</td>
                                                                    @break
                                                            @endswitch
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            @endif
                                            @if($modificacao->cnaes()->first() != null)
                                                <div class="col-md-6">
                                                    <h5>Cnaes modificados</h5>
                                                </div>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Cnae</th>
                                                            <th scope="col">Código</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($modificacao->cnaes as $cnae_modificado)
                                                            @if ($cnae_modificado->novo == true)
                                                                <tr>
                                                                    <td>{{$cnae_modificado->cnae->nome}}</td>
                                                                    <td>{{$cnae_modificado->cnae->codigo}}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                            @if($modificacao->cnaes()->first() != null)
                                                <div class="col-md-6">
                                                    <h5>Cnaes anteriores</h5>
                                                </div><hr>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Cnae</th>
                                                            <th scope="col">Código</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($modificacao->cnaes as $cnae_modificado)
                                                            @if ($cnae_modificado->novo == false)
                                                                <tr>
                                                                    <td>{{$cnae_modificado->cnae->nome}}</td>
                                                                    <td>{{$cnae_modificado->cnae->codigo}}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
