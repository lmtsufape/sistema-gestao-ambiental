<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-12">
                        <h4 class="card-title">Cadastrar um novo Beneficiário</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-borda-esquerda" style="width: 100%;">
                    <div class="card-body">
                    <form id="create-beneficiario" method="POST" action="{{route('beneficiarios.store')}}">
                            @csrf
                            <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <label for="name">{{ __('Name') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{old('name')}}" required autofocus autocomplete="name" placeholder="Digite seu nome aqui...">
                                        @error('name')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="nis">{{ __('NIS') }}</label>
                                        <input id="nis" class="form-control @error('nis') is-invalid @enderror" type="string" name="nis" value="{{old('nis')}}" placeholder="Digite seu NIS aqui...">
                                        @error('nis')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="quantidade_pessoas">{{ __('Quantidade de pessoas') }}</label>
                                        <input id="quantidade_pessoas" class="form-control @error('quantidade_pessoas') is-invalid @enderror" type="number" name="quantidade_pessoas" value="{{old('quantidade_pessoas')}}" autofocus autocomplete="quantidade_pessoas" placeholder="Digite a quantidade de pessoas que moram com você...">
                                        @error('quantidade_pessoas')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cpf">{{ __('CPF') }}</label>
                                        <input id="cpf" class="form-control simple-field-data-mask @error('cpf') is-invalid @enderror" type="text" name="cpf" value="{{old('cpf')}}"  data-mask="000.000.000-00" placeholder="000.000.000-00">
                                        @error('cpf')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="celular">{{ __('Contato') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="celular" class="form-control celular @error('celular') is-invalid @enderror" type="text" name="celular" value="{{old('celular')}}" required autocomplete="celular" placeholder="(00) 00000-0000">
                                        @error('celular')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="rg">{{ __('RG') }}</label>
                                        <input id="rg" class="form-control @error('rg') is-invalid @enderror" type="text" name="rg" value="{{old('rg')}}"  placeholder="Digite o número de seu RG...">
                                        @error('rg')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="orgao_emissor">{{ __('Orgão emissor') }}</label>
                                        <input id="orgao_emissor" class="form-control @error('orgao_emissor') is-invalid @enderror" type="text" name="orgao_emissor" value="{{old('orgao_emissor')}}"  placeholder="O orgão emissor do RG...">
                                        @error('orgao_emissor')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="codigo">{{ __('Código do Beneficiário') }}</label>
                                        <input id="codigo" class="form-control @error('codigo') is-invalid @enderror" type="text" name="codigo" value="{{old('codigo')}}" autofocus autocomplete="codigo" placeholder="Digite o código do beneficiário...">
                                        @error('codigo')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="tipo_beneficiario">{{ __('Tipo do Beneficiário') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <select name="tipo_beneficiario" id="tipo_beneficiario">
                                            <option value="" disabled>-- {{__('Selecione o Tipo de Beneficiário')}} --</option>
                                            <option value="0">Aração</option>
                                            <option value="1">Carro Pipa</option>
                                            <option value="2">Ambos</option>
                                        </select>
                                    </div>
                                </div>
                                <hr class="divisor">
                                <div class="form-row">

                                    <div class="col-md-6 form-group">
                                        <label for="distrito">{{ __('Distrito') }}</label>
                                        <input id="distrito" class="form-control @error('distrito') is-invalid @enderror" type="text" name="distrito" value="{{old('distrito')}}" autofocus autocomplete="distrito" placeholder="Digite o distrito onde mora...">
                                        @error('distrito')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="comunidade">{{ __('Comunidade') }} </label>
                                        <input id="comunidade" class="form-control @error('comunidade') is-invalid @enderror" type="text" name="comunidade" value="{{old('comunidade')}}" autocomplete="comunidade"  placeholder="Digite a comunidade onde mora...">
                                        @error('comunidade')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="numero">{{ __('Número') }}</label>
                                        <input id="numero" class="form-control  @error('numero') is-invalid @enderror" type="text" name="numero" value="{{old('numero')}}" autocomplete="numero" placeholder="Digite o número de sua casa...">
                                        @error('numero')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cidade">{{ __('Cidade') }}</label>
                                        <input id="cidade" class="form-control @error('cidade') is-invalid @enderror" type="text" name="cidade" value="Garanhuns" autofocus autocomplete="cidade" placeholder="Digite a cidade que mora...">
                                        @error('cidade')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="uf">{{ __('Estado') }}</label>
                                        <select id="uf" class="form-control @error('uf') is-invalid @enderror" type="text" autocomplete="estado" name="uf">
                                            <option value="" selected disabled >-- Selecione o UF --</option>
                                            <option @if(old('uf') == 'AC') selected @endif value="AC">Acre</option>
                                            <option @if(old('uf') == 'AL') selected @endif value="AL">Alagoas</option>
                                            <option @if(old('uf') == 'AP') selected @endif value="AP">Amapá</option>
                                            <option @if(old('uf') == 'AM') selected @endif value="AM">Amazonas</option>
                                            <option @if(old('uf') == 'BA') selected @endif value="BA">Bahia</option>
                                            <option @if(old('uf') == 'CE') selected @endif value="CE">Ceará</option>
                                            <option @if(old('uf') == 'DF') selected @endif value="DF">Distrito Federal</option>
                                            <option @if(old('uf') == 'ES') selected @endif value="ES">Espírito Santo</option>
                                            <option @if(old('uf') == 'GO') selected @endif value="GO">Goiás</option>
                                            <option @if(old('uf') == 'MA') selected @endif value="MA">Maranhão</option>
                                            <option @if(old('uf') == 'MT') selected @endif value="MT">Mato Grosso</option>
                                            <option @if(old('uf') == 'MS') selected @endif value="MS">Mato Grosso do Sul</option>
                                            <option @if(old('uf') == 'MG') selected @endif value="MG">Minas Gerais</option>
                                            <option @if(old('uf') == 'PA') selected @endif value="PA">Pará</option>
                                            <option @if(old('uf') == 'PB') selected @endif value="PB">Paraíba</option>
                                            <option @if(old('uf') == 'PR') selected @endif value="PR">Paraná</option>
                                            <option @if(old('uf', 'PE') == 'PE') selected @endif value="PE">Pernambuco</option>
                                            <option @if(old('uf') == 'PI') selected @endif value="PI">Piauí</option>
                                            <option @if(old('uf') == 'RJ') selected @endif value="RJ">Rio de Janeiro</option>
                                            <option @if(old('uf') == 'RN') selected @endif value="RN">Rio Grande do Norte</option>
                                            <option @if(old('uf') == 'RS') selected @endif value="RS">Rio Grande do Sul</option>
                                            <option @if(old('uf') == 'RO') selected @endif value="RO">Rondônia</option>
                                            <option @if(old('uf') == 'RR') selected @endif value="RR">Roraima</option>
                                            <option @if(old('uf') == 'SC') selected @endif value="SC">Santa Catarina</option>
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
                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <label for="observacao">{{ __('Observação') }}</label>
                                        <textarea class="form-control @error('observacao') is-invalid @enderror" type="text" name="observacao" id="observacao" cols="30" rows="5" placeholder="Digite alguma Observação">{{old('observacao')}}</textarea>
                                        @error('observacao')
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
                                <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" form="create-beneficiario" style="width: 100%">Salvar</button>
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



            function meu_callback(conteudo) {
                if (!("erro" in conteudo)) {
                    //Atualiza os campos com os valores.
                    document.getElementById('rua').value=(conteudo.logradouro);
                    document.getElementById('bairro').value=(conteudo.bairro);
                    document.getElementById('cidade').value=(conteudo.localidade);
                    document.getElementById('uf').value=(conteudo.uf);
                } //end if.
                else {
                    //CEP não Encontrado.
                    limpa_formulário_cep();
                    // exibirModalCep();
                }
            }

            function meu_callback_empresa(conteudo) {
                console.log(conteudo);
                if (!("erro" in conteudo)) {
                    //Atualiza os campos com os valores.
                    document.getElementById('rua_da_empresa').value=(conteudo.logradouro);
                    document.getElementById('bairro_da_empresa').value=(conteudo.bairro);
                    if (conteudo.localidade != "Garanhuns" || conteudo.uf != "PE") {
                        exibirModal();
                    }
                } //end if.
                else {
                    //CEP não Encontrado.
                    limpa_formulário_cep_empresa();
                    exibirModalCep();
                }
            }





            function exibirModal() {
                $('#btn-modal-aviso').click();
            }


        </script>
    @endpush
@endsection
</x-app-layout>
