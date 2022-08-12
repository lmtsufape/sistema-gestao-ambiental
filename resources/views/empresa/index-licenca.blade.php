@guest
<x-guest-layout>
    <div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
        <div class="form-row justify-content-between">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="col-md-10">
                        <h4 class="card-title">
                            Licenças {{$empresa->nome}} ({{$empresa->cpf_cnpj}})
                        </h4>
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
                    @error('error')
                    <div class="col-md-12" style="margin-top: 5px;">
                        <div class="alert alert-danger" role="alert">
                            <p>{{$message}}</p>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="tab-content tab-content-custom" id="myTabContent">
                            <div class="tab-pane fade show active" id="requerimnetos-atuais" role="tabpanel" aria-labelledby="requerimnetos-atuais-tab">
                                <div class="table-responsive">
                                    <table class="table mytable">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Validade</th>
                                            <th scope="col">Opções</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($requerimentos as $i => $requerimento)
                                                <tr>
                                                    <th scope="row">{{($i+1)}}</th>
                                                    <td>
                                                        @if($requerimento->tipo == $tipos['primeira_licenca'])
                                                            {{__('Primeira Licença')}}
                                                        @elseif($requerimento->tipo == $tipos['renovacao'])
                                                            {{__('Renovação')}}
                                                        @elseif($requerimento->tipo == $tipos['autorizacao'])
                                                            {{__('Autorização')}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($requerimento->status <= 7)
                                                            {{__('Em processo')}}
                                                        @elseif($requerimento->status == 8)
                                                            {{__('Concluída')}}
                                                        @elseif($requerimento->status == 9)
                                                            {{__('Cancelada')}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($requerimento && $requerimento->licenca && $requerimento->licenca->status == 2 && $requerimento->licenca->validade)
                                                            {{Date('d/m/Y', strtotime($requerimento->licenca->validade))}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($requerimento->licenca && $requerimento->licenca->status == 2 && $requerimento->licenca->caminho)
                                                            <a title="Abrir Licença" href="{{route('licenca.show', ['licenca' => $requerimento->licenca])}}"><img class="icon-licenciamento"
                                                                                                                                                    width="20px;"
                                                                                                                                                    src="{{asset('img/Visualizar.svg')}}"
                                                                                                                                                    alt="Analisar requerimentos"></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <div class="col-md-12 text-center" style="font-size: 18px;">
                                                    Nenhuma licença
                                                </div>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
                            <div title="Analisar requerimento" class="d-flex align-items-center my-1 pt-0" style="border-bottom:solid 2px #e0e0e0;">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Visualizar.svg')}}" alt="Analisar requerimento">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Abrir Licença
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
@else
<x-app-layout>
    @section('content')
        <div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
            <div class="form-row justify-content-between">
                <div class="col-md-9">
                    <div class="form-row">
                        <div class="col-md-10">
                            <h4 class="card-title">
                                Licenças {{$empresa->nome}} ({{$empresa->cpf_cnpj}})
                            </h4>
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
                        @error('error')
                        <div class="col-md-12" style="margin-top: 5px;">
                            <div class="alert alert-danger" role="alert">
                                <p>{{$message}}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <div class="tab-content tab-content-custom" id="myTabContent">
                                <div class="tab-pane fade show active" id="requerimnetos-atuais" role="tabpanel" aria-labelledby="requerimnetos-atuais-tab">
                                    <div class="table-responsive">
                                        <table class="table mytable">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Tipo</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Validade</th>
                                                    <th scope="col">Opções</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($requerimentos as $i => $requerimento)
                                                        <tr>
                                                            <th scope="row">{{($i+1)}}</th>
                                                            <td>
                                                                @if($requerimento->tipo == $tipos['primeira_licenca'])
                                                                    {{__('Primeira Licença')}}
                                                                @elseif($requerimento->tipo == $tipos['renovacao'])
                                                                    {{__('Renovação')}}
                                                                @elseif($requerimento->tipo == $tipos['autorizacao'])
                                                                    {{__('Autorização')}}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($requerimento->status <= 7)
                                                                    {{__('Em processo')}}
                                                                @elseif($requerimento->status == 8)
                                                                    {{__('Concluída')}}
                                                                @elseif($requerimento->status == 9)
                                                                    {{__('Cancelada')}}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($requerimento && $requerimento->licenca && $requerimento->licenca->status == 2 && $requerimento->licenca->validade)
                                                                    {{Date('d/m/Y', strtotime($requerimento->licenca->validade))}}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($requerimento->licenca && $requerimento->licenca->status == 2 && $requerimento->licenca->caminho)
                                                                    <a title="Abrir Licença" href="{{route('licenca.show', ['licenca' => $requerimento->licenca])}}"><img class="icon-licenciamento"
                                                                                                                                                            width="20px;"
                                                                                                                                                            src="{{asset('img/Visualizar.svg')}}"
                                                                                                                                                            alt="Analisar requerimentos"></a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <div class="col-md-12 text-center" style="font-size: 18px;">
                                                            Nenhuma licença
                                                        </div>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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
                                <div title="Analisar requerimento" class="d-flex align-items-center my-1 pt-0" style="border-bottom:solid 2px #e0e0e0;">
                                    <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Visualizar.svg')}}" alt="Analisar requerimento">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Abrir Licença
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
@endguest
