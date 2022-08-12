<x-app-layout>
    @section('content')
    <div class="container" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Histórico de modificações da empresa {{$empresa->nome}}</h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('empresas.listar')}}">Empresas</a> > <a class="text-muted" href="{{route('empresas.show', $empresa)}}">Dados da empresa {{$empresa->nome}}</a> > Histórico de modificações</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        {{-- <a title="Voltar"  href="javascript:window.history.back();">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-10">
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

                @forelse ($historico as $modificacao)
                    <div class="shadow card" data-toggle="collapse" data-target="#collapse_{{$modificacao->id}}" aria-expanded="true" aria-controls="collapse_{{$modificacao->id}}" style="cursor: pointer; width: 100%; margin-top: 1rem;">
                        <div class="card-body">
                            <div class="accordion" id="accordion{{$modificacao->id}}">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="col-md-11">
                                        <h5>
                                            <button type="button" class="titulo-nav-tab-custom btn-block text-left" data-toggle="collapse" data-target="#collapse_{{$modificacao->id}}" aria-expanded="true" aria-controls="collapse_{{$modificacao->id}}" >
                                                {{__('Modificação feita em ')}}{{ date('d/m/Y', strtotime($modificacao->created_at)) }} às {{ date('H:i', strtotime($modificacao->created_at)) }}
                                            </button>
                                        </h5>
                                    </div>
                                    <div class="col-md-1">
                                        <a><img src="{{asset('img/dropdown-svgrepo-com.svg')}}" alt="arquivo atual"  width="45" class="img-flex"></a>
                                    </div>
                                </div>
                                <div id="collapse_{{$modificacao->id}}" class="collapse" aria-labelledby="heading{{$modificacao->id}}" data-parent="#accordion{{$modificacao->id}}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12" style="text-align: right">
                                                <h6 style="color: rgb(202, 28, 28)">Modificações feitas por {{$modificacao->user->name}}</h6>
                                            </div>
                                        </div>
                                        @if ($modificacao->porte != null)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="mb-0">
                                                                    {{__('Porte')}}
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <table class="table-responsive">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Porte antigo</th>
                                                                        <th scope="col">Porte modificado para</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
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
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        @endif
                                        <div class="row">
                                            <div class="col-md-6">
                                                @if($modificacao->cnaes()->first() != null)
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="mb-0">
                                                                    {{__('Cnaes anteriores')}}
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <table class="table-responsive">
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
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                                <div class="col-md-6">
                                                    @if($modificacao->cnaes()->first() != null)
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="mb-0">
                                                                    {{__('Cnaes modificados para')}}
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <table class="table-responsive">
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
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="shadow card w-100 mt-3">
                        <div class="card-body">
                            <div class="text-center">
                                Não há histórico de modificações de CNAEs ou porte da empresa.
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
