@component('mail::message')
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        Algumas informações da sua empresa {{$historico->empresa->nome}} foram alteradas por um protocolista.
        Segue a relação das modificações feitas abaixo.
    </p>
    @if ($historico->porte != null)
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                        {{__('Porte')}}
                </h5>
            </div>
            <div class="card-body">
                @component('mail::table')
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Porte modificado</th>
                                <th scope="col">Porte anterior</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @switch($historico->porte()->first()->porte_atual)
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
                                @switch($historico->porte()->first()->porte_antigo)
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
                @endcomponent
            </div>
        </div>
        <br>
    @endif
    @if($historico->cnaes()->first() != null)
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                        {{__('Cnaes foram modificados para os seguintes')}}
                </h5>
            </div>
            <div class="card-body">
                @component('mail::table')
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Cnae</th>
                                <th scope="col">Código</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($historico->cnaes as $cnae_modificado)
                                @if ($cnae_modificado->novo == true)
                                    <tr>
                                        <td>{{$cnae_modificado->cnae->nome}}</td>
                                        <td>{{$cnae_modificado->cnae->codigo}}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @endcomponent
            </div>
        </div>
        <br>
    @endif
    @if($historico->cnaes()->first() != null)
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                        {{__('Cnaes anteriores')}}
                </h5>
            </div>
            <div class="card-body">
                @component('mail::table')
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Cnae</th>
                                <th scope="col">Código</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($historico->cnaes as $cnae_modificado)
                                @if ($cnae_modificado->novo == false)
                                    <tr>
                                        <td>{{$cnae_modificado->cnae->nome}}</td>
                                        <td>{{$cnae_modificado->cnae->codigo}}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @endcomponent
            </div>
        </div>
        <br>
    @endif
    @lang('Regards'),<br>
    {{ config('app.name') }}<br>
    Laboratório Multidisciplinar de Tecnologias Sociais<br>
    Universidade Federal do Agreste de Pernambuco
@endcomponent
