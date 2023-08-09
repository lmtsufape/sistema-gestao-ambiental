<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 2rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-sm-12">
                <div class="form-row">
                    <div class="col-md-8" style="padding-top: 15px;">
                        <h4 class="card-title">Visualizar requerimento nº {{$requerimento->id}}</h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('requerimentos.index', 'atuais')}}">Requerimentos</a> > Visualizar requerimento nº {{$requerimento->id}}</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        {{-- <a class="btn my-2"  @if ($visita ?? '') href="{{route('visitas.index')}}" @else   href="javascript:window.history.back();" @endif style="cursor: pointer;"><img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}"  alt="Voltar" title="Voltar"></a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{session('success')}}
                    </div>
                @endif
                @error('error')
                    <div class="alert alert-danger" role="alert">
                        {{$message}}
                    </div>
                @endif
                <div class="shadow card" style="width: 100%;">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-md-10">
                                <h5 class="titulo-nav-tab-custom" style="font-size: 24px; color: var(--primaria);">Requerimento de
                                    @if($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['primeira_licenca'])
                                        {{__('primeira licença')}}
                                    @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['renovacao'])
                                        {{__('renovação')}}
                                    @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['autorizacao'])
                                        {{__('autorização')}}
                                    @endif
                                    @if ($requerimento->tipo_licenca)
                                        - {{$requerimento->tituloTipoDeLicenca()}}
                                    @endif
                                </h5>
                                <span class="linha"></span>
                            </div>
                            <div class="col-md-2">
                                @can('isSecretario', \App\Models\User::class)
                                    @if (!empty($requerimento_documento->where('requerimento_id', $requerimento->id)->first()))
                                        <a  href="{{route('requerimento.exigencias.documentacao', $requerimento->id)}}" style="cursor: pointer;margin-left: 9px;"><img class="icon-licenciamento" width="25px;" src="{{asset('img/alert-svgrepo-com.svg')}}" alt="Exigências de documentação" title="Exigências de documentação"></a>
                                    @endif
                                    @if ($requerimento->documentos->count() > 0)
                                        <a href="{{route('requerimento.documentacao', $requerimento->id)}}"><img class="icon-licenciamento" src="{{asset('img/documents-svgrepo-com.svg')}}"  alt="Analisar documentos" title="Analisar documentos"></a>
                                        <a class="btn" data-toggle="modal" data-target="#documentos-edit" ><img class="icon-licenciamento" src="{{asset('img/documents-transference-symbol-svgrepo-com.svg')}}"  alt="Editar documentos" title="Editar documentos"></a>
                                        <a class="btn" data-toggle="modal" data-target="#boleto-edit" ><img class="icon-licenciamento" src="{{asset('img/boleto.png')}}" alt="Alterar boleto" title="Alterar boleto"></a>
                                    @else
                                        <a class="btn" data-toggle="modal" data-target="#documentos"><img class="icon-licenciamento" src="{{asset('img/add-documents-svgrepo-com.svg')}}"  alt="Requistar documentos" title="Requistar documentos"></a>
                                    @endif
                                    {{--@if($requerimento->visitas->count() > 0)
                                        <a class="btn"  href="{{route('requerimento.visitas', ['id' => $requerimento])}}"><img class="icon-licenciamento" src="{{asset('img/chat-svgrepo-com.svg')}}"  alt="Visitas a empresa" title="Visitas a empresa"></a>
                                    @endif--}}
                                    @if($requerimento->visitas->first() != null)
                                        <a class="btn btn-color-dafault rounded text-white" href="{{route('requerimentos.protocolo', $requerimento)}}" class="" style="margin-left: 9px;cursor: pointer; margin-left: 2px;">Protocolo</a>
                                    @endif
                                @endcan
                                @can('isAnalista', \App\Models\User::class)
                                    @if (!empty($requerimento_documento->where('requerimento_id', $requerimento->id)->first()))
                                        <a  href="{{route('requerimento.exigencias.documentacao', $requerimento->id)}}" style="cursor: pointer;margin-left: 9px;"><img class="icon-licenciamento" width="25px;" src="{{asset('img/alert-svgrepo-com.svg')}}" alt="Exigências de documentação" title="Exigências de documentação"></a>
                                    @endif
                                    @if ($requerimento->documentos->count() > 0)
                                        <a class="btn" href="{{route('requerimento.documentacao', $requerimento->id)}}"><img class="icon-licenciamento" src="{{asset('img/documents-svgrepo-com.svg')}}"  alt="Analisar documentos" title="Analisar documentos"></a>
                                    @endif
                                    @can('isProtocolista', \App\Models\User::class)
                                        <a  href="{{route('requerimentos.editar.empresa', $requerimento->id)}}"><img class="icon-licenciamento" src="{{asset('img/building-svgrepo-com.svg')}}"  alt="Editar empresa" title="Editar Informações da Empresa/Serviço"></a>
                                        @if ($requerimento->documentos->count() > 0)
                                            <a class="btn" data-toggle="modal" data-target="#documentos-edit"><img class="icon-licenciamento" src="{{asset('img/documents-transference-symbol-svgrepo-com.svg')}}"  alt="Editar documentos" title="Editar documentos"></a>
                                            <a class="btn" data-toggle="modal" data-target="#boleto-edit" ><img class="icon-licenciamento" src="{{asset('img/boleto.png')}}" alt="Alterar boleto" title="Alterar boleto"></a>
                                        @else
                                            <a class="btn" data-toggle="modal" data-target="#documentos"><img class="icon-licenciamento" src="{{asset('img/add-documents-svgrepo-com.svg')}}"  alt="Requistar documentos" title="Requistar documentos"></a>
                                        @endif
                                    @endcan
                                    @if($requerimento->visitas->first() != null)
                                        <a class="btn btn-color-dafault rounded text-white" href="{{route('requerimentos.protocolo', $requerimento)}}" class="" style="margin-left: 9px;cursor: pointer; margin-left: 2px;">Protocolo</a>
                                    @endif
                                @endcan
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="titulo-nav-tab-custom">Empresa/Serviço</h5>
                                <h6 class="titulo-nav-tab-custom" style="color: var(--primaria);">{{$requerimento->empresa->nome}}@if($requerimento->status_empresa) (status: {{lcfirst($requerimento->status_empresa)}})@endif</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="shadow card"  style="width: 100%; margin-top: 1rem;">
                    <div class="card-body">
                        <div class="accordion" id="accordionExample">
                            <div class="d-flex align-items-center justify-content-between" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="cursor: pointer;">
                                <div class="col-md-11">
                                    <h5>
                                        <button type="button" class="titulo-nav-tab-custom btn-block text-left" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" >
                                            Informações do Requerente
                                        </button>
                                    </h5>
                                </div>
                                <div class="col-md-1">
                                    <a><img src="{{asset('img/dropdown-svgrepo-com.svg')}}" alt="arquivo atual"  width="45" class="img-flex"></a>
                                </div>
                            </div>

                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="name">{{ __('Name') }}</label>
                                            <input id="name" class="form-control apenas_letras @error('name') is-invalid @enderror" type="text" name="name" value="{{$requerimento->empresa->user->name}}" disabled autofocus autocomplete="name">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="email">{{ __('Email') }}</label>
                                            <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{$requerimento->empresa->user->email}}" disabled autofocus autocomplete="email">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="rg">{{ __('RG') }}</label>
                                                <input id="rg" class="form-control @error('rg') is-invalid @enderror" type="text" name="rg" value="{{ $requerimento->empresa->user->requerente->rg ?? 'Não Informado' }}" disabled autofocus autocomplete="rg">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="orgao_emissor">{{ __('Orgão emissor') }}</label>
                                            <input id="orgao_emissor" class="form-control @error('orgão_emissor') is-invalid @enderror" type="text" name="orgão_emissor" value="{{$requerimento->empresa->user->requerente->orgao_emissor}}" disabled autocomplete="orgão_emissor">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="cpf">{{ __('CPF') }}</label>
                                            <input id="cpf" class="form-control @error('cpf') is-invalid @enderror" type="text" name="cpf" value="{{$requerimento->empresa->user->requerente->cpf}}" disabled autofocus autocomplete="cpf">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="celular">{{ __('Contato') }}</label>
                                            <input id="celular" class="form-control celular @error('celular') is-invalid @enderror" type="text" name="celular" value="{{$requerimento->empresa->user->requerente->telefone->numero}}" disabled autocomplete="celular">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="cep">{{ __('CEP') }}</label>
                                            <input id="cep" class="form-control cep @error('cep') is-invalid @enderror" type="text" name="cep" value="{{$requerimento->empresa->user->requerente->endereco->cep}}" disabled autofocus autocomplete="cep" onblur="pesquisacep(this.value);">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="bairro">{{ __('Bairro') }}</label>
                                            <input id="bairro" class="form-control @error('bairro') is-invalid @enderror" type="text" name="bairro" value="{{$requerimento->empresa->user->requerente->endereco->bairro}}" disabled autofocus autocomplete="bairro">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="rua">{{ __('Rua') }}</label>
                                            <input id="rua" class="form-control @error('rua') is-invalid @enderror" type="text" name="rua" value="{{$requerimento->empresa->user->requerente->endereco->rua}}" disabled autocomplete="rua">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="numero">{{ __('Número') }}</label>
                                            <input id="numero" class="form-control  @error('número') is-invalid @enderror" type="text" name="número" value="{{$requerimento->empresa->user->requerente->endereco->numero}}" disabled autocomplete="número">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="cidade">{{ __('Cidade') }}</label>
                                            <input type="hidden" name="cidade" value="Garanhuns">
                                            <input id="cidade" class="form-control @error('cidade') is-invalid @enderror" type="text" value="Garanhuns" required disabled autofocus autocomplete="cidade">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="estado">{{ __('Estado') }}</label>
                                            <input type="hidden" name="estado" value="PE">
                                            <select id="estado" class="form-control @error('estado') is-invalid @enderror" type="text" required autocomplete="estado" disabled>
                                                <option value=""  hidden>-- Selecione o UF --</option>
                                                <option selected value="PE">Pernambuco</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12 form-group">
                                            <label for="complemento">{{ __('Complemento') }}</label>
                                            <textarea class="form-control @error('complemento') is-invalid @enderror" type="text" name="complemento" id="complemento" cols="30" rows="5" disabled>{{$requerimento->empresa->user->requerente->endereco->complemento}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="shadow card"  style="width: 100%; margin-top: 1rem;">
                    <div class="card-body">
                        <div class="accordion" id="accordionExample">
                            <div class="d-flex align-items-center justify-content-between"  data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" style="cursor: pointer; ">
                                <div class="col-md-11">
                                    <h5>
                                        <button class="titulo-nav-tab-custom btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Informações da Empresa/Serviço
                                        </button>
                                    </h5>
                                </div>
                                <div class="col-md-1">
                                    <a><img src="{{asset('img/dropdown-svgrepo-com.svg')}}" alt="arquivo atual"  width="45" class="img-flex"></a>
                                </div>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="nome_empresa">{{ __('Name') }}</label>
                                            <input id="nome_empresa" class="form-control apenas_letras @error('nome_da_empresa') is-invalid @enderror" type="text" name="nome_da_empresa" value="{{$requerimento->empresa->nome}}" disabled autofocus autocomplete="nome_empresa">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            @if ($requerimento->empresa->eh_cnpj)
                                                <label for="cnpj">{{ __('CNPJ') }}</label>
                                                <input id="cnpj" class="form-control @error('cnpj') is-invalid @enderror" type="text" name="cnpj" value="{{$requerimento->empresa->cpf_cnpj}}" disabled autocomplete="cnpj">
                                            @else
                                                <label for="cpf">{{ __('CPF') }}</label>
                                                <input id="cpf" class="form-control @error('cpf') is-invalid @enderror" type="text" name="cpf" value="{{$requerimento->empresa->cpf_cnpj}}" disabled autocomplete="cpf">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="celular_da_empresa">{{ __('Contato') }}</label>
                                            <input id="celular_da_empresa" class="form-control celular @error('celular_da_empresa') is-invalid @enderror" type="text" name="celular_da_empresa" value="{{$requerimento->empresa->telefone->numero}}" disabled autocomplete="celular">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="setor">{{ __('Grupo da empresa') }}</label>
                                            <select id="setor" class="form-control @error('setor') is-invalid @enderror" type="text" name="setor" required autofocus autocomplete="setor" disabled>
                                                <option value="">{{$requerimento->empresa->cnaes[0]->setor->nome}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="porte">{{ __('Porte') }}</label>
                                            <select id="porte" class="form-control @error('porte') is-invalid @enderror" type="text" name="porte" required autofocus autocomplete="setor" disabled>
                                                <option value="">
                                                    @switch($requerimento->empresa->porte)
                                                        @case(\App\Models\Empresa::PORTE_ENUM['micro'])
                                                            {{__('Micro')}}
                                                            @break
                                                        @case(\App\Models\Empresa::PORTE_ENUM['pequeno'])
                                                            {{__('Pequeno')}}
                                                            @break
                                                        @case(\App\Models\Empresa::PORTE_ENUM['medio'])
                                                            {{__('Médio')}}
                                                            @break
                                                        @case(\App\Models\Empresa::PORTE_ENUM['grande'])
                                                            {{__('Grande')}}
                                                            @break
                                                        @case(\App\Models\Empresa::PORTE_ENUM['especial'])
                                                            {{__('Especial')}}
                                                            @break
                                                    @endswitch
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="cep_da_empresa">{{ __('CEP') }}</label>
                                            <input id="cep_da_empresa" class="form-control cep @error('cep_da_empresa') is-invalid @enderror" type="text" name="cep_da_empresa" value="{{$requerimento->empresa->endereco->cep}}" disabled autofocus autocomplete="cep_da_empresa" onblur="pesquisacepEmpresa(this.value);">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="bairro_da_empresa">{{ __('Bairro') }}</label>
                                            <input id="bairro_da_empresa" class="form-control @error('bairro_da_empresa') is-invalid @enderror" type="text" name="bairro_da_empresa" value="{{$requerimento->empresa->endereco->bairro}}" disabled autofocus autocomplete="bairro_da_empresa">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="rua_da_empresa">{{ __('Rua') }}</label>
                                            <input id="rua_da_empresa" class="form-control @error('rua_da_empresa') is-invalid @enderror" type="text" name="rua_da_empresa" value="{{$requerimento->empresa->endereco->rua}}" disabled autocomplete="rua_da_empresa">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="numero_da_empresa">{{ __('Número') }}</label>
                                            <input id="numero_da_empresa" class="form-control @error('número_da_empresa') is-invalid @enderror" type="text" name="número_da_empresa" value="{{$requerimento->empresa->endereco->numero}}" disabled autocomplete="número_da_empresa">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="cidade_da_empresa">{{ __('Cidade') }}</label>
                                            <input type="hidden" name="cidade_da_empresa" value="Garanhuns">
                                            <input id="cidade_da_empresa" class="form-control @error('cidade_da_empresa') is-invalid @enderror" type="text" value="Garanhuns" required disabled autofocus autocomplete="cidade_da_empresa">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="estado_da_empresa">{{ __('Estado') }}</label>
                                            <input type="hidden" name="estado_da_empresa" value="PE">
                                            <select id="estado_da_empresa" class="form-control @error('estado_da_empresa') is-invalid @enderror" type="text" required autocomplete="estado_da_empresa" disabled>
                                                <option value=""  hidden>-- Selecione o UF --</option>
                                                <option selected value="PE">Pernambuco</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12 form-group">
                                            <label for="complemento_da_empresa">{{ __('Complemento') }}</label>
                                            <textarea class="form-control @error('complemento_da_empresa') is-invalid @enderror" type="text" name="complemento_da_empresa" id="complemento_da_empresa" cols="30" rows="5" disabled>{{$requerimento->empresa->endereco->complemento}}</textarea>
                                        </div>
                                    </div>
                                    @can('isSecretarioOrAnalista', \App\Models\User::class)
                                    <div class="form-row">
                                        <div class="col-md-8 form-group">
                                            <h3>Cnaes</h3>
                                        </div>
                                        @if($requerimento->empresa->cnaes->first()->nome == "Atividades similares")
                                            <div class="col-md-4 form-group">
                                                <a class="btn btn-success btn-color-dafault" data-toggle="modal" data-target="#atribuir_potencial_poluidor" style="float: right;">Atribuir potencial poluidor</a>
                                            </div>
                                        @endif
                                    </div>
                                        <div class="form-row">
                                            @foreach ($requerimento->empresa->cnaes as $cnae)
                                                <div class="card" style="width: 18rem; margin: 5px;">
                                                    <div class="card-body">
                                                    <h5 class="card-title">{{$cnae->nome}}</h5>
                                                    <h6 class="card-subtitle mb-2 text-muted">{{$cnae->codigo}}</h6>
                                                    <p class="card-text">
                                                        @switch($cnae->potencial_poluidor)
                                                            @case(1)
                                                                Baixo
                                                                @break
                                                            @case(2)
                                                                Médio
                                                                @break
                                                            @case(3)
                                                                Alto
                                                                @break
                                                        @endswitch
                                                    </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @can('isSecretario', \App\Models\User::class)
                    @if ($requerimento->status != \App\Models\Requerimento::STATUS_ENUM['cancelada'])
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <div class="shadow card" style="margin-top: 1rem;">
                                    <div class="card-body">
                                        <div class="align-items-center">
                                            <div class="row justify-content-between">
                                                <div class="col-md-10">
                                                    <h5 class="titulo-nav-tab-custom" style="color: var(--primaria);">Atribuir protocolista</h5>
                                                    <span class="linha"></span>
                                                </div>
                                                <div class="col-md-2">
                                                    <a data-toggle="modal" data-target="#atribuir-analista" style="cursor: pointer;"><img width="25" src="{{asset('img/plus-svgrepo-com.svg')}}"  alt="Atribuir analista" title="Atribuir analista"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mt-4">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <a><img src="{{asset('img/profile-user-svgrepo-com.svg')}}" alt="usuario"  width="45" class="img-flex"></a>
                                                </div>
                                                <div class="col-md-10" style="padding-left: 30px;">
                                                    <h6 class="titulo-nav-tab-custom">{{$requerimento->protocolista->name}}</h6>
                                                    <h6 class="titulo-nav-tab-custom">Tipo de analista: <span style="color: var(--primaria);">@if($requerimento->protocolista->ehAnalista()) Processo @else Protocolista @endif </span> </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="shadow card" style="margin-top: 1rem;">
                                    <div class="card-body">
                                        <div class="align-items-center">
                                            <div class="row justify-content-between">
                                                <div class="col-md-10">
                                                    <h5 class="titulo-nav-tab-custom" style="color: var(--primaria);">Atribuir analista de processo</h5>
                                                    <span class="linha"></span>
                                                </div>
                                                <div class="col-md-2">
                                                    <a data-toggle="modal" data-target="#atribuir-analista-processo" style="cursor: pointer;"><img width="25" src="{{asset('img/plus-svgrepo-com.svg')}}"  alt="Atribuir analista de processo" title="Atribuir analista de processo"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mt-4">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <a><img src="{{asset('img/profile-user-svgrepo-com.svg')}}" alt="usuario"  width="45" class="img-flex"></a>
                                                </div>
                                                <div class="col-md-10" style="padding-left: 30px;">
                                                    <h6 class="titulo-nav-tab-custom">{{$requerimento->analistaProcesso ? $requerimento->analistaProcesso->name: "Sem analista atribuído"}}</h6>
                                                    @if($requerimento->analistaProcesso)
                                                        <h6 class="titulo-nav-tab-custom">Tipo de analista: <span style="color: var(--primaria);">@if($requerimento->analistaProcesso->ehAnalista()) Processo @else Protocolista @endif </span> </h6>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endcan
            </div>
        </div>
    </div>
    @if ($requerimento->documentos->count() <= 0)
        <!-- Modal documentos -->
        <div class="modal fade" id="documentos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: var(--primaria);">
                        <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Requisitar documentos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="documentos-form" method="POST" action="{{route('requerimento.checklist')}}">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-12">
                                    <h6 style="font-weight: bolder;">Informações básicas</h6>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="licenca">{{__('Selecione a licença que a empresa terá que emitir')}}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select name="licença" id="licença" class="form-control @error('licença') is-invalid @enderror" required onchange="defaultDocs(this)">
                                        <option disabled selected value="">-- Selecione o tipo de licença --</option>
                                        <option @if(old('licença') == \App\Models\Licenca::TIPO_ENUM['simplificada']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['simplificada']}}">Simplificada</option>
                                        <option @if(old('licença') == \App\Models\Licenca::TIPO_ENUM['previa']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['previa']}}">Prévia</option>
                                        <option @if(old('licença') == \App\Models\Licenca::TIPO_ENUM['instalacao']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['instalacao']}}">Instalação</option>
                                        <option @if(old('licença') == \App\Models\Licenca::TIPO_ENUM['operacao']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['operacao']}}">Operação</option>
                                        <option @if(old('licença') == \App\Models\Licenca::TIPO_ENUM['regularizacao']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['regularizacao']}}">Regularização</option>
                                        <option @if(old('licença') == \App\Models\Licenca::TIPO_ENUM['autorizacao_ambiental']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['autorizacao_ambiental']}}">Autorização</option>
                                    </select>

                                    @error('licença')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="opcão_taxa_serviço">{{__('Taxa de serviço de emissão de licença')}}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select name="opcão_taxa_serviço" id="opcão_taxa_serviço" class="form-control @error('opcão_taxa_serviço') is-invalid @enderror" required onchange="mostrarInput(this)">
                                        <option selected disabled value="">-- Selecione uma opção --</option>
                                        <option @if(old('opcão_taxa_serviço') == $definir_valor['manual']) selected @endif value="{{$definir_valor['manual']}}">Definir de forma manual</option>
                                        <option @if(old('opcão_taxa_serviço') == $definir_valor['automatica']) selected @endif value="{{$definir_valor['automatica']}}">Definir de forma automática</option>
                                        <option @if(old('opcão_taxa_serviço') == $definir_valor['automatica_com_juros']) selected @endif value="{{$definir_valor['automatica_com_juros']}}">Definir de forma automática com juros</option>
                                    </select>

                                    @error('opcão_taxa_serviço')
                                        <div id="validationServer03Feedback" class="invalid-feedback" style="display: block;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div id="div_taxa_servico_manual" class="col-md-6 form-group" style="@error('valor_da_taxa_de_serviço') display: block; @else display: none;  @endif">
                                    <label for="valor_da_taxa_de_serviço">{{__('Valor da taxa de serviço')}}</label>
                                    <input type="number" step="0.01" name="valor_da_taxa_de_serviço" class="form-control" @error('valor_da_taxa_de_serviço') is-invalid @enderror placeholder="Digite o valor a ser cobrado" value="{{old('valor_da_taxa_de_serviço')}}">

                                    @error('valor_da_taxa_de_serviço')
                                        <div id="validationServer03Feedback" class="invalid-feedback" style="display: block;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div id="div_taxa_servico_juros" class="col-md-6 form-group" style="@error('valor_do_juros') display: block; @else display: none; @endif">
                                    <label for="valor_do_juros">{{__('Valor do juros cobrado em porcentagem')}}</label>
                                    <input type="number" name="valor_do_juros" class="form-control" @error('valor_do_juros') is-invalid @enderror placeholder="Digite a porcentagem cobrada a mais" value="{{old('valor_do_juros')}}">

                                    @error('valor_do_juros')
                                        <div id="validationServer03Feedback" class="invalid-feedback" style="display: block;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <h6 style="font-weight: bolder;">Documentos que o empresário deve enviar</h6>
                                </div>
                            </div>
                            <input type="hidden" name="requerimento" value="{{$requerimento->id}}">
                            @foreach ($documentos as $i => $documento)
                                <div class="form-check @if(!$loop->first) mt-3 @endif">
                                    <input id="documento-{{$documento->id}}" class="form-check-input" type="checkbox" name="documentos[]" value="{{$documento->id}}" @if(old('documentos.'.$i) != null) checked @endif>
                                    <label for="documento-{{$documento->id}}" class="form-check-label">{{$documento->nome}}</label>
                                </div>
                            @endforeach
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" form="documentos-form">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Modal documentos -->
        <div class="modal fade" id="documentos-edit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: var(--primaria);">
                        <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Editar checklist de documentos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="documentos-form-edit" method="POST" action="{{route('requerimento.checklist.edit')}}">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="requerimento" value="{{$requerimento->id}}">
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="licenca">{{__('Selecione a licença que a empresa terá que emitir')}}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select name="licença" id="licença" class="form-control @error('licença') is-invalid @enderror" onchange="defaultDocs(this)">
                                        <option @if(old('licença', $requerimento->tipo_licenca) == \App\Models\Licenca::TIPO_ENUM['simplificada']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['simplificada']}}">Simplificada</option>
                                        <option @if(old('licença', $requerimento->tipo_licenca) == \App\Models\Licenca::TIPO_ENUM['previa']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['previa']}}">Prévia</option>
                                        <option @if(old('licença', $requerimento->tipo_licenca) == \App\Models\Licenca::TIPO_ENUM['instalacao']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['instalacao']}}">Instalação</option>
                                        <option @if(old('licença', $requerimento->tipo_licenca) == \App\Models\Licenca::TIPO_ENUM['operacao']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['operacao']}}">Operação</option>
                                        <option @if(old('licença', $requerimento->tipo_licenca) == \App\Models\Licenca::TIPO_ENUM['regularizacao']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['regularizacao']}}">Regularização</option>
                                        <option @if(old('licença', $requerimento->tipo_licenca) == \App\Models\Licenca::TIPO_ENUM['autorizacao_ambiental']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['autorizacao_ambiental']}}">Autorização</option>
                                    </select>

                                    @error('licença')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            @foreach ($documentos as $documento)
                                <div class="form-check @if(!$loop->first) mt-3 @endif">
                                    <input id="documento-{{$documento->id}}" class="form-check-input" type="checkbox" name="documentos[]" value="{{$documento->id}}" @if($requerimento->documentos->contains('id', $documento->id)) checked @endif>
                                    <label for="documento-{{$documento->id}}" class="form-check-label">{{$documento->nome}}</label>
                                </div>
                            @endforeach
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-color-dafault  submeterFormBotao" form="documentos-form-edit">Atualizar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal valor -->
        <div class="modal fade" id="boleto-edit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: var(--primaria);">
                        <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Editar valor do requerimento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="boleto-form-edit" method="POST" action="{{route('requerimento.valor.edit', $requerimento->id)}}">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <p><b>{{__('Valor atual: R$')}} {{$requerimento->valor}}</b></p>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="opcão_taxa_serviço_edit">{{__('Taxa de serviço de emissão de licença')}}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select name="opcão_taxa_serviço" id="opcão_taxa_serviço_edit" class="form-control @error('opcão_taxa_serviço') is-invalid @enderror" required onchange="mostrarInputEdit(this)">
                                        <option selected disabled value="">-- Selecione uma opção --</option>
                                        <option @if(old('opcão_taxa_serviço', $requerimento->definicao_valor) == $definir_valor['manual']) selected @endif value="{{$definir_valor['manual']}}">Definir de forma manual</option>
                                        <option @if(old('opcão_taxa_serviço', $requerimento->definicao_valor) == $definir_valor['automatica']) selected @endif value="{{$definir_valor['automatica']}}">Definir de forma automática</option>
                                        <option @if(old('opcão_taxa_serviço', $requerimento->definicao_valor) == $definir_valor['automatica_com_juros']) selected @endif value="{{$definir_valor['automatica_com_juros']}}">Definir de forma automática com juros</option>
                                    </select>

                                    @error('opcão_taxa_serviço')
                                        <div id="validationServer03Feedback" class="invalid-feedback" style="display: block;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div id="div_taxa_servico_manual_edit" class="col-md-6 form-group" style="@error('valor_da_taxa_de_serviço') display: block; @else @if($requerimento->definicao_valor == $definir_valor['manual'])  display: block; @else display: none; @endif @endif">
                                    <label for="valor_da_taxa_de_serviço_edit">{{__('Valor da taxa de serviço')}}</label>
                                    <input type="number" step="0.01" id="valor_da_taxa_de_serviço_edit" name="valor_da_taxa_de_serviço" class="form-control" @error('valor_da_taxa_de_serviço') is-invalid @enderror placeholder="Digite o valor a ser cobrado" value="{{old('valor_da_taxa_de_serviço', $requerimento->valor)}}">

                                    @error('valor_da_taxa_de_serviço')
                                        <div id="validationServer03Feedback" class="invalid-feedback" style="display: block;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div id="div_taxa_servico_juros_edit" class="col-md-6 form-group" style="@error('valor_do_juros') display: block; @else @if($requerimento->definicao_valor == $definir_valor['automatica_com_juros'])  display: block; @else display: none; @endif  @endif">
                                    <label for="valor_do_juros_edit">{{__('Valor do juros cobrado em porcentagem')}}</label>
                                    <input type="number" id="valor_do_juros_edit" name="valor_do_juros" class="form-control" @error('valor_do_juros') is-invalid @enderror placeholder="Digite a porcentagem cobrada a mais" value="{{old('valor_do_juros', $requerimento->valor_juros)}}">

                                    @error('valor_do_juros')
                                        <div id="validationServer03Feedback" class="invalid-feedback" style="display: block;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                @if ($requerimento->boletos->last())
                                    <p> <strong>Obs:</strong> O boleto deste requerimento está cancelado, caso necessário atualizar o valor do requerimento para gerar um novo boleto.</p>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div>
                            @if ($requerimento->boletos->last() && !$requerimento->boletos->last()->cancelado && !$requerimento->boletos->last()->pago)
                                <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#boleto-cancelar">Cancelar boleto</button>
                            @endif
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                            @if (!$requerimento->boletos()->exists() || ($requerimento->boletos->last() && !$requerimento->boletos->last()->pago))
                                <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" form="boleto-form-edit">Atualizar</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @can('isSecretario', \App\Models\User::class)
        <!-- Modal atribuicao protocolista -->
        <div class="modal fade" id="atribuir-analista" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: var(--primaria);">
                        <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Atribuir protocolista</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="atribuir-analista-form" method="POST" action="{{route('requerimentos.atribuir.analista', 'protocolista')}}">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-12">
                                    <input type="hidden" name="requerimento" value="{{$requerimento->id}}">
                                    <label for="analista">{{__('Selecione um protocolista')}}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select name="analista" id="analista" class="form-control @error('analista') is-invalid @enderror" required>
                                        <option value="">-- {{__('Selecione um protocolista')}} --</option>
                                        @foreach ($protocolistas as $protocolista)
                                            <option value="{{$protocolista->id}}">{{$protocolista->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-color-dafault  submeterFormBotao" form="atribuir-analista-form">Atribuir ao protocolista</button>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    @can('isSecretario', \App\Models\User::class)
        <!-- Modal atribuicao analista de processo-->
        <div class="modal fade" id="atribuir-analista-processo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: var(--primaria);">
                        <h5 class="modal-title" id="staticBackdropLabel2" style="color: white;">Atribuir analista de processo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="atribuir-analista-processo-form" method="POST" action="{{route('requerimentos.atribuir.analista', 'processo')}}">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-12">
                                    <input type="hidden" name="requerimento" value="{{$requerimento->id}}">
                                    <label for="analista">{{__('Selecione um analista de processo')}}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select name="analista" id="analista" class="form-control @error('analista') is-invalid @enderror" required>
                                        <option value="">-- {{__('Selecione um analista de processo')}} --</option>
                                        @foreach ($analistas as $analista)
                                            <option value="{{$analista->id}}">{{$analista->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" form="atribuir-analista-processo-form">Atribuir ao analista de processo</button>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    @can('isSecretarioOrProtocolista', \App\Models\User::class)
        <div class="modal fade" id="atribuir_potencial_poluidor" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Atribuir potencial poluidor ao requerimento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form id="atribuir-potencial-poluidor-form" method="POST" action="{{route('requerimentos.atribuir.potencial.poluidor', $requerimento)}}">
                        @csrf
                        <input type="hidden" name="licença" value="{{$requerimento->tipo_licenca}}">
                        <input type="hidden" name="opcão_taxa_serviço" value="{{$requerimento->definicao_valor}}">
                        <input type="hidden" name="valor_da_taxa_de_serviço" value="{{$requerimento->valor}}">
                        <input type="hidden" name="valor_do_juros" value="{{$requerimento->valor_juros}}">
                        <div class="col-md-12 form-group">
                            <label for="potencial_poluidor">{{ __('Potencial poluidor') }}<span style="color: red; font-weight: bold;">*</span></label>
                            <select name="potencial_poluidor" id="potencial_poluidor" class="form-control @error('potencial_poluidor') is-invalid @enderror" required >
                                <option value="">-- Selecione o potencial poluidor --</option>
                                @if(old('potencial_poluidor') != null)
                                    <option @if(old('potencial_poluidor') == "baixo") selected @endif value="baixo">Baixo</option>
                                    <option @if(old('potencial_poluidor') == "medio") selected @endif value="medio">Médio</option>
                                    <option @if(old('potencial_poluidor') == "alto") selected @endif value="alto">Alto</option>
                                @else
                                    <option @if($requerimento->potencial_poluidor_atribuido == 1) selected @endif value="baixo">Baixo</option>
                                    <option @if($requerimento->potencial_poluidor_atribuido == 2) selected @endif value="medio">Médio</option>
                                    <option @if($requerimento->potencial_poluidor_atribuido == 3) selected @endif value="alto">Alto</option>
                                @endif
                            </select>
                            @error('potencial_poluidor')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="submeterFormBotao" class="btn btn-primary" form="atribuir-potencial-poluidor-form">Salvar</button>
                </div>
            </div>
            </div>
        </div>
       @if ($requerimento->boletos->last())
        <div class="modal fade show" id="boleto-cancelar" data-backdrop="static" data-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-modal="true" role="dialog">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header" style="background-color: #dc3545;">
                         <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Cancelar boleto</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">×</span>
                         </button>
                     </div>
                     <div class="modal-body">
                         <form id="cancelar-boleto-form" method="POST" action="{{route('boletos.destroy', $requerimento->boletos->last())}}">
                             @csrf
                             @method('DELETE')
                             <div class="row">
                                 <div class="col-md-12">
                                     <p><strong>Tem certeza que deseja cancelar o boleto deste requerimento?</strong></p>
                                     <p>Essa ação não poderá ser desfeita.</p>
                                 </div>
                             </div>
                         </form>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                         <button type="submit" class="btn btn-danger submeterFormBotao" form="cancelar-boleto-form">
                             Cancelar boleto </button>
                     </div>
                 </div>
             </div>
         </div>
       @endif
    @endcan

    @push ('scripts')
        <script>
            function defaultDocs(select) {
                $.ajax({
                    url:"{{route('documentos.default')}}",
                    type:"get",
                    data: {"licenca_enum": select.value},
                    dataType:'json',
                    success: function(data) {
                        var documento = null;
                        if(data.length > 0){
                            for(var i = 0; i < data.length; i++){
                                documento = document.getElementById('documento-'+data[i].id);
                                console.log(documento);
                                if (data[i].padrao) {
                                    documento.checked = true;
                                } else if (data[i].padrao == null) {
                                    documento.checked = false;
                                } else {
                                    documento.checked = false;
                                }
                            }
                        }
                    }
                });
            }

            function mostrarInput(select) {
                var div_taxa_servico = document.getElementById('div_taxa_servico_manual');
                var div_taxa_juros = document.getElementById('div_taxa_servico_juros');

                switch (select.value) {
                    case "{{$definir_valor['manual']}}":
                        div_taxa_servico.style.display = "block";
                        div_taxa_juros.style.display = "none";
                        break;
                    case "{{$definir_valor['automatica']}}":
                        div_taxa_servico.style.display = "none";
                        div_taxa_juros.style.display = "none";
                        break;
                    case "{{$definir_valor['automatica_com_juros']}}":
                        div_taxa_servico.style.display = "none";
                        div_taxa_juros.style.display = "block";
                        break;
                }
            }

            function mostrarInputEdit(select) {
                var div_taxa_servico = document.getElementById('div_taxa_servico_manual_edit');
                var div_taxa_juros = document.getElementById('div_taxa_servico_juros_edit');

                switch (select.value) {
                    case "{{$definir_valor['manual']}}":
                        div_taxa_servico.style.display = "block";
                        div_taxa_juros.style.display = "none";
                        break;
                    case "{{$definir_valor['automatica']}}":
                        div_taxa_servico.style.display = "none";
                        div_taxa_juros.style.display = "none";
                        break;
                    case "{{$definir_valor['automatica_com_juros']}}":
                        div_taxa_servico.style.display = "none";
                        div_taxa_juros.style.display = "block";
                        break;
                }
            }
        </script>
    @endpush
    @endsection
</x-app-layout>
