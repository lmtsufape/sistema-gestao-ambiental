<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-12">
                        <h4 class="card-title">Informações da aração</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-borda-esquerda" style="width: 100%;">
                    <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="cultura">{{ __('Cultura') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="cultura" class="form-control" type="string" name="cultura" value="{{ $aracao->cultura }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="ponto_localizacao">{{ __('Ponto de Localização') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="ponto_localizacao" class="form-control" type="string" name="ponto_localizacao" value="{{ $aracao->ponto_localizacao }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="quantidade_horas">{{ __('Quantidade de Horas') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="quantidade_horas" class="form-control" type="string" name="quantidade_horas" value="{{ $aracao->quantidade_horas }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="quantidade_horas">{{ __('Quantidade de Ha') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="quantidade_horas" class="form-control" type="string" name="quantidade_horas" value="{{ $aracao->quantidade_horas }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="beneficiario">{{ __('Beneficiário') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="beneficiario" class="form-control" type="string" name="beneficiario" value="{{ $aracao->beneficiario->nome }}" readonly>
                                </div>
                            </div>
                            
                            <hr class="divisor">
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cep">{{ __('CEP') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="cep" class="form-control" type="string" name="cep" value="{{ $aracao->beneficiario->endereco->cep }}" readonly>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="bairro">{{ __('Bairro') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="bairro" class="form-control" type="string" name="bairro" value="{{ $aracao->beneficiario->endereco->bairro }}" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="rua">{{ __('Rua') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="rua" class="form-control" type="string" name="rua" value="{{ $aracao->beneficiario->endereco->rua }}" readonly>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="numero">{{ __('Número') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="numero" class="form-control" type="string" name="numero" value="{{ $aracao->beneficiario->endereco->numero }}" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cidade">{{ __('Cidade') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="cidade" class="form-control" type="string" name="cidade" value="{{ $aracao->beneficiario->endereco->cidade }}" readonly>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="uf">{{ __('Estado') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="uf" class="form-control" type="string" name="uf" value="{{ $aracao->beneficiario->endereco->estado }}" readonly>
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
