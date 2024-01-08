<x-app-layout>
    @section('content')
        <div class="container-fluid"
             style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
            <div class="form-row justify-content-center">
                <div class="col-md-12">
                    <div class="form-row">
                        <div class="col-md-12">
                            <h4 class="card-title">Cadastrar um novo feirante</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-borda-esquerda" style="width: 100%;">
                        <div class="card-body">
                            <form id="create_feirante" method="POST" action="{{route('feirantes.store')}}">
                                @csrf
                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <label for="name">
                                            {{ __('Name') }} <span style="color: red; font-weight: bold;">*</span>
                                        </label>
                                        <input id="name" class="form-control @error('name') is-invalid @enderror"
                                               type="text" name="name" value="{{old('name')}}" required autofocus
                                               autocomplete="name" placeholder="Informe o nome completo">
                                        @error('name')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cpf">
                                            {{ __('CPF') }} <span style="color: red; font-weight: bold;">*</span>
                                        </label>
                                        <input id="cpf"
                                               class="form-control simple-field-data-mask @error('cpf') is-invalid @enderror"
                                               type="text" name="cpf" value="{{old('cpf')}}" data-mask="000.000.000-00"
                                               placeholder="000.000.000-00">
                                        @error('cpf')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="data_nascimento">
                                            {{ __('Data de Nascimento') }} <span style="color: red; font-weight: bold;">*</span>
                                        </label>
                                        <input id="data_nascimento" class="form-control @error('data_nascimento') is-invalid @enderror"
                                               type="date" name="data_nascimento" value="{{old('data_nascimento')}}">
                                        @error('data_nascimento')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-4 form-group">
                                        <label for="rg">
                                            {{ __('RG') }} <span style="color: red; font-weight: bold;">*</span>
                                        </label>
                                        <input id="rg" class="form-control @error('rg') is-invalid @enderror"
                                               type="text" name="rg" value="{{old('rg')}}"
                                               placeholder="Informe o número do RG">
                                        @error('rg')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="orgao_emissor">
                                            {{ __('Orgão emissor') }} <span style="color: red; font-weight: bold;">*</span>
                                        </label>
                                        <input id="orgao_emissor" class="form-control @error('orgao_emissor') is-invalid @enderror" type="text" name="orgao_emissor"
                                               value="{{old('orgao_emissor')}}"  placeholder="Informe o orgão emissor do RG">
                                        @error('orgao_emissor')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="celular">{{ __('Contato') }}<span
                                                style="color: red; font-weight: bold;">*</span></label>
                                        <input id="celular"
                                               class="form-control celular @error('celular') is-invalid @enderror"
                                               type="text" name="celular" value="{{old('celular')}}" required
                                               autocomplete="celular" placeholder="(00) 00000-0000">
                                        @error('celular')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
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
                                        <input id="cep" class="form-control cep @error('cep') is-invalid @enderror"
                                               type="text" name="cep" value="{{old('cep')}}" autofocus
                                               autocomplete="cep" onblur="pesquisacep(this.value);"
                                               placeholder="00000-000">
                                        <div class="col-md-12 text-right font-weight-bold">
                                            <a href="https://buscacepinter.correios.com.br/app/endereco/index.php"
                                               target="_blank">Não sei meu CEP</a>
                                        </div>
                                        @error('cep')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="bairro">{{ __('Bairro') }}</label>
                                        <input id="bairro" class="form-control @error('bairro') is-invalid @enderror"
                                               type="text" name="bairro" value="{{old('bairro')}}" autofocus
                                               autocomplete="bairro" placeholder="Informe o bairro">
                                        @error('bairro')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="rua">{{ __('Rua') }} <span
                                                style="color: red; font-weight: bold;">*</span></label>
                                        <input id="rua" class="form-control @error('rua') is-invalid @enderror"
                                               type="text" name="rua" value="{{old('rua')}}" autocomplete="rua" required
                                               placeholder="Informe o nome da rua">
                                        @error('rua')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="numero">{{ __('Número') }}</label>
                                        <input id="numero" class="form-control  @error('numero') is-invalid @enderror"
                                               type="text" name="numero" value="{{old('numero')}}" autocomplete="numero"
                                               placeholder="Informe o número da residência">
                                        @error('numero')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 form-group">
                                        <label for="complemento">{{ __('Complemento') }}</label>
                                        <input id="complemento" class="form-control @error('complemento') is-invalid @enderror" type="text" name="complemento" autofocus autocomplete="complemento" placeholder="Informe o complemento">
                                        @error('complemento')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="cidade">{{ __('Cidade') }}</label>
                                        <input id="cidade" class="form-control @error('cidade') is-invalid @enderror"
                                               type="text" name="cidade" value="Garanhuns" autofocus
                                               autocomplete="cidade" placeholder="Informe a cidade">
                                        @error('cidade')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="uf">{{ __('Estado') }}</label>
                                        <select id="uf" class="form-control @error('uf') is-invalid @enderror"
                                                type="text" autocomplete="estado" name="uf">
                                            <option value="" selected disabled>-- Selecione o Estado --</option>
                                            <option @if(old('uf') == 'AC') selected @endif value="AC">Acre</option>
                                            <option @if(old('uf') == 'AL') selected @endif value="AL">Alagoas</option>
                                            <option @if(old('uf') == 'AP') selected @endif value="AP">Amapá</option>
                                            <option @if(old('uf') == 'AM') selected @endif value="AM">Amazonas</option>
                                            <option @if(old('uf') == 'BA') selected @endif value="BA">Bahia</option>
                                            <option @if(old('uf') == 'CE') selected @endif value="CE">Ceará</option>
                                            <option @if(old('uf') == 'DF') selected @endif value="DF">Distrito Federal
                                            </option>
                                            <option @if(old('uf') == 'ES') selected @endif value="ES">Espírito Santo
                                            </option>
                                            <option @if(old('uf') == 'GO') selected @endif value="GO">Goiás</option>
                                            <option @if(old('uf') == 'MA') selected @endif value="MA">Maranhão</option>
                                            <option @if(old('uf') == 'MT') selected @endif value="MT">Mato Grosso
                                            </option>
                                            <option @if(old('uf') == 'MS') selected @endif value="MS">Mato Grosso do
                                                Sul
                                            </option>
                                            <option @if(old('uf') == 'MG') selected @endif value="MG">Minas Gerais
                                            </option>
                                            <option @if(old('uf') == 'PA') selected @endif value="PA">Pará</option>
                                            <option @if(old('uf') == 'PB') selected @endif value="PB">Paraíba</option>
                                            <option @if(old('uf') == 'PR') selected @endif value="PR">Paraná</option>
                                            <option @if(old('uf', 'PE') == 'PE') selected @endif value="PE">Pernambuco
                                            </option>
                                            <option @if(old('uf') == 'PI') selected @endif value="PI">Piauí</option>
                                            <option @if(old('uf') == 'RJ') selected @endif value="RJ">Rio de Janeiro
                                            </option>
                                            <option @if(old('uf') == 'RN') selected @endif value="RN">Rio Grande do
                                                Norte
                                            </option>
                                            <option @if(old('uf') == 'RS') selected @endif value="RS">Rio Grande do
                                                Sul
                                            </option>
                                            <option @if(old('uf') == 'RO') selected @endif value="RO">Rondônia</option>
                                            <option @if(old('uf') == 'RR') selected @endif value="RR">Roraima</option>
                                            <option @if(old('uf') == 'SC') selected @endif value="SC">Santa Catarina
                                            </option>
                                            <option @if(old('uf') == 'SP') selected @endif value="SP">São Paulo</option>
                                            <option @if(old('uf') == 'SE') selected @endif value="SE">Sergipe</option>
                                            <option @if(old('uf') == 'TO') selected @endif value="TO">Tocantins</option>
                                        </select>
                                        @error('uf')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
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
                                        <input id="cep_comercio" class="form-control cep @error('cep_comercio') is-invalid @enderror"
                                               type="text" name="cep_comercio" value="{{old('cep_comercio')}}" autofocus
                                               autocomplete="cep_comercio" onblur="pesquisaCepComercio(this.value);"
                                               placeholder="00000-000">
                                        <div class="col-md-12 text-right font-weight-bold">
                                            <a href="https://buscacepinter.correios.com.br/app/endereco/index.php"
                                               target="_blank">Não sei meu CEP</a>
                                        </div>
                                        @error('cep_comercio')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="bairro_comercio">{{ __('Bairro') }}</label>
                                        <input id="bairro_comercio" class="form-control @error('bairro_comercio') is-invalid @enderror"
                                               type="text" name="bairro_comercio" value="{{old('bairro_comercio')}}" autofocus
                                               autocomplete="bairro_comercio" placeholder="Informe o bairro">
                                        @error('bairro_comercio')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="rua_comercio">{{ __('Rua') }} <span
                                                style="color: red; font-weight: bold;">*</span></label>
                                        <input id="rua_comercio" class="form-control @error('rua_comercio') is-invalid @enderror"
                                               type="text" name="rua_comercio" value="{{old('rua_comercio')}}" autocomplete="rua_comercio" required
                                               placeholder="Informe o nome da rua">
                                        @error('rua_comercio')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="numero_comercio">{{ __('Número') }}</label>
                                        <input id="numero_comercio" class="form-control  @error('numero_comercio') is-invalid @enderror"
                                               type="text" name="numero_comercio" value="{{old('numero_comercio')}}" autocomplete="numero"
                                               placeholder="Informe o número">
                                        @error('numero')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 form-group">
                                        <label for="complemento_comercio">{{ __('Complemento') }}</label>
                                        <input id="complemento_comercio" class="form-control @error('complemento_comercio') is-invalid @enderror" type="text" name="complemento_comercio" autofocus autocomplete="complemento_comercio" placeholder="Informe o complemento">
                                        @error('complemento_comercio')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="cidade_comercio">{{ __('Cidade') }}</label>
                                        <input id="cidade_comercio" class="form-control @error('cidade_comercio') is-invalid @enderror"
                                               type="text" name="cidade_comercio" value="Garanhuns" autofocus
                                               autocomplete="cidade_comercio" placeholder="Informe a cidade">
                                        @error('cidade_comercio')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="uf_comercio">{{ __('Estado') }}</label>
                                        <select id="uf_comercio" class="form-control @error('uf_comercio') is-invalid @enderror"
                                                type="text" autocomplete="estado_comercio" name="uf_comercio">
                                            <option value="" selected disabled>-- Selecione o UF --</option>
                                            <option @if(old('uf_comercio') == 'AC') selected @endif value="AC">Acre</option>
                                            <option @if(old('uf_comercio') == 'AL') selected @endif value="AL">Alagoas</option>
                                            <option @if(old('uf_comercio') == 'AP') selected @endif value="AP">Amapá</option>
                                            <option @if(old('uf_comercio') == 'AM') selected @endif value="AM">Amazonas</option>
                                            <option @if(old('uf_comercio') == 'BA') selected @endif value="BA">Bahia</option>
                                            <option @if(old('uf_comercio') == 'CE') selected @endif value="CE">Ceará</option>
                                            <option @if(old('uf_comercio') == 'DF') selected @endif value="DF">Distrito Federal
                                            </option>
                                            <option @if(old('uf_comercio') == 'ES') selected @endif value="ES">Espírito Santo
                                            </option>
                                            <option @if(old('uf_comercio') == 'GO') selected @endif value="GO">Goiás</option>
                                            <option @if(old('uf_comercio') == 'MA') selected @endif value="MA">Maranhão</option>
                                            <option @if(old('uf_comercio') == 'MT') selected @endif value="MT">Mato Grosso
                                            </option>
                                            <option @if(old('uf_comercio') == 'MS') selected @endif value="MS">Mato Grosso do
                                                Sul
                                            </option>
                                            <option @if(old('uf_comercio') == 'MG') selected @endif value="MG">Minas Gerais
                                            </option>
                                            <option @if(old('uf_comercio') == 'PA') selected @endif value="PA">Pará</option>
                                            <option @if(old('uf_comercio') == 'PB') selected @endif value="PB">Paraíba</option>
                                            <option @if(old('uf_comercio') == 'PR') selected @endif value="PR">Paraná</option>
                                            <option @if(old('uf_comercio', 'PE') == 'PE') selected @endif value="PE">Pernambuco
                                            </option>
                                            <option @if(old('uf_comercio') == 'PI') selected @endif value="PI">Piauí</option>
                                            <option @if(old('uf_comercio') == 'RJ') selected @endif value="RJ">Rio de Janeiro
                                            </option>
                                            <option @if(old('uf_comercio') == 'RN') selected @endif value="RN">Rio Grande do
                                                Norte
                                            </option>
                                            <option @if(old('uf_comercio') == 'RS') selected @endif value="RS">Rio Grande do
                                                Sul
                                            </option>
                                            <option @if(old('uf_comercio') == 'RO') selected @endif value="RO">Rondônia</option>
                                            <option @if(old('uf_comercio') == 'RR') selected @endif value="RR">Roraima</option>
                                            <option @if(old('uf_comercio') == 'SC') selected @endif value="SC">Santa Catarina
                                            </option>
                                            <option @if(old('uf_comercio') == 'SP') selected @endif value="SP">São Paulo</option>
                                            <option @if(old('uf_comercio') == 'SE') selected @endif value="SE">Sergipe</option>
                                            <option @if(old('uf_comercio') == 'TO') selected @endif value="TO">Tocantins</option>
                                        </select>
                                        @error('uf_comercio')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="divisor">

                                <div class="form-row">
                                    <div class="col-md-4 form-group">
                                        <label for="atividade_comercial">
                                            {{ __('Atividade Comercial/Produto') }} <span style="color: red; font-weight: bold;">*</span>
                                        </label>
                                        <input id="atividade_comercial" class="form-control @error('atividade_comercial') is-invalid @enderror"
                                               type="text" name="atividade_comercial" value="{{old('atividade_comercial')}}"
                                               placeholder="Informe a atividade comercial/produto">
                                        @error('atividade_comercial')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="residuos_gerados">{{ __('Resíduos Gerados') }}<span
                                                style="color: red; font-weight: bold;">*</span></label>
                                        <input id="residuos_gerados"
                                               class="form-control @error('residuos_gerados') is-invalid @enderror"
                                               type="text" name="residuos_gerados" value="{{old('residuos_gerados')}}" required
                                               autocomplete="residuos_gerados" placeholder="Informe os resíduos que são gerados">
                                        @error('residuos_gerados')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="protocolo_vigilancia_sanitaria">
                                            {{ __('Protocolo Vigilância Sanitária') }} <span style="color: red; font-weight: bold;">*</span>
                                        </label>
                                        <input id="protocolo_vigilancia_sanitaria" class="form-control @error('protocolo_vigilancia_sanitaria') is-invalid @enderror"
                                               type="text" name="protocolo_vigilancia_sanitaria" value="{{old('protocolo_vigilancia_sanitaria')}}"  placeholder="Informe o protocolo da vigilância sanitária">
                                        @error('protocolo_vigilancia_sanitaria')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <div class="form-row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6" style="text-align: right">
                                    <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao"
                                            form="create_feirante" style="width: 100%">Salvar
                                    </button>
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

                function limpa_formulário_cep() {
                    //Limpa valores do formulário de cep.
                    document.getElementById('rua').value = ("");
                    document.getElementById('bairro').value = ("");
                    document.getElementById('cidade').value = ("");
                    document.getElementById('uf').value = ("");
                }

                function limpa_formulário_cep_comercio() {
                    //Limpa valores do formulário de cep.
                    document.getElementById('rua_comercio').value = ("");
                    document.getElementById('bairro_comercio').value = ("");
                    document.getElementById('cidade_comercio').value = ("");
                    document.getElementById('uf_comercio').value = ("");
                }

                function meu_callback(conteudo) {
                    if (!("erro" in conteudo)) {
                        //Atualiza os campos com os valores.
                        document.getElementById('rua').value = (conteudo.logradouro);
                        document.getElementById('bairro').value = (conteudo.bairro);
                        document.getElementById('cidade').value = (conteudo.localidade);
                        document.getElementById('uf').value = (conteudo.uf);
                    } //end if.
                    else {
                        //CEP não Encontrado.
                        limpa_formulário_cep();
                        // exibirModalCep();
                    }
                }

                function meu_callback_comercio(conteudo) {
                    if (!("erro" in conteudo)) {
                        //Atualiza os campos com os valores.
                        document.getElementById('rua_comercio').value = (conteudo.logradouro);
                        document.getElementById('bairro_comercio').value = (conteudo.bairro);
                        document.getElementById('cidade_comercio').value = (conteudo.localidade);
                        document.getElementById('uf_comercio').value = (conteudo.uf);
                    } //end if.
                    else {
                        //CEP não Encontrado.
                        limpa_formulário_cep_comercio();
                        // exibirModalCep();
                    }
                }

                function pesquisacep(valor) {
                    //Nova variável "cep" somente com dígitos.
                    var cep = valor.replace(/\D/g, '');
                    //Verifica se campo cep possui valor informado.
                    if (cep != "") {
                        //Expressão regular para validar o CEP.
                        var validacep = /^[0-9]{8}$/;
                        //Valida o formato do CEP.
                        if (validacep.test(cep)) {
                            //Preenche os campos com "..." enquanto consulta webservice.
                            document.getElementById('rua').value = "...";
                            document.getElementById('bairro').value = "...";
                            //Cria um elemento javascript.
                            var script = document.createElement('script');
                            //Sincroniza com o callback.
                            script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';
                            //Insere script no documento e carrega o conteúdo.
                            document.body.appendChild(script);
                        } //end if.
                        else {
                            //cep é inválido.
                            limpa_formulário_cep();
                            exibirModalCepInvalido();
                            ;
                        }
                    } //end if.
                    else {
                        //cep sem valor, limpa formulário.
                        limpa_formulário_cep();
                    }
                }

                function pesquisaCepComercio(valor) {
                    //Nova variável "cep" somente com dígitos.
                    var cep = valor.replace(/\D/g, '');
                    //Verifica se campo cep possui valor informado.
                    if (cep != "") {
                        //Expressão regular para validar o CEP.
                        var validacep = /^[0-9]{8}$/;
                        //Valida o formato do CEP.
                        if (validacep.test(cep)) {
                            //Preenche os campos com "..." enquanto consulta webservice.
                            document.getElementById('rua_comercio').value = "...";
                            document.getElementById('bairro_comercio').value = "...";
                            //Cria um elemento javascript.
                            var script = document.createElement('script');
                            //Sincroniza com o callback.
                            script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback_comercio';
                            //Insere script no documento e carrega o conteúdo.
                            document.body.appendChild(script);
                        } //end if.
                        else {
                            //cep é inválido.
                            limpa_formulário_cep_comercio();
                            exibirModalCepInvalido();
                            ;
                        }
                    } //end if.
                    else {
                        //cep sem valor, limpa formulário.
                        limpa_formulário_cep_comercio();
                    }
                }

                function exibirModal() {
                    $('#btn-modal-aviso').click();
                }

                function exibirModalCep() {
                    $('#btn-modal-cep-nao-encontrado').click();
                }

                function exibirModalCepInvalido() {
                    $('#btn-modal-cep-invalido').click();
                }
            </script>
            @endpush
            @endsection
</x-app-layout>
