<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-12">
                        <h4 class="card-title">Informações do serviço</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-borda-esquerda" style="width: 100%;">
                    <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="data_solicitacao">{{ __('Data da Solicitação') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="data_solicitacao" class="form-control" type="date" name="data_solicitacao" value="{{ $solicitacao_servico->data_solicitacao }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="cpf">{{ __('Data da saída') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="data_saida" class="form-control" type="date" name="data_saida" value="{{ $solicitacao_servico->data_saida }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="data_entrega">{{ __('Data de entrega') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="data_entrega" class="form-control" type="date" name="data_entrega" value="{{ $solicitacao_servico->data_entrega }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="beneficiario">{{ __('Beneficiário') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="beneficiario" class="form-control" type="string" name="beneficiario" value="{{ $solicitacao_servico->beneficiario->nome }}" readonly>
                                </div>
                            </div>
                            <hr class="divisor">
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cep">{{ __('CEP') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="cep" class="form-control" type="string" name="cep" value="{{ $solicitacao_servico->beneficiario->endereco->cep }}" readonly>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="bairro">{{ __('Bairro') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="bairro" class="form-control" type="string" name="bairro" value="{{ $solicitacao_servico->beneficiario->endereco->bairro }}" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="rua">{{ __('Rua') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="rua" class="form-control" type="string" name="rua" value="{{ $solicitacao_servico->beneficiario->endereco->rua }}" readonly>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="numero">{{ __('Número') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="numero" class="form-control" type="string" name="numero" value="{{ $solicitacao_servico->beneficiario->endereco->numero }}" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cidade">{{ __('Cidade') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="cidade" class="form-control" type="string" name="cidade" value="{{ $solicitacao_servico->beneficiario->endereco->cidade }}" readonly>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="uf">{{ __('Estado') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="uf" class="form-control" type="string" name="uf" value="{{ $solicitacao_servico->beneficiario->endereco->estado }}" readonly>
                                    </div>
                                </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="observacao">{{ __('Observação') }}</label>
                                    <input id="observacao" class="form-control" type="string" name="observacao" value="{{ $solicitacao_servico->observacao }}" readonly>
                                </div>
                            </div>
                    </div>
                    <div class="card-footer">
                            <div class="col-md-5" style="text-align: center"></div>
                                <button data-toggle="modal" data-target="#modalStaticAtribuirDataEntrega_{{$solicitacao_servico->id}}" type="button" class="btn btn-success btn-color-dafault submeterFormBotao" style="width: 100%">Atribuir data de entrega</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalStaticAtribuirDataEntrega_{{$solicitacao_servico->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #00883D;">
                                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Data de Entrega</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="atualizar_data_entrega" method="POST" action="{{route('solicitacao_servicos.AtualizarDataEntrega', ['id' => $solicitacao_servico->id])}}">
                                        @csrf
                                        @method('PUT')
                                        <input type="date" name="data_entrega" class="form-control" required>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" form="atualizar_data_entrega">Atualizar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @push ('scripts')
        <script>
            
        </script>
    @endpush --}}
@endsection
</x-guest-layout>
