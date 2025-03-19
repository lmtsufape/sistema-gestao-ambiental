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
                                    <label for="beneficiario">{{ __('Beneficiário') }}</label>
                                    <input id="beneficiario" class="form-control" type="string" name="beneficiario" value="{{ $aracao->beneficiario->nome }}" readonly>
                                </div>
                            </div>

                            <hr class="divisor">
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="distrito">{{ __('Distrito') }}</label>
                                        <input id="distrito" class="form-control" type="string" name="distrito" value="{{ $aracao->beneficiario->endereco->distrito }}" readonly>
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="comunidade">{{ __('Comunidade') }}</label>
                                        <input id="comunidade" class="form-control" type="string" name="comunidade" value="{{ $aracao->beneficiario->endereco->comunidade }}" readonly>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="numero">{{ __('Número') }}</label>
                                        <input id="numero" class="form-control" type="string" name="numero" value="{{ $aracao->beneficiario->endereco->numero }}" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cidade">{{ __('Cidade') }}</label>
                                        <input id="cidade" class="form-control" type="string" name="cidade" value="{{ $aracao->beneficiario->endereco->cidade }}" readonly>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="uf">{{ __('Estado') }}</label>
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
</x-app-layout>
