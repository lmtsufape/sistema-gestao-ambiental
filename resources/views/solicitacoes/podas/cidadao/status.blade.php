<x-guest-layout>
    @component('layouts.nav_bar')@endcomponent
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Solicitação de poda/corte</h4>
                        @can('usuarioInterno', \App\Models\User::class)
                            <h6 class="card-subtitle mb-2 text-muted">Solicitações de podas > Visualizar solicitação de poda/corte {{$solicitacao->protocolo}}</h6>
                        @endcan
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        <a class="btn my-2" href="{{route('podas.cidadao.index')}}" style="cursor: pointer;"><img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}"  alt="Voltar" title="Voltar"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="nome">Nome<span style="color: red; font-weight: bold;">
                                            *</span></label>
                                    <input id="nome" class="form-control" type="text"
                                        value="{{ $solicitacao->cidadao->user->name }}" autocomplete="nome" disabled>
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="email">E-mail<span style="color: red; font-weight: bold;">
                                        *</span></label>
                                <input id="email" class="form-control" type="text"
                                    value="{{ $solicitacao->cidadao->user->email }}" autocomplete="email" disabled>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="cpf">{{ __('CPF') }}<span style="color: red; font-weight: bold;">
                                        *</span></label>
                                <input id="cpf" class="form-control simple-field-data-mask" type="text"
                                    value="{{ $solicitacao->cidadao->cpf }}" autofocus autocomplete="cpf"
                                    data-mask="000.000.000-00" disabled>
                            </div>
                    </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="cep">{{ __('CEP') }}<span style="color: red; font-weight: bold;"> *</span></label>
                                    <input id="cep" class="form-control cep" type="text"  value="{{$solicitacao->endereco->cep}}" disabled>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="bairro">{{ __('Bairro') }}<span style="color: red; font-weight: bold;"> *</span></label>
                                    <input id="bairro" class="form-control" type="text"  value="{{$solicitacao->endereco->bairro}}" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="rua">{{ __('Rua') }}<span style="color: red; font-weight: bold;"> *</span></label>
                                    <input id="rua" class="form-control" type="text"  value="{{$solicitacao->endereco->rua}}" disabled>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="numero">{{ __('Número') }}<span style="color: red; font-weight: bold;"> *</span></label>
                                    <input id="numero" class="form-control " type="text"  value="{{$solicitacao->endereco->numero}}" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="cidade">{{ __('Cidade') }}</label>
                                    <input id="cidade" class="form-control" type="text"  value="Garanhuns" disabled>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="estado">{{ __('Estado') }}</label>
                                    <select id="estado" class="form-control" type="text" disabled >
                                        <option selected value="PE">Pernambuco</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="complemento">{{ __('Complemento') }}</label>
                                    <input class="form-control" value="{{$solicitacao->endereco->complemento}}" type="text"  id="complemento" disabled/>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="comentario">{{ __('Comentário') }}</label>
                                <textarea disabled class="form-control" type="text" id="comentario">{{$solicitacao->comentario}}</textarea>
                            </div>
                        </div>
                        </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-row">
                    <div class="col-md-12" style="margin-bottom:20px">
                        <div class="card shadow bg-white" style="border-radius:12px; border-width:0px;">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-12" style="margin-bottom: 0.5rem">
                                        <h5 class="card-title mb-0"
                                            style="font-family:Arial, Helvetica, sans-serif; color:#08a02e; font-weight:bold">
                                            Status da solicitação</h5>
                                    </div>
                                    <div class="col-md-12">
                                        @switch($solicitacao->status)
                                            @case(\App\Models\SolicitacaoMuda::STATUS_ENUM['registrada'])
                                                <h5>Solicitação em análise.</h5>
                                            @break
                                            @case(\App\Models\SolicitacaoMuda::STATUS_ENUM['deferido'])
                                                <h5>Solicitação deferida</h5>
                                            @break
                                            @case(\App\Models\SolicitacaoMuda::STATUS_ENUM['indeferido'])
                                                <h5>Solicitação indeferida</h5>
                                                <p>Motivo: {{$solicitacao->motivo_indeferimento}}</p>
                                            @break
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @component('layouts.footer')@endcomponent
</x-guest-layout>
