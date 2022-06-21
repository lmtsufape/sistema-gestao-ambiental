<x-app-layout>
    @section('content')
        <div class="container-fluid" style="padding-top: 3rem;">
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
                                                <th scope="col">Protocolo</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Tipo</th>
                                                <th scope="col">Validade</th>
                                                <th scope="col">Opções</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @if(isset($licencas[0]))
                                                @foreach ($licencas as $i => $licenca)
                                                    <tr>
                                                        <th scope="row">{{($i+1)}}</th>
                                                        <td>
                                                            {{$licenca->protocolo}}
                                                        </td>
                                                        <td>
                                                            @if($licenca->status == \App\Models\Licenca::STATUS_ENUM['gerada'])
                                                                {{__('Gerada')}}
                                                            @elseif($licenca->status == \App\Models\Licenca::STATUS_ENUM['aprovada'])
                                                                {{__('Aprovada')}}
                                                            @elseif($licenca->status == \App\Models\Licenca::STATUS_ENUM['revisada'])
                                                                {{__('Revisada')}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($licenca->tipo == \App\Models\Licenca::TIPO_ENUM['previa'])
                                                                {{__('Previa')}}
                                                            @elseif($licenca->tipo == \App\Models\Licenca::TIPO_ENUM['instalacao'])
                                                                {{__('Instalação')}}
                                                            @elseif($licenca->tipo == \App\Models\Licenca::TIPO_ENUM['operacao'])
                                                                {{__('Operação')}}
                                                            @elseif($licenca->tipo == \App\Models\Licenca::TIPO_ENUM['simplificada'])
                                                                {{__('Simplificada')}}
                                                            @elseif($licenca->tipo == \App\Models\Licenca::TIPO_ENUM['autorizacao_ambiental'])
                                                                {{__('Autorização Ambiental')}}
                                                            @elseif($licenca->tipo == \App\Models\Licenca::TIPO_ENUM['regularizacao'])
                                                                {{__('Regularização')}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{$licenca->validade}}
                                                        </td>
                                                        <td>
                                                            <a title="Abrir Licença" href="{{route('licenca.show', ['licenca' => $licenca])}}"><img class="icon-licenciamento"
                                                                                                                                                    width="20px;"
                                                                                                                                                    src="{{asset('img/Visualizar.svg')}}"
                                                                                                                                                    alt="Analisar requerimentos"></a>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    @if($licencas[0] == null)
                                        <div class="col-md-12 text-center" style="font-size: 18px;">
                                            Nenhuma licença
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="col-md-12 shadow-sm p-2 px-3" style="background-color: #f8f9fa; border-radius: 00.5rem; margin-top: 2.6rem;">
                        <div style="font-size: 21px;" class="tituloModal">
                            Legenda
                        </div>
                        <ul class="list-group list-unstyled">
                            <li>
                                <div title="Analisar requerimento" class="d-flex align-items-center my-1 pt-0" style="border-bottom:solid 2px #e0e0e0;">
                                    <img class="aling-middle" width="20" src="{{asset('img/Visualizar.svg')}}" alt="Analisar requerimento">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Abrir Licença
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    @endsection
</x-app-layout>
