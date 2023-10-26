<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-12">
                        <h4 class="card-title">Informações do Beneficiário</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-borda-esquerda" style="width: 100%;">
                    <div class="card-body">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input id="name" class="form-control" type="text" name="name" value="{{ $beneficiario->nome }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="nis">{{ __('NIS') }}</label>
                                    <input id="nis" class="form-control" type="string" name="nis" value="{{ $beneficiario->nis }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="quantidade_pessoas">{{ __('Quantidade de pessoas') }}</label>
                                    <input id="quantidade_pessoas" class="form-control" type="number" name="quantidade_pessoas" value="{{ $beneficiario->quantidade_pessoas }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="cpf">{{ __('CPF') }}</label>
                                    <input id="cpf" class="form-control" type="text" name="cpf" value="{{$beneficiario->cpf}}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="celular">{{ __('Contato') }}</label>
                                    <input id="celular" class="form-control" type="text" name="celular" value="{{$beneficiario->telefone->numero}}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="rg">{{ __('RG') }}</label>
                                    <input id="rg" class="form-control" type="text" name="rg" value="{{$beneficiario->rg}}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="orgao_emissor">{{ __('Orgão emissor') }}</label>
                                    <input id="orgao_emissor" class="form-control" type="text" name="orgao_emissor" value="{{$beneficiario->orgao_emissor}}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="codigo">{{ __('Código do Beneficiário') }}</label>
                                    <input id="codigo" class="form-control @error('codigo') is-invalid @enderror" type="text" name="codigo" value="{{$beneficiario->codigo}}" readonly>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label for="tipo_beneficiario">{{ __('Tipo do Beneficiário') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input 
                                        id="tipo_beneficiario" 
                                        class="form-control @error('tipo_beneficiario') is-invalid @enderror" 
                                        type="text" 
                                        name="tipo_beneficiario" 
                                        value="{{ $beneficiario->tipo_beneficiario == \App\Models\Beneficiario::ROLE_ENUM['aracao'] ? 'Aração' : ($beneficiario->tipo_beneficiario == \App\Models\Beneficiario::ROLE_ENUM['carro_pipa'] ? 'Carro Pipa' : 'Ambos') }}" 
                                        readonly>
                                </div>
                            </div>
                            <hr class="divisor">
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="cep">{{ __('CEP') }}</label>
                                    <input id="cep" class="form-control" type="text" name="cep" value="{{$beneficiario->endereco->cep}}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="bairro">{{ __('Bairro') }}</label>
                                    <input id="bairro" class="form-control" type="text" name="bairro" value="{{$beneficiario->endereco->bairro}}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="rua">{{ __('Rua') }}</label>
                                    <input id="rua" class="form-control" type="text" name="rua" value="{{$beneficiario->endereco->rua}}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="numero">{{ __('Número') }}</label>
                                    <input id="numero" class="form-control" type="text" name="número" value="{{$beneficiario->endereco->numero}}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="cidade">{{ __('Cidade') }}</label>
                                    <input id="cidade" class="form-control" type="text" name="cidade" value="{{$beneficiario->endereco->cidade}}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="uf">{{ __('Estado') }}</label>
                                    <input id="uf" class="form-control" type="text" name="uf" value="{{$beneficiario->endereco->estado}}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="observacao">{{ __('Observação') }}</label>
                                    <textarea class="form-control" type="text" name="observacao" id="observacao" cols="30" rows="5" readonly>{{$beneficiario->observacao}}</textarea>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push ('scripts')
        <script>
            $(document).ready(function($) {
                $('#cpf').mask('000.000.000-00');
                $('#rg').mask('00000000');
                $('#cnpj').mask('00.000.000/0000-00');
                var SPMaskBehavior = function(val) {
                    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                },
                spOptions = {
                    onKeyPress: function(val, e, field, options) {
                        field.mask(SPMaskBehavior.apply({}, arguments), options);
                    }
                };
                $('.celular').mask(SPMaskBehavior, spOptions);
                $('.cep').mask('00000-000');
                $(".apenas_letras").mask("#", {
                    maxlength: true,
                    translation: {
                        '#': { pattern: /^[A-Za-záâãéêíóôõúçÁÂÃÉÊÍÓÔÕÚÇ\s]+$/, recursive: true }
                    }
                });
            });
        </script>
    @endpush
    @endsection
</x-app-layout>