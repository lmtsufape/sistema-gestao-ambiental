<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem;">
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
                                <img class="icon-licenciamento add-card-btn" src="{{asset('img/Grupo 1666.svg')}}" alt="Icone de adicionar novo requerimento">
                            </button>
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
                                                    <th scope="row">{{($i+1)}}</th>
                                                    <td>
                                                        <a href="{{route('historico.empresa', $requerimento->empresa->id)}}">
                                                            {{$requerimento->empresa->nome}}
                                                        </a>
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
                                                            R$ {{number_format($requerimento->valor, 2, ',', ' ')}}
                                                            @if ($requerimento->boletos->last() != null && $requerimento->boletos->last()->URL != null)
                                                                <a href="{{$requerimento->boletos->last()->URL}}" target="_blanck"><img src="{{asset('img/boleto.png')}}" alt="Baixar boleto de cobrança" width="40px;" style="display: inline;"></a>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>{{$requerimento->created_at->format('d/m/Y H:i')}}</td>
                                                    <td>
                                                        <a href="{{route('requerimentos.show', ['requerimento' => $requerimento])}}"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}"  alt="Analisar" title="Analisar"></a>
                                                        <a style="cursor: pointer;" data-toggle="modal" data-target="#cancelar_requerimento_{{$requerimento->id}}"><img class="icon-licenciamento" src="{{asset('img/trash-svgrepo-com.svg')}}"  alt="Cancelar" title="Cancelar"></a>
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
                                            <th scope="row">{{($i+1)}}</th>
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
                                    <div class="col-md-12" style="font-size: 20px; font-weight: bold;">
                                        {{$requerimento->empresa->nome}} -  {{ucfirst($requerimento->tipoString())}}
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 10px;">
                                    <div class="col-md-12" style="font-size: 16px; font-weight: bold; color: rgb(110, 110, 110)">
                                        {{ucfirst($requerimento->status())}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="font-size: 16px; padding-left: 27px;">
                                        {{"Algum texto aqui para explicar algo que não sei definir ainda"}}
                                    </div>
                                </div>
                                <div id="wrapper">
                                    <div class="row">
                                        <div id="background-circulos" class="col-md-12">
                                        </div>
                                    </div>
                                    <div id="content-circulos">
                                        <div class="row justify-content-center align-items-center mt-3 mb-3">
                                            <div class="@if($requerimento->status == 1)circulo-maior-selected @endif distancia-circulo">
                                                <div class="@if($requerimento->status == 1)circulo-selected @elseif($requerimento->status > 1)circulo-concluido 
                                                    @else circulo @endif">
                                                    <div class="@if($requerimento->status == 1)numero-selected @elseif($requerimento->status > 1)numero-concluido 
                                                        @else numero @endif">
                                                        1
                                                    </div>
                                                </div>
                                                <div class="popup-texto">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row col-md-12">
                                                                texto descritivo
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="@if($requerimento->status == 2)circulo-maior-selected @endif distancia-circulo">
                                                <div class="@if($requerimento->status == 2)circulo-selected @elseif($requerimento->status > 2)circulo-concluido 
                                                    @else circulo @endif">
                                                    <div class="@if($requerimento->status == 2)numero-selected @elseif($requerimento->status > 2)numero-concluido 
                                                        @else numero @endif">
                                                        2
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="@if($requerimento->status == 3)circulo-maior-selected @endif distancia-circulo">
                                                <div class="@if($requerimento->status == 3)circulo-selected @elseif($requerimento->status > 3)circulo-concluido 
                                                    @else circulo @endif">
                                                    <div class="@if($requerimento->status == 3)numero-selected @elseif($requerimento->status > 3)numero-concluido 
                                                        @else numero @endif">
                                                        3
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="@if($requerimento->status == 4)circulo-maior-selected @endif distancia-circulo">
                                                <div class="@if($requerimento->status == 4)circulo-selected @elseif($requerimento->status > 4)circulo-concluido 
                                                    @else circulo @endif">
                                                    <div class="@if($requerimento->status == 4)numero-selected @elseif($requerimento->status > 4)numero-concluido 
                                                        @else numero @endif">
                                                        4
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="@if($requerimento->status == 5)circulo-maior-selected @endif distancia-circulo">
                                                <div class="@if($requerimento->status == 5)circulo-selected @elseif($requerimento->status > 5)circulo-concluido 
                                                    @else circulo @endif">
                                                    <div class="@if($requerimento->status == 5)numero-selected @elseif($requerimento->status > 5)numero-concluido 
                                                        @else numero @endif">
                                                        5
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="@if($requerimento->status == 6)circulo-maior-selected @endif distancia-circulo">
                                                <div class="@if($requerimento->status == 6)circulo-selected @elseif($requerimento->status > 6)circulo-concluido 
                                                    @else circulo @endif">
                                                    <div class="@if($requerimento->status == 6)numero-selected @elseif($requerimento->status > 6)numero-concluido 
                                                        @else numero @endif">
                                                        6
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="@if($requerimento->status == 7)circulo-maior-selected @endif distancia-circulo">
                                                <div class="@if($requerimento->status == 7)circulo-selected @elseif($requerimento->status > 7)circulo-concluido 
                                                    @else circulo @endif">
                                                    <div class="@if($requerimento->status == 7)numero-selected @elseif($requerimento->status > 7)numero-concluido 
                                                        @else numero @endif">
                                                        7
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="distancia-circulo">
                                                <div class="@if($requerimento->status == 8)circulo-concluido 
                                                    @else circulo @endif">
                                                    <div class="@if($requerimento->status == 8)numero-concluido 
                                                        @else numero @endif">
                                                        8
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="border-bottom:solid 2px #e0e0e0;">
                                </div>
                                <div class="row justify-content-center align-items-center" style="text-align: center">
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
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        @if($requerimento->licenca != null && $requerimento->licenca->status == \App\Models\Licenca::STATUS_ENUM['aprovada'])
                                            <a class="btn btn-success btn-color-dafault" href="{{route('licenca.show', ['licenca' => $requerimento->licenca])}}">Visualizar licença</a>
                                        @endif
                                    </div>
                                    <div class="col-md-6" style="text-align: right">
                                        <div class="btn-group align-items-center">
                                            @if($requerimento->visitas->count() > 0)
                                                <a  href="{{route('requerimento.visitas', ['id' => $requerimento])}}" style="cursor: pointer; margin-left: 2px;"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}"  alt="Visitas a empresa" title="Visitas a empresa"></a>
                                            @endif
                                            @if ($requerimento->status != \App\Models\Requerimento::STATUS_ENUM['cancelada'])
                                                @if ($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['documentos_requeridos'])
                                                    <a title="Enviar documentação" href="{{route('requerimento.documentacao', $requerimento->id)}}"><img class="icon-licenciamento" src="{{asset('img/documents-red-svgrepo-com.svg')}}"  alt="Enviar documentos"></a>
                                                @elseif($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['documentos_enviados'])
                                                    <a title="Documentação em análise" href="{{route('requerimento.documentacao', $requerimento->id)}}"><img class="icon-licenciamento" src="{{asset('img/documents-yellow-svgrepo-com.svg')}}"  alt="Enviar documentos"></a>
                                                @elseif($requerimento->status >= \App\Models\Requerimento::STATUS_ENUM['documentos_aceitos'])
                                                    <a title="Documentação aceita" href="{{route('requerimento.documentacao', $requerimento->id)}}"><img class="icon-licenciamento" src="{{asset('img/documents-blue-svgrepo-com.svg')}}"  alt="Enviar documentos"></a>
                                                @endif
                                            @endif
                                            @if($requerimento->status != \App\Models\Requerimento::STATUS_ENUM['finalizada'])
                                                <a style="cursor: pointer;" data-toggle="modal" data-target="#cancelar_requerimento_{{$requerimento->id}}"><img class="icon-licenciamento" src="{{asset('img/trash-svgrepo-com.svg')}}"  alt="Cancelar" title="Cancelar"></a>
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
                    </div>
                    @endforelse
                @endcan
                @can('isSecretarioOrAnalista', \App\Models\User::class)
                    <div class="form-row justify-content-center">
                        <div class="col-md-10">
                            {{$requerimentos->links()}}
                        </div>
                    </div>
                @endcan
            </div>
            <div class="col-md-3">

                <div class="col-md-12 shadow-sm p-2 px-3" @can('isAnalista', \App\Models\User::class)
                                                                style="background-color: #f8f9fa; border-radius: 00.5rem; margin-top: 2.6rem;"
                                                            @elsecan('isRequerente', \App\Models\User::class)
                                                                style="background-color: #f8f9fa; border-radius: 00.5rem; margin-top: 2.6rem;"
                                                            @else
                                                                style="background-color: #f8f9fa; border-radius: 00.5rem; margin-top: 5.2rem;"
                                                            @endcan>
                    <div style="font-size: 21px;" class="tituloModal">
                        Legenda
                    </div>
                    <ul class="list-group list-unstyled">
                        @can('isSecretarioOrAnalista', \App\Models\User::class)
                            <li>
                                <div title="Analisar requerimento" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                    <img class="aling-middle" width="20" src="{{asset('img/Visualizar.svg')}}" alt="Analisar requerimento">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Analisar requerimento
                                    </div>
                                </div>
                            </li>
                        @endcan
                        @if(\App\Models\Visita::select('visitas.*')
                                    ->whereIn('requerimento_id', $requerimentos->pluck('id')->toArray())
                                    ->get()->count() > 0)
                            @can('isRequerente', \App\Models\User::class)
                                <li>
                                    <div title="Visitas a empresa" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                        <img class="aling-middle" width="20" src="{{asset('img/Visualizar.svg')}}" alt="Visitas a empresa">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Visitas à empresa
                                        </div>
                                    </div>
                                </li>
                            @endcan
                        @endif
                        @can('isRequerente', \App\Models\User::class)
                            <li>
                                <div title="Novo requerimento" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                    <img class="aling-middle" style="border-radius: 50%;" width="20" src="{{asset('img/Grupo 1666.svg')}}" alt="Icone de Novo requerimento">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Novo requerimento
                                    </div>
                                </div>
                            </li>
                            @if($requerimentos->where('status', \App\Models\Requerimento::STATUS_ENUM['documentos_requeridos'])->first() != null)
                                <li>
                                    <div title="Enviar documentação" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                        <img class="aling-middle" width="20" src="{{asset('img/documents-red-svgrepo-com.svg')}}" alt="Enviar documentação">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Enviar documentação
                                        </div>
                                    </div>
                                </li>
                            @endif
                            @if($requerimentos->where('status', \App\Models\Requerimento::STATUS_ENUM['documentos_enviados'])->first() != null)
                                <li>
                                    <div title="Documentação em análise" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                        <img class="aling-middle" width="20" src="{{asset('img/documents-yellow-svgrepo-com.svg')}}" alt="Documentação em análise">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Documentação em análise
                                        </div>
                                    </div>
                                </li>
                            @endif
                            @if($requerimentos->where('status', '>=', \App\Models\Requerimento::STATUS_ENUM['documentos_aceitos'])->first() != null)
                                <li>
                                    <div title="Documentação aceita" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                        <img class="aling-middle" width="20" src="{{asset('img/documents-blue-svgrepo-com.svg')}}" alt="Documentação aceita">
                                        <div style="font-size: 15px;" class="aling-middle mx-3">
                                            Documentação aceita
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endcan
                        @if($requerimentos->first() != null)
                            <li>
                                <div title="Cancelar requerimento" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                    <img class="aling-middle" width="20" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Cancelar requerimento">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Cancelar requerimento
                                    </div>
                                </div>
                            </li>
                        @endif
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
                                <option @if(old('empresa') == $empresa->id) selected @endif value="{{$empresa->id}}">{{$empresa->nome}}</option>
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
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" form="novo-requerimento-form">Salvar</button>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                <button type="submit" class="btn btn-danger submeterFormBotao" form="cancelar-requerimento-form-{{$requerimento->id}}">Cancelar requerimento</button>
                </div>
            </div>
            </div>
        </div>
    @endforeach
    @error('tipo')
    <script>
        $('#btn-novo-requerimento').click();
    </script>
    @enderror
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
@endsection
</x-app-layout>
