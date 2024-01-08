<x-app-layout>
    @section('content')
        <div class="container-fluid"
             style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
            <div class="form-row justify-content-center">
                <div class="col-md-12">
                    <div class="form-row">
                        <div class="col-md-12">
                            <h4 class="card-title">Informações do Feirante</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-borda-esquerda" style="width: 100%;">
                        <div class="card-body">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="name">
                                        {{ __('Name') }} <span style="color: red; font-weight: bold;">*</span>
                                    </label>
                                    <input class="form-control" type="text" name="name" value="{{ $feirante->nome }}"
                                           readonly>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="cpf">
                                        {{ __('CPF') }} <span style="color: red; font-weight: bold;">*</span>
                                    </label>
                                    <input id="cpf" class="form-control" type="text" name="cpf"
                                           value="{{ $feirante->cpf }}" readonly>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="data_nascimento">
                                        {{ __('Data de Nascimento') }} <span
                                            style="color: red; font-weight: bold;">*</span>
                                    </label>
                                    <input class="form-control" type="date" name="data_nascimento"
                                           value="{{ $feirante->data_nascimento }}" readonly>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 form-group">
                                    <label for="rg">
                                        {{ __('RG') }} <span style="color: red; font-weight: bold;">*</span>
                                    </label>
                                    <input class="form-control" type="text" name="rg" value="{{ $feirante->rg }}"
                                           readonly>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="orgao_emissor">
                                        {{ __('Orgão emissor') }} <span
                                            style="color: red; font-weight: bold;">*</span>
                                    </label>
                                    <input class="form-control" type="text" name="orgao_emissor"
                                           value="{{ $feirante->orgao_emissor }}" readonly>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="celular">{{ __('Contato') }}<span
                                            style="color: red; font-weight: bold;">*</span></label>
                                    <input class="form-control" type="text" name="celular"
                                           value="{{ $telefone->numero }}" readonly>
                                </div>
                            </div>

                            <hr class="divisor">

                            <div class="form-row">
                                <div class="col-md-6">
                                    <h5 class="card-title">Endereço Residencial</h5>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="cep">{{ __('CEP') }}</label>
                                    <input class="form-control" type="text" name="cep"
                                           value="{{ $endereco_residencia->cep }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="bairro">{{ __('Bairro') }}</label>
                                    <input class="form-control" type="text" name="bairro"
                                           value="{{ $endereco_residencia->bairro }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="rua">{{ __('Rua') }} <span
                                            style="color: red; font-weight: bold;">*</span></label>
                                    <input class="form-control" type="text" name="rua"
                                           value="{{ $endereco_residencia->rua }}" readonly>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="numero">{{ __('Número') }}</label>
                                    <input class="form-control" type="text" name="numero"
                                           value="{{ $endereco_residencia->numero }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 form-group">
                                    <label for="complemento">{{ __('Complemento') }}</label>
                                    <input class="form-control" type="text" name="complemento"
                                           value="{{ $endereco_residencia->complemento }}" readonly>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="cidade">{{ __('Cidade') }}</label>
                                    <input class="form-control" type="text" name="cidade"
                                           value="{{ $endereco_residencia->cidade }}" readonly>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="uf">{{ __('Estado') }}</label>
                                    <input id="uf" class="form-control" type="text" name="uf"
                                           value="{{$endereco_residencia->estado}}" readonly>
                                </div>
                            </div>

                            <hr class="divisor">

                            <div class="form-row">
                                <div class="col-md-6">
                                    <h5 class="card-title">Localização do Comércio</h5>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="cep_comercio">{{ __('CEP') }}</label>
                                    <input class="form-control" type="text" name="cep_comercio"
                                           value="{{ $endereco_comercio->cep }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="bairro_comercio">{{ __('Bairro') }}</label>
                                    <input class="form-control" type="text" name="bairro_comercio"
                                           value="{{ $endereco_comercio->bairro }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="rua_comercio">{{ __('Rua') }} <span
                                            style="color: red; font-weight: bold;">*</span></label>
                                    <input id="rua_comercio" class="form-control" type="text" name="rua_comercio"
                                           value="{{ $endereco_comercio->rua }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="numero_comercio">{{ __('Número') }}</label>
                                    <input class="form-control" type="text" name="numero_comercio"
                                           value="{{ $endereco_comercio->numero}}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 form-group">
                                    <label for="complemento_comercio">{{ __('Complemento') }}</label>
                                    <input class="form-control" type="text" name="complemento_comercio"
                                           value="{{ $endereco_comercio->complemento }}" readonly>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="cidade_comercio">{{ __('Cidade') }}</label>
                                    <input id="cidade_comercio"
                                           class="form-control @error('cidade_comercio') is-invalid @enderror"
                                           type="text" name="cidade_comercio" value="{{ $endereco_comercio->cidade }}"
                                           readonly>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="uf">{{ __('Estado') }}</label>
                                    <input id="uf" class="form-control" type="text" name="uf"
                                           value="{{$endereco_comercio->estado}}" readonly>
                                </div>
                            </div>

                            <hr class="divisor">

                            <div class="form-row">
                                <div class="col-md-4 form-group">
                                    <label for="atividade_comercial">
                                        {{ __('Atividade Comercial/Produto') }} <span
                                            style="color: red; font-weight: bold;">*</span>
                                    </label>
                                    <input class="form-control" type="text" name="atividade_comercial"
                                           value="{{ $feirante->atividade_comercial }}" readonly>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="residuos_gerados">{{ __('Resíduos Gerados') }}<span
                                            style="color: red; font-weight: bold;">*</span></label>
                                    <input class="form-control" name="residuos_gerados"
                                           value="{{ $feirante->residuos_gerados }}" readonly>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="protocolo_vigilancia_sanitaria">
                                        {{ __('Protocolo Vigilância Sanitária') }} <span
                                            style="color: red; font-weight: bold;">*</span>
                                    </label>
                                    <input class="form-control" type="text" name="protocolo_vigilancia_sanitaria"
                                           value="{{ $feirante->protocolo_vigilancia_sanitaria }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @push ('scripts')
            <script>
                $(document).ready(function ($) {
                    $('#cpf').mask('000.000.000-00');
                    $('#rg').mask('00000000');
                    $('#cnpj').mask('00.000.000/0000-00');
                    var SPMaskBehavior = function (val) {
                            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                        },
                        spOptions = {
                            onKeyPress: function (val, e, field, options) {
                                field.mask(SPMaskBehavior.apply({}, arguments), options);
                            }
                        };
                    $('.celular').mask(SPMaskBehavior, spOptions);
                    $('.cep').mask('00000-000');
                    $(".apenas_letras").mask("#", {
                        maxlength: true,
                        translation: {
                            '#': {pattern: /^[A-Za-záâãéêíóôõúçÁÂÃÉÊÍÓÔÕÚÇ\s]+$/, recursive: true}
                        }
                    });
                });
            </script>
        @endpush
    @endsection
</x-app-layout>
