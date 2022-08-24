<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 2rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-sm-12">
                <div class="form-row">
                    <div class="col-md-12" style="padding-top: 15px;">
                        <h4 class="card-title">Empresa/Serviço {{$empresa->nome}}</h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('empresas.listar')}}">Empresas</a> > Dados da empresa {{$empresa->nome}}</h6>
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
                @enderror
                <div class="shadow card" style="width: 100%;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="titulo-nav-tab-custom">{{$empresa->nome}}</h5>
                            </div>
                            <div class="col-md-6" style="text-align: right;">
                                <span style="position: relative; align-items: center; justify-content: center">
                                    <a href="{{route('empresas.notificacoes.index', ['empresa' => $empresa])}}" class="btn btn-success btn-default btn-padding border">
                                        <img class="icon-licenciamento" src="{{asset('img/Icon bell-white.svg')}}" alt="Icone de notificações da empresa/serviço">
                                        Notificações
                                    </a>
                                </span>
                                @can('isSecretario', \App\Models\User::class)
                                    <span style="position: relative; align-items: center; justify-content: center">
                                        <a href="{{route('historico.empresa', $empresa->id)}}" class="btn btn-success btn-default btn-padding border">
                                        <img class="icon-licenciamento" src="{{asset('img/history_icon.svg')}}" alt="Icone histórico de modificações">
                                        Histórico de modificações
                                        </a>
                                    </span>
                                @endcan
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
                            <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="nome_empresa">{{ __('Name') }}</label>
                                            <input id="nome_empresa" class="form-control apenas_letras @error('nome_da_empresa') is-invalid @enderror" type="text" name="nome_da_empresa" value="{{$empresa->nome}}" disabled autofocus autocomplete="nome_empresa">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            @if ($empresa->eh_cnpj)
                                                <label for="cnpj">{{ __('CNPJ') }}</label>
                                                <input id="cnpj" class="form-control @error('cnpj') is-invalid @enderror" type="text" name="cnpj" value="{{$empresa->cpf_cnpj}}" disabled autocomplete="cnpj">
                                            @else
                                                <label for="cpf">{{ __('CPF') }}</label>
                                                <input id="cpf" class="form-control @error('cpf') is-invalid @enderror" type="text" name="cpf" value="{{$empresa->cpf_cnpj}}" disabled autocomplete="cpf">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="celular_da_empresa">{{ __('Contato') }}</label>
                                            <input id="celular_da_empresa" class="form-control celular @error('celular_da_empresa') is-invalid @enderror" type="text" name="celular_da_empresa" value="{{$empresa->telefone->numero}}" disabled autocomplete="celular">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="setor">{{ __('Grupo da empresa') }}</label>
                                            <select id="setor" class="form-control @error('setor') is-invalid @enderror" type="text" name="setor" required autofocus autocomplete="setor" disabled>
                                                <option value="">{{$empresa->cnaes()->first() ? $empresa->cnaes()->first()->setor->nome : "Sem cnae cadastrado"}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="porte">{{ __('Porte') }}</label>
                                            <select id="porte" class="form-control @error('porte') is-invalid @enderror" type="text" name="porte" required autofocus autocomplete="setor" disabled>
                                                <option value="">
                                                    @switch($empresa->porte)
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
                                            <input id="cep_da_empresa" class="form-control cep @error('cep_da_empresa') is-invalid @enderror" type="text" name="cep_da_empresa" value="{{$empresa->endereco->cep}}" disabled autofocus autocomplete="cep_da_empresa" onblur="pesquisacepEmpresa(this.value);">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="bairro_da_empresa">{{ __('Bairro') }}</label>
                                            <input id="bairro_da_empresa" class="form-control @error('bairro_da_empresa') is-invalid @enderror" type="text" name="bairro_da_empresa" value="{{$empresa->endereco->bairro}}" disabled autofocus autocomplete="bairro_da_empresa">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="rua_da_empresa">{{ __('Rua') }}</label>
                                            <input id="rua_da_empresa" class="form-control @error('rua_da_empresa') is-invalid @enderror" type="text" name="rua_da_empresa" value="{{$empresa->endereco->rua}}" disabled autocomplete="rua_da_empresa">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="numero_da_empresa">{{ __('Número') }}</label>
                                            <input id="numero_da_empresa" class="form-control @error('número_da_empresa') is-invalid @enderror" type="text" name="número_da_empresa" value="{{$empresa->endereco->numero}}" disabled autocomplete="número_da_empresa">
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
                                            <textarea class="form-control @error('complemento_da_empresa') is-invalid @enderror" type="text" name="complemento_da_empresa" id="complemento_da_empresa" cols="30" rows="5" disabled>{{$empresa->endereco->complemento}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-8 form-group">
                                            <h3>Cnaes</h3>
                                        </div>
                                        @if($empresa->cnaes()->exists() && $empresa->cnaes->first()->nome == "Atividades similares")
                                            <div class="col-md-4 form-group">
                                                <a class="btn btn-success btn-color-dafault" data-toggle="modal" data-target="#atribuir_potencial_poluidor" style="float: right;">Atribuir potencial poluidor</a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-row">
                                        @foreach ($empresa->cnaes as $cnae)
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
                                </div>
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

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="name">{{ __('Name') }}</label>
                                            <input id="name" class="form-control apenas_letras @error('name') is-invalid @enderror" type="text" name="name" value="{{$empresa->user->name}}" disabled autofocus autocomplete="name">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="email">{{ __('Email') }}</label>
                                            <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{$empresa->user->email}}" disabled autofocus autocomplete="email">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="rg">{{ __('RG') }}</label>
                                            <input id="rg" class="form-control @error('rg') is-invalid @enderror" type="text" name="rg" value="{{$empresa->user->requerente->rg}}" disabled autofocus autocomplete="rg">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="orgao_emissor">{{ __('Orgão emissor') }}</label>
                                            <input id="orgao_emissor" class="form-control @error('orgão_emissor') is-invalid @enderror" type="text" name="orgão_emissor" value="{{$empresa->user->requerente->orgao_emissor}}" disabled autocomplete="orgão_emissor">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="cpf">{{ __('CPF') }}</label>
                                            <input id="cpf" class="form-control @error('cpf') is-invalid @enderror" type="text" name="cpf" value="{{$empresa->user->requerente->cpf}}" disabled autofocus autocomplete="cpf">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="celular">{{ __('Contato') }}</label>
                                            <input id="celular" class="form-control celular @error('celular') is-invalid @enderror" type="text" name="celular" value="{{$empresa->user->requerente->telefone->numero}}" disabled autocomplete="celular">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="cep">{{ __('CEP') }}</label>
                                            <input id="cep" class="form-control cep @error('cep') is-invalid @enderror" type="text" name="cep" value="{{$empresa->user->requerente->endereco->cep}}" disabled autofocus autocomplete="cep" onblur="pesquisacep(this.value);">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="bairro">{{ __('Bairro') }}</label>
                                            <input id="bairro" class="form-control @error('bairro') is-invalid @enderror" type="text" name="bairro" value="{{$empresa->user->requerente->endereco->bairro}}" disabled autofocus autocomplete="bairro">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 form-group">
                                            <label for="rua">{{ __('Rua') }}</label>
                                            <input id="rua" class="form-control @error('rua') is-invalid @enderror" type="text" name="rua" value="{{$empresa->user->requerente->endereco->rua}}" disabled autocomplete="rua">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="numero">{{ __('Número') }}</label>
                                            <input id="numero" class="form-control  @error('número') is-invalid @enderror" type="text" name="número" value="{{$empresa->user->requerente->endereco->numero}}" disabled autocomplete="número">
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
                                            <textarea class="form-control @error('complemento') is-invalid @enderror" type="text" name="complemento" id="complemento" cols="30" rows="5" disabled>{{$empresa->user->requerente->endereco->complemento}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
