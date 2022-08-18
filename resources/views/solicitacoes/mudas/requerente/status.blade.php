@guest
<x-guest-layout>

    <div class="container" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Solicitação de mudas</h4>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        {{-- <a title="Voltar" href="{{route('mudas.requerente.index')}}">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="card-body">
                           <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="nome">Nome</label>
                                    <input id="nome" class="form-control" type="text" name="nome"
                                        value="{{ $solicitacao->requerente->user->name }}" autocomplete="nome" disabled>
                                </div>
                           </div>
                           <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="email">E-mail</label>
                                    <input id="email" class="form-control" type="text" name="email"
                                        value="{{ $solicitacao->requerente->user->email }}" autocomplete="email" disabled>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="cpf">{{ __('CPF') }}</label>
                                    <input id="cpf" class="form-control simple-field-data-mask" type="text" name="cpf"
                                        value="{{ $solicitacao->requerente->cpf }}" autofocus autocomplete="cpf"
                                        data-mask="000.000.000-00" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="cep">{{ __('CEP') }}</label>
                                    <input id="cep" class="form-control cep" type="text" name="cep" value="{{$solicitacao->requerente->endereco->cep}}" disabled>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="bairro">{{ __('Bairro') }}</label>
                                    <input id="bairro" class="form-control" type="text" name="bairro" value="{{$solicitacao->requerente->endereco->bairro}}" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="rua">{{ __('Rua') }}</label>
                                    <input id="rua" class="form-control" type="text" name="rua" value="{{$solicitacao->requerente->endereco->rua}}" disabled>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="numero">{{ __('Número') }}</label>
                                    <input id="numero" class="form-control " type="text" name="numero" value="{{$solicitacao->requerente->endereco->numero}}" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="cidade">{{ __('Cidade') }}</label>
                                    <input id="cidade" class="form-control" type="text" name="cidade" value="Garanhuns" disabled>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="estado">{{ __('Estado') }}</label>
                                    <select id="estado" class="form-control" type="text" disabled name="estado">
                                        <option selected value="PE">Pernambuco</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="complemento">{{ __('Complemento') }}</label>
                                    <input class="form-control" value="{{$solicitacao->requerente->endereco->complemento}}" type="text" name="complemento" id="complemento" disabled/>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="mudas">{{ __('Mudas Solicitadas') }}</label>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Espécie</th>
                                            <th scope="col" style="text-align: center">Quantidade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($solicitacao->mudasSolicitadas as $mudaSolicitada)
                                            <tr>
                                                <td >
                                                    {{$mudaSolicitada->especie->nome}}
                                                </td>
                                                <td style="text-align: center">
                                                    {{$mudaSolicitada->qtd_mudas}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="complemento">{{ __('Comentário') }}</label>
                                    <textarea class="form-control" type="text" disabled>{{$solicitacao->comentario}}
                                    </textarea>
                                </div>
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
                                    <div class="col-md-12">
                                        @if(isset($solicitacao->arquivo))
                                            <div style="margin-top: 20px; margin-bottom: 10px;">
                                                <a href="{{route('mudas.documento', ['id' => $solicitacao->id])}}" target="_new">Baixar solicitação</a>
                                            </div>
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

</x-guest-layout>
@else
<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Solicitação de mudas</h4>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        {{-- <a title="Voltar" href="{{route('mudas.requerente.index')}}">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="card-body">
                           <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="nome">Nome</label>
                                    <input id="nome" class="form-control" type="text" name="nome"
                                        value="{{ $solicitacao->requerente->user->name }}" autocomplete="nome" disabled>
                                </div>
                           </div>
                           <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="email">E-mail</label>
                                    <input id="email" class="form-control" type="text" name="email"
                                        value="{{ $solicitacao->requerente->user->email }}" autocomplete="email" disabled>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="cpf">{{ __('CPF') }}</label>
                                    <input id="cpf" class="form-control simple-field-data-mask" type="text" name="cpf"
                                        value="{{ $solicitacao->requerente->cpf }}" autofocus autocomplete="cpf"
                                        data-mask="000.000.000-00" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="cep">{{ __('CEP') }}</label>
                                    <input id="cep" class="form-control cep" type="text" name="cep" value="{{$solicitacao->requerente->endereco->cep}}" disabled>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="bairro">{{ __('Bairro') }}</label>
                                    <input id="bairro" class="form-control" type="text" name="bairro" value="{{$solicitacao->requerente->endereco->bairro}}" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="rua">{{ __('Rua') }}</label>
                                    <input id="rua" class="form-control" type="text" name="rua" value="{{$solicitacao->requerente->endereco->rua}}" disabled>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="numero">{{ __('Número') }}</label>
                                    <input id="numero" class="form-control " type="text" name="numero" value="{{$solicitacao->requerente->endereco->numero}}" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="cidade">{{ __('Cidade') }}</label>
                                    <input id="cidade" class="form-control" type="text" name="cidade" value="Garanhuns" disabled>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="estado">{{ __('Estado') }}</label>
                                    <select id="estado" class="form-control" type="text" disabled name="estado">
                                        <option selected value="PE">Pernambuco</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="complemento">{{ __('Complemento') }}</label>
                                    <input class="form-control" value="{{$solicitacao->requerente->endereco->complemento}}" type="text" name="complemento" id="complemento" disabled/>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="mudas">{{ __('Mudas Solicitadas') }}</label>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="color: #212529">Espécie</th>
                                            <th scope="col" style="color: #212529; text-align: center">Quantidade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($solicitacao->mudasSolicitadas as $mudaSolicitada)
                                            <tr>
                                                <td >
                                                    {{$mudaSolicitada->especie->nome}}
                                                </td>
                                                <td style="text-align: center">
                                                    {{$mudaSolicitada->qtd_mudas}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="complemento">{{ __('Comentário') }}</label>
                                    <textarea class="form-control" type="text" disabled>{{$solicitacao->comentario}}
                                    </textarea>
                                </div>
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
                                    <div class="col-md-12">
                                        @if(isset($solicitacao->arquivo))
                                            <div style="margin-top: 20px; margin-bottom: 10px;">
                                                <a href="{{route('mudas.documento', ['id' => $solicitacao->id])}}" target="_new">Baixar solicitação</a>
                                            </div>
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
    @endsection
</x-app-layout>
@endguest
