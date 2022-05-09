<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8" style="padding-top: 15px;">
                        <h4 class="card-title">Avaliar solicitação de muda {{$solicitacao->protocolo}}</h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="card-subtitle mb-2 text-muted" href="javascript:window.history.back();">Mudas</a> > Avaliar solicitação de muda {{$solicitacao->protocolo}}</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        <a class="btn my-2" href="javascript:window.history.back();" style="cursor: pointer;"><img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}"  alt="Voltar" title="Voltar"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">

                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="nome">Nome</label>
                                <input id="nome" class="form-control" type="text" name="nome"
                                    value="{{ $solicitacao->requerente->user->name }}" autocomplete="nome" disabled>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="email">E-mail</label>
                                <input id="email" class="form-control" type="text" name="email"
                                    value="{{ $solicitacao->requerente->user->email }}" autocomplete="email" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="cpf">{{ __('CPF') }}</label>
                                <input id="cpf" class="form-control simple-field-data-mask" type="text" name="cpf"
                                    value="{{ $solicitacao->requerente->cpf }}" autofocus autocomplete="cpf"
                                    data-mask="000.000.000-00" disabled>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="cep">{{ __('CEP') }}</label>
                                <input id="cep" class="form-control cep" type="text" name="cep" value="{{$solicitacao->requerente->endereco->cep}}" disabled>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="bairro">{{ __('Bairro') }}</label>
                                <input id="bairro" class="form-control" type="text" name="bairro" value="{{$solicitacao->requerente->endereco->bairro}}" disabled>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="rua">{{ __('Rua') }}</label>
                                <input id="rua" class="form-control" type="text" name="rua" value="{{$solicitacao->requerente->endereco->rua}}" disabled>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="numero">{{ __('Número') }}</label>
                                <input id="numero" class="form-control " type="text" name="numero" value="{{$solicitacao->requerente->endereco->numero}}" disabled>
                            </div>
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
                                        <th scope="col" style="color: black">Espécie</th>
                                        <th scope="col" style="color: black; text-align: center">Quantidade</th>
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
                                <label for="comentario">{{ __('Comentário') }}</label>
                                <textarea id="comentario" class="form-control" type="text" name="comentario" value="Garanhuns" disabled>{{$solicitacao->comentario}}
                                </textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6" >
                                <button type="button" class="btn btn-secondary" style="width: 100%" data-toggle="modal" data-target="#modalIndeferir">Indeferir</button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-success btn-color-dafault" style="width: 100%" data-toggle="modal" data-target="#modalDeferir">Deferir</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalDeferir" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #278b45;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Tem certeza que deseja deferir a solicitação de muda?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="deferir-solicitacao" method="POST" enctype="multipart/form-data" action="{{ route('mudas.avaliar', $solicitacao) }}">
                        @method('PUT')
                        @csrf
                        <input id="status" type="hidden" name="status" value="{{ \App\Models\SolicitacaoMuda::STATUS_ENUM['deferido'] }}">
                        <input type="file" name="arquivo" id="arquivo">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" form="deferir-solicitacao">Continuar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalIndeferir" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #278b45;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Tem certeza que deseja indeferir a solicitação da muda?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="status-solicitacao" method="POST" action="{{ route('mudas.avaliar', $solicitacao) }}">
                        @method('PUT')
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <input id="status" type="hidden" name="status" value="{{ \App\Models\SolicitacaoMuda::STATUS_ENUM['indeferido'] }}">
                                <label for="motivo_indeferimento">Motivo<span style="color: red; font-weight: bold;">*</span></label>
                                <textarea id="motivo_indeferimento" class="form-control @error('motivo_indeferimento') is-invalid @enderror"
                                    name="motivo_indeferimento"
                                    autocomplete="motivo_indeferimento">{{old('motivo_indeferimento')}}</textarea>

                                @error('motivo_indeferimento')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" form="status-solicitacao">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    @if(count($errors) > 0)
        <script>
            $(function() {
                jQuery.noConflict();
                $('#modalIndeferir').modal('show');
            });
        </script>
    @endif
    @endsection
</x-app-layout>
