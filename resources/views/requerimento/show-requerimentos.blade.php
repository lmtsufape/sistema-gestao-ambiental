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
                                                        O protocolista definiu quais documentos devem ser enviados para a emissão da licença.
                                                    @elseif($requerimento->status > 3)
                                                        Documentos solicitados pelo protocolista foram enviados.
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
                                                        A visita à empresa/serviço foi concluída.
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
                                                        O relatório da visita está em analise pela secretaria.
                                                    @elseif($requerimento->status > 7)
                                                        O relatório da visita foi analisado pela secretaria.
                                                    @else
                                                        O relatório da visita será encaminhado à secretaria para analise.
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
            @foreach ($requerimento_documento as $pivot)
                @if ($pivot->requerimento_id == $requerimento->id)
                    @if ($pivot->status != \App\Models\RequerimentoDocumento::STATUS_ENUM['aceito'])
                        <div class="row justify-content-center align-items-center mt-6" style="text-align: center">
                            <div class="col-md-10">
                                <span style="color: #00883D; font-weight: bold;">Prazo para cumprimento das exigências:</span>
                                <span style="color: red; font-weight: bold;">
                                    @foreach ($requerimento_documento as $pivot)
                                        @if ($pivot->requerimento_id == $requerimento->id)
                                            @if($pivot->prazo_exigencia != null)
                                                <?php
                                                $dataObjeto = new DateTime($pivot->prazo_exigencia);
                                                $dataAtual = new DateTime();
                                                $diferenca = $dataObjeto->diff($dataAtual);
                                                $diasRestantes = $diferenca->days;
                                                ?>
                                                {{ date('d/m/Y', strtotime($pivot->prazo_exigencia)) }} (Restam {{ $diasRestantes }} dia(s))
                                                @break
                                            @endif
                                        @endif
                                    @endforeach
                                </span>
                            </div>
                        </div>
                        @break
                    @endif
                @endif
            @endforeach
            <div class="row mt-4">
                <div class="col-md-12" style="text-align: right">
                    <div class="btn-group align-items-center">
                        @foreach ($requerimento_documento as $pivot)
                            @if ($pivot->requerimento_id == $requerimento->id)
                                @if ($pivot->status != \App\Models\RequerimentoDocumento::STATUS_ENUM['aceito'])
                                    <a  href="{{route('requerimento.exigencias.documentacao', $requerimento->id)}}" style="cursor: pointer;margin-left: 9px;"><img class="icon-licenciamento" width="25px;" src="{{asset('img/alert-svgrepo-com.svg')}}" alt="Exigências de documentação" title="Exigências de documentação"></a>
                                @break
                                @endif
                            @endif
                        @endforeach
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