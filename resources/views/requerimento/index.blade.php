<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-between">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">
                            @can('isSecretario', \App\Models\User::class)
                                Requerimentos {{$filtro}}
                            @elsecan('isAnalista', \App\Models\User::class)
                                {{__('Requerimentos atribuídos a você')}}
                            @elsecan('isRequerente', \App\Models\User::class)
                                {{__('Requerimentos criados por você')}}
                            @endcan
                        </h4>
                    </div>
                    @can('isRequerente', \App\Models\User::class)
                        <div class="col-md-4" style="text-align: right;">
                            <button id="btn-novo-requerimento" title="Novo requerimento" data-toggle="modal" data-target="#novo_requerimento" style="cursor: pointer">
                                <img class="icon-licenciamento " src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de adicionar novo requerimento">
                            </button>
                            <a id="btn-etapas-requerimento" class="btn btn-success btn-color-dafault" title="Etapas do requerimento" data-toggle="modal" data-target="#etapas" style="cursor: pointer">
                                Etapas
                            </a>
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
                    @if(session('error'))
                        <div class="col-md-12" style="margin-top: 5px;">
                            <div class="alert alert-danger" role="alert">
                                <p>{{session('error')}}</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                @cannot('isRequerente', \App\Models\User::class)
                <form action="{{route('requerimentos.index', $filtro )}}" method="get">
                    @csrf
                    <div class="form-row mb-3">
                        <div class="col-md-7">
                            <input type="text" class="form-control w-100" name="buscar" placeholder="Digite o nome da Empresa" value="{{ $busca }}">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn" style="background-color: #00883D; color: white;">Buscar</button>
                        </div>
                    </div>
                </form>
                @endcannot

                @can('isSecretario', \App\Models\User::class)
                    <ul class="nav nav-tabs nav-tab-custom" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link @if($filtro == 'atuais') active @endif" id="requerimnetos-atuais-tab" role="tab" type="button"
                                 @if($filtro == 'atuais') aria-selected="true" @endif href="{{route('requerimentos.index', 'atuais')}}">Atuais</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if($filtro == 'finalizados') active @endif" id="requerimnetos-finalizados-tab" role="tab" type="button"
                                 @if($filtro == 'finalizados') aria-selected="true" @endif href="{{route('requerimentos.index', 'finalizados')}}">Finalizados</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if($filtro == 'cancelados') active @endif" id="equerimnetos-cancelados-tab" role="tab" type="button"
                                 @if($filtro == 'cancelados') aria-selected="true" @endif href="{{route('requerimentos.index', 'cancelados')}}">Cancelados</a>
                        </li>
                    </ul>
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <div class="tab-content tab-content-custom" id="myTabContent">
                                <div class="tab-pane fade show active" id="requerimnetos-atuais" role="tabpanel" aria-labelledby="requerimnetos-atuais-tab">
                                    <div class="table-responsive">
                                    <table class="table mytable" id="requerimento_table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Empresa/serviço</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Analista</th>
                                                <th scope="col">Protocolista</th>
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
                                                        {{$requerimento->empresa->nome}}
                                                    </td>
                                                    <td>
                                                        @if($requerimento->canceladoSecretario())
                                                            Cancelado pela secretaria.
                                                        @else
                                                            {{ucfirst($requerimento->status())}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($requerimento->analistaProcesso != null)
                                                            {{$requerimento->analistaProcesso->name}}
                                                        @else
                                                            s/ analista
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($requerimento->protocolista != null)
                                                            {{$requerimento->protocolista->name}}
                                                        @else
                                                            s/ protocolista
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ucfirst($requerimento->tipoString())}}
                                                    </td>
                                                    <td>
                                                        @if($requerimento->valor == null)
                                                            {{__('Em definição')}}
                                                        @else
                                                            R$ {{number_format($requerimento->valor, 2, ',', ' ')}}
                                                            @if ($requerimento->boletos->last() != null && $requerimento->boletos->last()->URL != null)
                                                                <a href="{{$requerimento->boletos->last()->URL}}" target="_blanck"><img src="{{asset('img/boleto.png')}}" alt="Baixar boleto de cobrança" width="40px;" style="display: inline;"></a>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>{{$requerimento->created_at->format('d/m/Y H:i')}}</td>
                                                    <td style="text-align: center">
                                                        <a href="{{route('requerimentos.show', ['requerimento' => $requerimento])}}"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}"  alt="Analisar" title="Analisar"></a>
                                                        @if($requerimento->licenca != null)
                                                            @if ($requerimento->licenca->status == \App\Models\Licenca::STATUS_ENUM['aprovada'])
                                                                <a href="{{route('licenca.show', ['licenca' => $requerimento->licenca])}}" style="cursor: pointer; margin-left: 2px;"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Relatório Aprovado.svg')}}" alt="Visualizar licença" title="Visualizar licença"></a>
                                                                @if($filtro == "finalizados")
                                                                    <a style="cursor: pointer; margin-left: 2px;" href="{{route('licenca.revisar', ['visita' => $requerimento->ultimaVisitaRelatorioAceito(), 'licenca' => $requerimento->licenca])}}"><img class="icon-licenciamento" src="{{asset('img/Relatório Sinalizado.svg')}}"  alt="Editar licença" title="Editar licença"></a>
                                                                @endif
                                                            @endif
                                                        @elseif($requerimento->ultimaVisitaRelatorioAceito() != null)
                                                            @if($filtro != "cancelados")
                                                                <a style="cursor: pointer;" href="{{route('licenca.create', $requerimento)}}"><img class="icon-licenciamento" src="{{asset('img/Grupo 1666.svg')}}"  alt="Criar licença" title="Criar licença"></a>
                                                            @endif
                                                        @endif
                                                        <a style="cursor: pointer;" data-toggle="modal" data-target="#cancelar_requerimento_{{$requerimento->id}}"><img class="icon-licenciamento" style="margin-left: 3px" src="{{asset('img/trash-svgrepo-com.svg')}}"  alt="Cancelar" title="Cancelar"></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                    @if($requerimentos->first() == null)
                                        <div class="col-md-12 text-center" style="font-size: 18px;">
                                            Nenhum requerimento @switch($filtro) @case('atuais') atual @break @case('finalizados') finalizado @break @case('cancelados') cancelado @break @endswitch
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @elsecan('isAnalista', \App\Models\User::class)
                    <div class="card card-borda-esquerda" style="width: 100%;">
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table mytable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Empresa/serviço</th>
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
                                            <th scope="row">{{ ($requerimentos->currentpage()-1) * $requerimentos->perpage() + $loop->index + 1 }}</th>
                                            <td>
                                                {{$requerimento->empresa->nome}}
                                            </td>
                                            <td>
                                                {{ucfirst($requerimento->status())}}
                                            </td>
                                            <td>
                                                {{ucfirst($requerimento->tipoString())}}
                                            </td>
                                            <td>
                                                @if($requerimento->valor == null)
                                                    {{__('Em definição')}}
                                                @else
                                                    @if($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['finalizada'])
                                                        Pago
                                                    @else
                                                        R$ {{number_format($requerimento->valor, 2, ',', ' ')}}
                                                        @if ($requerimento->boletos->last() != null && $requerimento->boletos->last()->URL != null)
                                                            <a href="{{$requerimento->boletos->last()->URL}}" target="_blanck"><img src="{{asset('img/boleto.png')}}" alt="Baixar boleto de cobrança" width="40px;" style="display: inline;"></a>
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{$requerimento->created_at->format('d/m/Y H:i')}}</td>
                                            <td>
                                                <div class="btn-group align-items-center">
                                                    <a title="Analisar requerimentos" href="{{route('requerimentos.show', ['requerimento' => $requerimento])}}"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}"  alt="Analisar requerimentos"></a>
                                                </div>
                                                @if($requerimento->licenca != null)
                                                    @if ($requerimento->licenca->status == \App\Models\Licenca::STATUS_ENUM['aprovada'])
                                                    <a href="{{route('licenca.show', ['licenca' => $requerimento->licenca])}}" style="cursor: pointer; margin-left: 2px;"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Relatório Aprovado.svg')}}" alt="Visualizar licença" title="Visualizar licença"></a>
                                                    @else
                                                        @can ('isAnalistaProcesso', \App\Models\User::class)
                                                            <a style="cursor: pointer;" href="{{route('licenca.revisar', ['licenca' => $requerimento->licenca, 'visita' => $requerimento->ultimaVisitaRelatorioAceito()])}}"><img class="icon-licenciamento" src="{{asset('img/Relatório Sinalizado.svg')}}"  alt="Revisar licença" title="Revisar licença"></a>
                                                        @endcan
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                            @if($requerimentos->first() == null)
                                <div class="col-md-12 text-center" style="font-size: 18px;">
                                    {{__('Nenhum requerimento foi atribuído a você')}}
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    @forelse ($requerimentos as $i => $requerimento)
                        <div class="card card-borda-esquerda @if($i>0)mt-3 @endif" style="width: 100%;">
                            <div class="card-body" style="padding-top: 10px;">
                                <div class="row">
                                    <div class="col-md-12" style="font-size: 20px; font-weight: bold; text-align: left">
                                        {{$requerimento->empresa->nome}} -  {{ucfirst($requerimento->tipoString())}}
                                        @if($requerimento->tipo_licenca)
                                            <span class="float-right px-2" style="font-size: 16px; background-color: var(--muted); color:white">{{$requerimento->tituloTipoDeLicenca()}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row" @if($requerimento->canceladoSecretario() || $requerimento->status == \App\Models\Requerimento::STATUS_ENUM['cancelada'])
                                    style="padding-left: 15px; padding-bottom: 10px;" @else style="padding-bottom: 10px;"
                                    @endif>
                                    <div class="col-md-12"
                                    @if($requerimento->canceladoSecretario() || $requerimento->status == \App\Models\Requerimento::STATUS_ENUM['cancelada'])
                                        style="font-size: 16px; font-weight: bold; background-color: #d85f6b; color: rgb(255, 255, 255); max-width: fit-content;"
                                    @else
                                        style="font-size: 16px; font-weight: bold; color: rgb(110, 110, 110)"
                                    @endif>
                                        @if($requerimento->canceladoSecretario())
                                            Cancelado
                                        @else
                                            {{ucfirst($requerimento->status())}}
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="font-size: 16px; padding-left: 27px;">
                                        @if($requerimento->canceladoSecretario())
                                            A secretaria cancelou ou indeferiu o seu requerimento. Veja o motivo clicando no ícone de "Cancelar requerimento".
                                        @else
                                            {{$requerimento->textoEtapa()}}.
                                        @endif
                                    </div>
                                </div>
                                @if($requerimento->status_empresa)
                                    <div class="row mt-2">
                                        <div class="col-md-12" style="font-size: 16px; padding-left: 27px;">
                                            <span style="color: #00883D; font-weight: bold;">Status da empresa/serviço:</span> {{lcfirst($requerimento->status_empresa)}}.
                                        </div>
                                    </div>
                                @endif
                                @if($requerimento->status != \App\Models\Requerimento::STATUS_ENUM['cancelada'])
                                    <div id="wrapper">
                                        <div class="row" style="@if($requerimento->canceladoSecretario()) opacity: 0.5 @endif">
                                            <div id="background-circulos" class="col-md-12">
                                            </div>
                                        </div>
                                        <div id="content-circulos">
                                            <div class="row justify-content-center align-items-center mt-3 mb-3">
                                                <div class="@if($requerimento->status == 1)circulo-maior-selected @endif distancia-circulo">
                                                    <div class="@if($requerimento->status == 1)circulo-selected @elseif($requerimento->status > 1)circulo-concluido
                                                        @else circulo @endif" style="@if($requerimento->canceladoSecretario()) opacity: 0.5 @endif">
                                                        <div class="@if($requerimento->status == 1)numero-selected @elseif($requerimento->status > 1)numero-concluido
                                                            @else numero @endif">
                                                            1
                                                        </div>
                                                    </div>
                                                    <div class="popup-texto">
                                                        <div class="card card-popup">
                                                            <div class="card-body">
                                                                <div class="etapa-titulo">
                                                                    <div class="row col-md-12 align-items-center">
                                                                        Etapa 1
                                                                        @if($requerimento->status == 1)
                                                                            <img class="icon-licenciamento" width="20px;" style="padding-left: 5px;" src="{{asset('img/atual.svg')}}"  alt="Icone de etapa atual" title="Etapa atual"/>
                                                                        @elseif($requerimento->status > 1)
                                                                            <img class="icon-licenciamento" width="20px;" src="{{asset('img/concluido.svg')}}"  alt="Icone de etapa concluída" title="Etapa concluída">
                                                                        @else
                                                                            <img class="icon-licenciamento" width="20px;" src="{{asset('img/pendente.svg')}}"  alt="Icone de etapa pendente" title="Etapa pendente">
                                                                        @endif

                                                                        @if($requerimento->status == 1)
                                                                            <span class="etapa-texto">
                                                                                (atual)
                                                                            </span>
                                                                        @elseif($requerimento->status > 1)
                                                                            <span class="etapa-texto">
                                                                                (concluída)
                                                                            </span>
                                                                        @else
                                                                            <span class="etapa-texto">
                                                                                (pendente)
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        @if($requerimento->status == 1)
                                                                            Seu requerimento será enviado para o banco de requerimentos da secretaria.
                                                                        @elseif($requerimento->status > 1)
                                                                            Seu requerimento foi recebido e encaminhado para um dos protocolistas.
                                                                        @else
                                                                            Seu requerimento foi recebido e será encaminhado para um dos protocolistas.
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="@if($requerimento->status == 2)circulo-maior-selected @endif distancia-circulo">
                                                    <div class="@if($requerimento->status == 2)circulo-selected @elseif($requerimento->status > 2)circulo-concluido
                                                        @else circulo @endif" style="@if($requerimento->canceladoSecretario()) opacity: 0.5 @endif">
                                                        <div class="@if($requerimento->status == 2)numero-selected @elseif($requerimento->status > 2)numero-concluido
                                                            @else numero @endif">
                                                            2
                                                        </div>
                                                    </div>
                                                    <div class="popup-texto">
                                                        <div class="card card-popup">
                                                            <div class="card-body">
                                                                <div class="etapa-titulo">
                                                                    <div class="row col-md-12 align-items-center">
                                                                        Etapa 2
                                                                        @if($requerimento->status == 2)
                                                                            <img class="icon-licenciamento" width="20px;" style="padding-left: 5px;" src="{{asset('img/atual.svg')}}"  alt="Icone de etapa atual" title="Etapa atual"/>
                                                                        @elseif($requerimento->status > 2)
                                                                            <img class="icon-licenciamento" width="20px;" src="{{asset('img/concluido.svg')}}"  alt="Icone de etapa concluída" title="Etapa concluída">
                                                                        @else
                                                                            <img class="icon-licenciamento" width="20px;" src="{{asset('img/pendente.svg')}}"  alt="Icone de etapa pendente" title="Etapa pendente">
                                                                        @endif

                                                                        @if($requerimento->status == 2)
                                                                            <span class="etapa-texto">
                                                                                (atual)
                                                                            </span>
                                                                        @elseif($requerimento->status > 2)
                                                                            <span class="etapa-texto">
                                                                                (concluída)
                                                                            </span>
                                                                        @else
                                                                            <span class="etapa-texto">
                                                                                (pendente)
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        @if($requerimento->status == 2)
                                                                            Seu requerimento está sendo analisado por um dos protocolistas.
                                                                        @elseif($requerimento->status > 2)
                                                                            Seu requerimento foi analisado por um dos protocolistas.
                                                                        @else
                                                                            Seu requerimento será analisado por um dos protocolistas.
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="@if($requerimento->status == 3)circulo-maior-selected @endif distancia-circulo">
                                                    <div class="@if($requerimento->status == 3)circulo-selected @elseif($requerimento->status > 3)circulo-concluido
                                                        @else circulo @endif" style="@if($requerimento->canceladoSecretario()) opacity: 0.5 @endif">
                                                        <div class="@if($requerimento->status == 3)numero-selected @elseif($requerimento->status > 3)numero-concluido
                                                            @else numero @endif">
                                                            3
                                                        </div>
                                                    </div>
                                                    <div class="popup-texto">
                                                        <div class="card card-popup">
                                                            <div class="card-body">
                                                                <div class="etapa-titulo">
                                                                    <div class="row col-md-12 align-items-center">
                                                                        Etapa 3
                                                                        @if($requerimento->status == 3)
                                                                            <img class="icon-licenciamento" width="20px;" style="padding-left: 5px;" src="{{asset('img/atual.svg')}}"  alt="Icone de etapa atual" title="Etapa atual"/>
                                                                        @elseif($requerimento->status > 3)
                                                                            <img class="icon-licenciamento" width="20px;" src="{{asset('img/concluido.svg')}}"  alt="Icone de etapa concluída" title="Etapa concluída">
                                                                        @else
                                                                            <img class="icon-licenciamento" width="20px;" src="{{asset('img/pendente.svg')}}"  alt="Icone de etapa pendente" title="Etapa pendente">
                                                                        @endif

                                                                        @if($requerimento->status == 3)
                                                                            <span class="etapa-texto">
                                                                                (atual)
                                                                            </span>
                                                                        @elseif($requerimento->status > 3)
                                                                            <span class="etapa-texto">
                                                                                (concluída)
                                                                            </span>
                                                                        @else
                                                                            <span class="etapa-texto">
                                                                                (pendente)
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        @if($requerimento->status == 3)
                                                                            Envie os documentos solicitados pelo protocolista.
                                                                        @elseif($requerimento->status > 3)
                                                                            O protocolista definiu quais documentos devem ser enviados para a emissão da licença.
                                                                        @else
                                                                            O protocolista definirá quais documentos devem ser enviados para a emissão da licença.
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="@if($requerimento->status == 4)circulo-maior-selected @endif distancia-circulo">
                                                    <div class="@if($requerimento->status == 4)circulo-selected @elseif($requerimento->status > 4)circulo-concluido
                                                        @else circulo @endif" style="@if($requerimento->canceladoSecretario()) opacity: 0.5 @endif">
                                                        <div class="@if($requerimento->status == 4)numero-selected @elseif($requerimento->status > 4)numero-concluido
                                                            @else numero @endif">
                                                            4
                                                        </div>
                                                    </div>
                                                    <div class="popup-texto">
                                                        <div class="card card-popup">
                                                            <div class="card-body">
                                                                <div class="etapa-titulo">
                                                                    <div class="row col-md-12 align-items-center">
                                                                        Etapa 4
                                                                        @if($requerimento->status == 4)
                                                                            <img class="icon-licenciamento" width="20px;" style="padding-left: 5px;" src="{{asset('img/atual.svg')}}"  alt="Icone de etapa atual" title="Etapa atual"/>
                                                                        @elseif($requerimento->status > 4)
                                                                            <img class="icon-licenciamento" width="20px;" src="{{asset('img/concluido.svg')}}"  alt="Icone de etapa concluída" title="Etapa concluída">
                                                                        @else
                                                                            <img class="icon-licenciamento" width="20px;" src="{{asset('img/pendente.svg')}}"  alt="Icone de etapa pendente" title="Etapa pendente">
                                                                        @endif

                                                                        @if($requerimento->status == 4)
                                                                            <span class="etapa-texto">
                                                                                (atual)
                                                                            </span>
                                                                        @elseif($requerimento->status > 4)
                                                                            <span class="etapa-texto">
                                                                                (concluída)
                                                                            </span>
                                                                        @else
                                                                            <span class="etapa-texto">
                                                                                (pendente)
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        @if($requerimento->status == 4)
                                                                            Seus documentos foram recebidos e serão analisados pelo protocolista.
                                                                        @elseif($requerimento->status > 4)
                                                                            Um protocolista fez a análise da documentação enviada.
                                                                        @else
                                                                            Um protocolista analisará a documentação enviada.
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="@if($requerimento->status == 5)circulo-maior-selected @endif distancia-circulo">
                                                    <div class="@if($requerimento->status == 5)circulo-selected @elseif($requerimento->status > 5)circulo-concluido
                                                        @else circulo @endif" style="@if($requerimento->canceladoSecretario()) opacity: 0.5 @endif">
                                                        <div class="@if($requerimento->status == 5)numero-selected @elseif($requerimento->status > 5)numero-concluido
                                                            @else numero @endif">
                                                            5
                                                        </div>
                                                    </div>
                                                    <div class="popup-texto">
                                                        <div class="card card-popup">
                                                            <div class="card-body">
                                                                <div class="etapa-titulo">
                                                                    <div class="row col-md-12 align-items-center">
                                                                        Etapa 5
                                                                        @if($requerimento->status == 5)
                                                                            <img class="icon-licenciamento" width="20px;" style="padding-left: 5px;" src="{{asset('img/atual.svg')}}"  alt="Icone de etapa atual" title="Etapa atual"/>
                                                                        @elseif($requerimento->status > 5)
                                                                            <img class="icon-licenciamento" width="20px;" src="{{asset('img/concluido.svg')}}"  alt="Icone de etapa concluída" title="Etapa concluída">
                                                                        @else
                                                                            <img class="icon-licenciamento" width="20px;" src="{{asset('img/pendente.svg')}}"  alt="Icone de etapa pendente" title="Etapa pendente">
                                                                        @endif

                                                                        @if($requerimento->status == 5)
                                                                            <span class="etapa-texto">
                                                                                (atual)
                                                                            </span>
                                                                        @elseif($requerimento->status > 5)
                                                                            <span class="etapa-texto">
                                                                                (concluída)
                                                                            </span>
                                                                        @else
                                                                            <span class="etapa-texto">
                                                                                (pendente)
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        @if($requerimento->status == 5)
                                                                            Seus documentos foram aprovados, aguarde o agendamento da visita à empresa/serviço.
                                                                        @elseif($requerimento->status > 5)
                                                                            O protocolista enviou o parecer da análise da documentação enviada.
                                                                        @else
                                                                            O protocolista enviará o parecer da análise da documentação.
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="@if($requerimento->status == 6)circulo-maior-selected @endif distancia-circulo">
                                                    <div class="@if($requerimento->status == 6)circulo-selected @elseif($requerimento->status > 6)circulo-concluido
                                                        @else circulo @endif" style="@if($requerimento->canceladoSecretario()) opacity: 0.5 @endif">
                                                        <div class="@if($requerimento->status == 6)numero-selected @elseif($requerimento->status > 6)numero-concluido
                                                            @else numero @endif">
                                                            6
                                                        </div>
                                                    </div>
                                                    <div class="popup-texto">
                                                        <div class="card card-popup">
                                                            <div class="card-body">
                                                                <div class="etapa-titulo">
                                                                    <div class="row col-md-12 align-items-center">
                                                                        Etapa 6
                                                                        @if($requerimento->status == 6)
                                                                            <img class="icon-licenciamento" width="20px;" style="padding-left: 5px;" src="{{asset('img/atual.svg')}}"  alt="Icone de etapa atual" title="Etapa atual"/>
                                                                        @elseif($requerimento->status > 6)
                                                                            <img class="icon-licenciamento" width="20px;" src="{{asset('img/concluido.svg')}}"  alt="Icone de etapa concluída" title="Etapa concluída">
                                                                        @else
                                                                            <img class="icon-licenciamento" width="20px;" src="{{asset('img/pendente.svg')}}"  alt="Icone de etapa pendente" title="Etapa pendente">
                                                                        @endif

                                                                        @if($requerimento->status == 6)
                                                                            <span class="etapa-texto">
                                                                                (atual)
                                                                            </span>
                                                                        @elseif($requerimento->status > 6)
                                                                            <span class="etapa-texto">
                                                                                (concluída)
                                                                            </span>
                                                                        @else
                                                                            <span class="etapa-texto">
                                                                                (pendente)
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        @if($requerimento->status == 6)
                                                                            A visita à empresa/serviço foi agendada, aguarde a equipe da secretaria até a data informada.
                                                                        @elseif($requerimento->status > 6)
                                                                            A visita à empresa/serviço foi agendada.
                                                                        @else
                                                                            A visita à empresa/serviço será agendada.
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="@if($requerimento->status == 7)circulo-maior-selected @endif distancia-circulo">
                                                    <div class="@if($requerimento->status == 7)circulo-selected @elseif($requerimento->status > 7)circulo-concluido
                                                        @else circulo @endif" style="@if($requerimento->canceladoSecretario()) opacity: 0.5 @endif">
                                                        <div class="@if($requerimento->status == 7)numero-selected @elseif($requerimento->status > 7)numero-concluido
                                                            @else numero @endif">
                                                            7
                                                        </div>
                                                    </div>
                                                    <div class="popup-texto">
                                                        <div class="card card-popup">
                                                            <div class="card-body">
                                                                <div class="etapa-titulo">
                                                                    <div class="row col-md-12 align-items-center">
                                                                        Etapa 7
                                                                        @if($requerimento->status == 7)
                                                                            <img class="icon-licenciamento" width="20px;" style="padding-left: 5px;" src="{{asset('img/atual.svg')}}"  alt="Icone de etapa atual" title="Etapa atual"/>
                                                                        @elseif($requerimento->status > 7)
                                                                            <img class="icon-licenciamento" width="20px;" src="{{asset('img/concluido.svg')}}"  alt="Icone de etapa concluída" title="Etapa concluída">
                                                                        @else
                                                                            <img class="icon-licenciamento" width="20px;" src="{{asset('img/pendente.svg')}}"  alt="Icone de etapa pendente" title="Etapa pendente">
                                                                        @endif

                                                                        @if($requerimento->status == 7)
                                                                            <span class="etapa-texto">
                                                                                (atual)
                                                                            </span>
                                                                        @elseif($requerimento->status > 7)
                                                                            <span class="etapa-texto">
                                                                                (concluída)
                                                                            </span>
                                                                        @else
                                                                            <span class="etapa-texto">
                                                                                (pendente)
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        @if($requerimento->status == 7)
                                                                            A visita à empresa/serviço foi realizada, aguarde a análise da secretaria para receber sua licença.
                                                                        @elseif($requerimento->status > 7)
                                                                            A visita à empresa/serviço foi realizada.
                                                                        @else
                                                                            A visita à empresa/serviço será realizada e a secretaria aprovará a emissão da licença.
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="distancia-circulo">
                                                    <div class="@if($requerimento->status == 8)circulo-concluido
                                                        @else circulo @endif" style="@if($requerimento->canceladoSecretario()) opacity: 0.5 @endif">
                                                        <div class="@if($requerimento->status == 8)numero-concluido
                                                            @else numero @endif">
                                                            8
                                                        </div>
                                                    </div>
                                                    <div class="popup-texto">
                                                        <div class="card card-popup">
                                                            <div class="card-body">
                                                                <div class="etapa-titulo">
                                                                    <div class="row col-md-12 align-items-center">
                                                                        Etapa 8
                                                                        @if($requerimento->status == 8)
                                                                            <img class="icon-licenciamento" width="20px;" src="{{asset('img/concluido.svg')}}"  alt="Icone de etapa concluída" title="Etapa concluída">
                                                                        @else
                                                                            <img class="icon-licenciamento" width="20px;" src="{{asset('img/pendente.svg')}}"  alt="Icone de etapa pendente" title="Etapa pendente">
                                                                        @endif

                                                                        @if($requerimento->status == 8)
                                                                            <span class="etapa-texto">
                                                                                (concluída)
                                                                            </span>
                                                                        @else
                                                                            <span class="etapa-texto">
                                                                                (pendente)
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        @if($requerimento->status == 8)
                                                                            Licença aprovada! Acesse o documento clicando no botão de "Visualizar licença".
                                                                        @else
                                                                            A secretaria enviará sua licença.
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                </div>
                                @endif
                                <div class="row justify-content-center align-items-center mt-4" style="text-align: center">
                                    <div class="col-md-6">
                                        <span style="color: #00883D; font-weight: bold;">Valor:</span>
                                        @if($requerimento->valor == null)
                                            {{__('Em definição')}}
                                        @else
                                            @if($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['finalizada'])
                                                Pago
                                            @else
                                                R$ {{number_format($requerimento->valor, 2, ',', ' ')}}
                                                @if ($requerimento->boletos->last() != null && $requerimento->boletos->last()->URL != null)
                                                    <a href="{{$requerimento->boletos->last()->URL}}" target="_blanck"><img src="{{asset('img/boleto.png')}}" alt="Baixar boleto de cobrança" width="40px;" style="display: inline;"></a>
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <span style="color: #00883D; font-weight: bold;">Data de criação:</span>
                                        {{$requerimento->created_at->format('d/m/Y')}} às <td>{{$requerimento->created_at->format('H:i')}}</td>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12" style="text-align: right">
                                        <div class="btn-group align-items-center">
                                            @if($requerimento->licenca != null && $requerimento->licenca->status == \App\Models\Licenca::STATUS_ENUM['aprovada'])
                                                <a href="{{route('licenca.show', ['licenca' => $requerimento->licenca])}}" class="" style="margin-left: 9px;cursor: pointer; margin-left: 2px;"><img class="icon-licenciamento" width="30px;" src="{{asset('img/Relatório Aprovado.svg')}}" alt="Visualizar licença" title="Visualizar licença"></a>
                                            @endif
                                            @if(!$requerimento->cancelado() && $requerimento->visitas->count() > 0)
                                                <a  href="{{route('requerimento.visitas', ['id' => $requerimento])}}" style="cursor: pointer;margin-left: 9px;"><img class="icon-licenciamento" width="25px;" src="{{asset('img/Visualizar.svg')}}"  alt="Visitas a empresa" title="Visitas a empresa"></a>
                                            @endif
                                            @if ($requerimento->status != \App\Models\Requerimento::STATUS_ENUM['cancelada'])
                                                @if ($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['documentos_requeridos'])
                                                    <a title="Enviar documentação" href="{{route('requerimento.documentacao', $requerimento->id)}}" style="margin-left: 9px"><img class="icon-licenciamento" style="width: 30px" src="{{asset('img/documents-red-svgrepo-com.svg')}}"  alt="Enviar documentos"></a>
                                                @elseif($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['documentos_enviados'])
                                                    <a title="Documentação em análise" href="{{route('requerimento.documentacao', $requerimento->id)}}" style="margin-left: 9px"><img class="icon-licenciamento" style="width: 30px" src="{{asset('img/documents-yellow-svgrepo-com.svg')}}"  alt="Enviar documentos"></a>
                                                @elseif($requerimento->status >= \App\Models\Requerimento::STATUS_ENUM['documentos_aceitos'])
                                                    <a title="Documentação aceita" href="{{route('requerimento.documentacao', $requerimento->id)}}" style="margin-left: 9px"><img class="icon-licenciamento" style="width: 30px" src="{{asset('img/documents-blue-svgrepo-com.svg')}}"  alt="Enviar documentos"></a>
                                                @endif
                                            @endif
                                            @if($requerimento->status != \App\Models\Requerimento::STATUS_ENUM['finalizada'] || $requerimento->canceladoSecretario())
                                                <a style="cursor: pointer; margin-left: 8px" data-toggle="modal" data-target="#cancelar_requerimento_{{$requerimento->id}}"><img class="icon-licenciamento" style="width: 30px" src="{{asset('img/trash-svgrepo-com.svg')}}"  alt="Cancelar" title="Cancelar"></a>
                                            @endif
                                            @if($requerimento->visitas->first() != null)
                                                <a class="btn btn-color-dafault rounded text-white" href="{{route('requerimentos.protocolo', $requerimento)}}" class="" style="margin-left: 9px;cursor: pointer; margin-left: 2px;">Protocolo</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card card-borda-esquerda" style="width: 100%;">
                            <div class="card-body">
                                <div class="col-md-12 text-center" style="font-size: 18px;">
                                    {{__('Nenhum requerimento foi criado por você')}}
                                </div>
                            </div>
                        </div>
                    @endforelse
                @endcan
                <div class="form-row justify-content-center">
                    <div class="col-md-10">
                        {{$requerimentos->links()}}
                    </div>
                </div>
                {{--<canvas id="myChart"></canvas>--}}
            </div>
            <div class="col-md-3">

                <div class="col-md-12 shadow-sm p-2 px-3" @can('isAnalista', \App\Models\User::class)
                                                                style="background-color: #ffffff; border-radius: 00.5rem; margin-top: 2.6rem;"
                                                            @elsecan('isRequerente', \App\Models\User::class)
                                                                style="background-color: #ffffff; border-radius: 00.5rem; margin-top: 2.6rem;"
                                                            @else
                                                                style="background-color: #ffffff; border-radius: 00.5rem; margin-top: 5.2rem;"
                                                            @endcan>
                    <div style="font-size: 21px;" class="tituloModal">
                        Legenda
                    </div>
                    <div class="mt-2 borda-baixo"></div>
                    <ul class="list-group list-unstyled">
                        @can('isSecretarioOrAnalista', \App\Models\User::class)
                            <li>
                                <div title="Analisar requerimento" class="d-flex align-items-center my-1 pt-0 pb-1">
                                    <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Visualizar.svg')}}" alt="Analisar requerimento">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Analisar requerimento
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div title="Visualizar licença" class="d-flex align-items-center my-1 pt-0 pb-1">
                                    <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Relatório Aprovado.svg')}}" alt="Visualizar licença">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Visualizar licença
                                    </div>
                                </div>
                            </li>
                        @endcan
                        @can('isSecretario', \App\Models\User::class)
                            <li>
                                <div title="Criar licença" class="d-flex align-items-center my-1 pt-0 pb-1">
                                    <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Grupo 1666.svg')}}" alt="Criar licença">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Criar licença
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div title="Editar licença" class="d-flex align-items-center my-1 pt-0 pb-1">
                                    <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Relatório Sinalizado.svg')}}" alt="Editar licença">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Editar licença
                                    </div>
                                </div>
                            </li>
                        @endcan
                        @can('isAnalistaProcesso', \App\Models\User::class)
                            <li>
                                <div title="Revisar licença" class="d-flex align-items-center my-1 pt-0 pb-1">
                                    <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Relatório Sinalizado.svg')}}" alt="Revisar licença">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Revisar licença
                                    </div>
                                </div>
                            </li>
                        @endcan
                        @if(\App\Models\Visita::select('visitas.*')
                                    ->whereIn('requerimento_id', $requerimentos->pluck('id')->toArray())
                                    ->get()->count() > 0)
                            @can('isRequerente', \App\Models\User::class)
                                <li>
                                    <div title="Visitas a empresa" class="d-flex align-items-center my-1 pt-0 pb-1">
                                        <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Visualizar.svg')}}" alt="Visitas a empresa">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Visitas à empresa
                                        </div>
                                    </div>
                                </li>
                            @endcan
                        @endif
                        @can('isRequerente', \App\Models\User::class)
                            <li>
                                <div title="Novo requerimento" class="d-flex align-items-center my-1 pt-0 pb-1">
                                    <img class="icon-licenciamento aling-middle" style="border-radius: 50%;" width="20" src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de Novo requerimento">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Novo requerimento
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div title="Enviar documentação" class="d-flex align-items-center my-1 pt-0 pb-1">
                                    <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/documents-red-svgrepo-com.svg')}}" alt="Enviar documentação">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Documentação pendente
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div title="Documentação em análise" class="d-flex align-items-center my-1 pt-0 pb-1">
                                    <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/documents-yellow-svgrepo-com.svg')}}" alt="Documentação em análise">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Documentação em análise
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div title="Documentação aceita" class="d-flex align-items-center my-1 pt-0 pb-1">
                                    <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/documents-blue-svgrepo-com.svg')}}" alt="Documentação aceita">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Documentação aceita
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div title="Visualizar licença" class="d-flex align-items-center my-1 pt-0 pb-1">
                                    <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Relatório Aprovado.svg')}}" alt="Visualizar licença">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Visualizar licença
                                    </div>
                                </div>
                            </li>
                        @endcan
                        @can('isRequerenteOrSecretario', \App\Models\User::class)
                            @if($requerimentos->first() != null)
                                <li>
                                    <div title="Cancelar requerimento" class="d-flex align-items-center my-1 pt-0 pb-1">
                                        <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Cancelar requerimento">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Cancelar requerimento
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endcan
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Criar requerimento --}}
    <div class="modal fade" id="novo_requerimento" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="background-color: var(--primaria);">
              <h5 class="modal-title text-white" id="staticBackdropLabel">Novo requerimento</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="novo-requerimento-form" method="POST" action="{{route('requerimentos.store')}}">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="alert alert-warning" role="alert">
                                <h5 class="alert-heading">Aviso!</h5>
                                <p class="mb-0">Poderão ser cobradas taxas adicionais para emitir a nova licença, caso a empresa/serviço tenha estado funcionando com uma licença inválida ou nenhuma.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="empresa">{{ __('Empresa') }}<span style="color: red; font-weight: bold;">*</span></label>
                        <select name="empresa" id="empresa" class="form-control @error('empresa') is-invalid @enderror" required onchange="tiposPossiveis(this)">
                            <option value="" selected disabled>{{__('-- Selecione a empresa --')}}</option>
                            @foreach (auth()->user()->empresas as $empresa)
                                @if($empresa->cnaes()->exists())
                                    <option @if(old('empresa') == $empresa->id) selected @endif value="{{$empresa->id}}">{{$empresa->nome}}</option>
                                @endif
                            @endforeach
                        </select>

                        @error('empresa')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-12 form-group">
                        @csrf
                        <label for="name">{{ __('Tipo de requerimento') }}<span style="color: red; font-weight: bold;">*</span></label>
                        <select name="tipo" id="tipo" class="form-control @error('tipo') is-invalid @enderror" required >
                            <option value="" selected disabled>{{__('-- Selecione o tipo de requerimento --')}}</option>
                            @if (old('tipo') != null)
                                @foreach ($tipos as $tipo)
                                    @switch($tipo)
                                        @case(\App\Models\Requerimento::TIPO_ENUM['primeira_licenca'])
                                            <option @if(old('tipo') == \App\Models\Requerimento::TIPO_ENUM['primeira_licenca']) selected @endif value="{{\App\Models\Requerimento::TIPO_ENUM['primeira_licenca']}}">{{__('Primeira licença')}}</option>
                                            @break
                                        @case(\App\Models\Requerimento::TIPO_ENUM['renovacao'])
                                            <option @if(old('tipo') == \App\Models\Requerimento::TIPO_ENUM['renovacao']) selected @endif value="{{\App\Models\Requerimento::TIPO_ENUM['renovacao']}}">{{__('Renovação')}}</option>
                                            @break
                                        @case(\App\Models\Requerimento::TIPO_ENUM['autorizacao'])
                                            <option @if(old('tipo') == \App\Models\Requerimento::TIPO_ENUM['autorizacao']) selected @endif value="{{\App\Models\Requerimento::TIPO_ENUM['autorizacao']}}">{{__('Autorização')}}</option>
                                            @break
                                    @endswitch
                                @endforeach
                            @endif
                        </select>

                        @error('tipo')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="status_empresa">{{ __('Status da empresa/serviço') }}<span style="color: red; font-weight: bold;">*</span></label>
                        <select name="status_empresa" id="status_empresa" class="form-control @error('status_empresa') is-invalid @enderror" required >
                            <option value="" selected disabled>{{__('-- Selecione o status da empresa/serviço --')}}</option>
                            <option @if(old('status_empresa') == "Em implantação") selected @endif value="Em implantação">{{__('Em implantação')}}</option>
                            <option @if(old('status_empresa') == "Em construção") selected @endif value="Em construção">{{__('Em construção')}}</option>
                            <option @if(old('status_empresa') == "Em funcionamento") selected @endif value="Em funcionamento">{{__('Em funcionamento')}}</option>
                        </select>

                        @error('status_empresa')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" form="novo-requerimento-form">Salvar</button>
            </div>
          </div>
        </div>
    </div>

    {{-- Etapas do requerimento --}}
    <div class="modal fade bd-example-modal-lg" id="etapas" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header" style="background-color: var(--primaria);">
              <h5 class="modal-title text-white" id="staticBackdropLabel">Etapas do requerimento</h5>
              <button type="button" class="close" style="opacity: 1; color: white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <div class="row">
                        <div class="col-md-12">
                            Todas as etapas do processo de emissão da licença seguem de forma sequencial. Para chegar na etapa 8, onde você receberá a sua licença, é necessário passar por todas as outras 7 etapas.
                        </div>
                    </div>
                </div>
                <div class="card card-popup mt-2">
                    <div class="card-body">
                        <div class="etapa-titulo">
                            <div class="row col-md-12 align-items-center">
                                Etapa 1
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                Após criar o seu requerimento de licença, ele será enviado para o banco de requerimentos da secretaria.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-popup mt-2">
                    <div class="card-body">
                        <div class="etapa-titulo">
                            <div class="row col-md-12 align-items-center">
                                Etapa 2
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                Seu requerimento será analisado por um dos protocolistas.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-popup mt-2">
                    <div class="card-body">
                        <div class="etapa-titulo">
                            <div class="row col-md-12 align-items-center">
                                Etapa 3
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                Envie os documentos solicitados pelo protocolista.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-popup mt-2">
                    <div class="card-body">
                        <div class="etapa-titulo">
                            <div class="row col-md-12 align-items-center">
                                Etapa 4
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                Seus documentos serão recebidos e serão analisados pelo protocolista.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-popup mt-2">
                    <div class="card-body">
                        <div class="etapa-titulo">
                            <div class="row col-md-12 align-items-center">
                                Etapa 5
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                Seus documentos serão aprovados, aguarde o agendamento da visita à empresa/serviço.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-popup mt-2">
                    <div class="card-body">
                        <div class="etapa-titulo">
                            <div class="row col-md-12 align-items-center">
                                Etapa 6
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                A visita à empresa/serviço será agendada, aguarde a equipe da secretaria até a data informada.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-popup mt-2">
                    <div class="card-body">
                        <div class="etapa-titulo">
                            <div class="row col-md-12 align-items-center">
                                Etapa 7
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                A visita à empresa/serviço será realizada, aguarde a análise da secretaria para receber sua licença.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-popup mt-2">
                    <div class="card-body">
                        <div class="etapa-titulo">
                            <div class="row col-md-12 align-items-center">
                                Etapa 8
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                Sua licença será disponibilizada.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>

    @foreach ($requerimentos as $requerimento)
        {{-- Cancelar requerimento --}}
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
                    @if($requerimento->canceladoSecretario() && auth()->user()->role != \App\Models\User::ROLE_ENUM['secretario'])
                        <div class="row">
                            <div class="col-md-12">
                                Seu requerimento foi cancelado ou indeferido!
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="comentario">Motivo:</label>
                                <textarea id="motivo_cancelamento" class="form-control"
                                    name="motivo_cancelamento" value="{{ old('motivo_cancelamento') }}"
                                    autocomplete="motivo_cancelamento" rows="3" disabled>{{$requerimento->motivo_cancelamento}}
                                </textarea>
                            </div>
                        </div>
                    @else
                        <form id="cancelar-requerimento-form-{{$requerimento->id}}" method="POST" action="{{route('requerimentos.destroy', ['requerimento' => $requerimento])}}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <div class="row">
                                <div class="col-md-12">
                                    @if($requerimento->cancelado())
                                        <label>Tem certeza que deseja desfazer o cancelamento deste requerimento?</label>
                                    @else
                                        <label>Tem certeza que deseja cancelar este requerimento?</label>
                                    @endif
                                </div>
                            </div>
                            @can('isSecretario', \App\Models\User::class)
                                <div class="row">
                                    <div class="col-md-12">
                                        @if($requerimento->cancelado() && $requerimento->canceladoSecretario() == false)
                                            <div class="alert alert-warning">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        Este requerimento foi cancelado pelo requerente.
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <label for="comentario">Motivo <span style="font-weight: normal; color: red">*</span></label>
                                            <textarea id="motivo_cancelamento" class="form-control @error('motivo_cancelamento') is-invalid @enderror"
                                                name="motivo_cancelamento" value="{{ old('motivo_cancelamento') }}"
                                                autocomplete="motivo_cancelamento" rows="3" required>{{old('motivo_cancelamento', $requerimento->motivo_cancelamento)}}</textarea>
                                            @error('motivo_cancelamento')
                                                <div id="validationServer03Feedback" class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        @endif
                                    </div>
                                </div>
                            @endcan
                        </form>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                    @if($requerimento->canceladoSecretario() && auth()->user()->role != \App\Models\User::ROLE_ENUM['secretario'])
                    @else
                        <button type="submit" class="btn btn-danger submeterFormBotao" form="cancelar-requerimento-form-{{$requerimento->id}}">
                            @if($requerimento->cancelado())
                                Desfazer cancelamento
                            @else
                                Cancelar requerimento
                            @endif
                        </button>
                    @endif
                </div>
            </div>
            </div>
        </div>
    @endforeach
    @error('tipo')
        @push ('scripts')
            <script>
                $('#btn-novo-requerimento').click();
            </script>
        @endpush
    @enderror
    @push ('scripts')
        <script>
            function tiposPossiveis(select) {
                $.ajax({
                    url:"{{route('status.requerimento')}}",
                    type:"get",
                    data: {"empresa_id": select.value},
                    dataType:'json',
                    success: function(data) {
                        $("#tipo").html("");
                        opt = `<option value="" selected disabled>{{__('-- Selecione o tipo de requerimento --')}}</option>`;
                        if (data.length > 0) {
                            for (var i = 0; i < data.length; i++) {
                                opt += `<option value="${data[i].enum_tipo}">${data[i].tipo}</option>`;
                            }
                        }

                        $("#tipo").append(opt);
                    }
                });
            }
        </script>
    @endpush
@endsection
</x-app-layout>
