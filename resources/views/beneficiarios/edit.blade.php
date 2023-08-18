<x-app-layout>
    @section('content')
        <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
            <div class="form-row justify-content-center">
                <div class="col-md-12">
                    <div class="form-row">
                        <div class="col-md-12">
                            <h4 class="card-title">Editar Beneficiário</h4>
                        </div>
                        <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                            {{-- <a title="Voltar" href="{{route('usuarios.index')}}">
                                <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="">
                            </a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-borda-esquerda" style="width: 100%;">
                        <div class="card-body">
                            <form id="form-edit-beneficiario" method="POST" action="{{route('beneficiarios.update', $beneficiario->id)}}">
                                @csrf
                                @method('PUT')
                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <label for="name">{{ __('Name') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="name" class="form-control apenas_letras @error('name') is-invalid @enderror" type="text" name="name" value="{{ $beneficiario->nome }}" required autofocus autocomplete="name" placeholder="Digite seu nome aqui...">
                                        @error('name')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="nis">{{ __('NIS') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="nis" class="form-control @error('nis') is-invalid @enderror" type="string" name="nis" value="{{ $beneficiario->nis }}" required autofocus autocomplete="nis" placeholder="Digite seu NIS aqui...">
                                        @error('nis')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="quantidade_pessoas">{{ __('Quantidade de pessoas') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="quantidade_pessoas" class="form-control @error('quantidade_pessoas') is-invalid @enderror" type="number" name="quantidade_pessoas" value="{{ $beneficiario->quantidade_pessoas }}" required autofocus autocomplete="quantidade_pessoas" placeholder="Digite a quantidade de pessoas...">
                                        @error('quantidade_pessoas')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cpf">{{ __('CPF') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="cpf" class="form-control simple-field-data-mask @error('cpf') is-invalid @enderror" type="text" name="cpf" value="{{$beneficiario->cpf}}" required autofocus autocomplete="cpf" data-mask="000.000.000-00" placeholder="000.000.000-00">
                                        @error('cpf')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="celular">{{ __('Contato') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="celular" class="form-control celular @error('celular') is-invalid @enderror" type="text" name="celular" value="{{$beneficiario->telefone->numero}}" required autocomplete="celular" placeholder="(00) 00000-0000">
                                        @error('celular')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="rg">{{ __('RG') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="rg" class="form-control @error('rg') is-invalid @enderror" type="text" name="rg" value="{{$beneficiario->rg}}" required autofocus autocomplete="rg" placeholder="Digite o número de seu RG...">
                                        @error('rg')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="orgao_emissor">{{ __('Orgão emissor') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="orgao_emissor" class="form-control @error('orgao_emissor') is-invalid @enderror" type="text" name="orgao_emissor" value="{{$beneficiario->orgao_emissor}}" required autocomplete="orgao_emissor" placeholder="O orgão emissor do RG...">
                                        @error('orgao_emissor')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="codigo">{{ __('Código do Beneficiário') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="codigo" class="form-control @error('codigo') is-invalid @enderror" type="text" name="codigo" value="{{$beneficiario->codigo}}" required autofocus autocomplete="codigo" placeholder="Digite o código do beneficiário...">
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
                                            <option value="0" {{ $beneficiario->tipo_beneficiario == 0 ? 'selected' : '' }}>Aração</option>
                                            <option value="1" {{ $beneficiario->tipo_beneficiario == 1 ? 'selected' : '' }}>Carro Pipa</option>
                                            <option value="2" {{ $beneficiario->tipo_beneficiario == 2 ? 'selected' : '' }}>Ambos</option>
                                        </select>
                                    </div>
                                </div>
                                <hr class="divisor">
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cep">{{ __('CEP') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="cep" class="form-control cep @error('cep') is-invalid @enderror" type="text" name="cep" value="{{$beneficiario->endereco->cep}}" required autofocus autocomplete="cep" onblur="pesquisacep(this.value);" placeholder="00000-000">
                                        <div class="col-md-12 text-right font-weight-bold">
                                            <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" target="_blank">Não sei meu CEP</a>
                                        </div>
                                        @error('cep')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="bairro">{{ __('Bairro') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="bairro" class="form-control @error('bairro') is-invalid @enderror" type="text" name="bairro" value="{{$beneficiario->endereco->bairro}}" required autofocus autocomplete="bairro" placeholder="Digite o bairro onde mora...">
                                        @error('bairro')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="rua">{{ __('Rua') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="rua" class="form-control @error('rua') is-invalid @enderror" type="text" name="rua" value="{{$beneficiario->endereco->rua}}" required autocomplete="rua" placeholder="Digite a rua onde mora...">
                                        @error('rua')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="numero">{{ __('Número') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="numero" class="form-control  @error('numero') is-invalid @enderror" type="text" name="numero" value="{{$beneficiario->endereco->numero}}" required autocomplete="numero" placeholder="Digite o número de sua casa...">
                                        @error('numero')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cidade">{{ __('Cidade') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="cidade" class="form-control @error('cidade') is-invalid @enderror" type="text" name="cidade" value="{{$beneficiario->endereco->cidade}}" required autofocus autocomplete="cidade" placeholder="Digite a cidade que mora...">
                                        @error('cidade')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="uf">{{ __('Estado') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <select id="uf" class="form-control @error('uf') is-invalid @enderror" type="text" required autocomplete="estado" name="uf">
                                            <option value="" selected disabled>-- Selecione o UF --</option>
                                            <option @if($beneficiario->endereco->estado == 'AC') selected @endif value="AC">Acre</option>
                                            <option @if($beneficiario->endereco->estado == 'AL') selected @endif value="AL">Alagoas</option>
                                            <option @if($beneficiario->endereco->estado == 'AP') selected @endif value="AP">Amapá</option>
                                            <option @if($beneficiario->endereco->estado == 'AM') selected @endif value="AM">Amazonas</option>
                                            <option @if($beneficiario->endereco->estado == 'BA') selected @endif value="BA">Bahia</option>
                                            <option @if($beneficiario->endereco->estado == 'CE') selected @endif value="CE">Ceará</option>
                                            <option @if($beneficiario->endereco->estado == 'DF') selected @endif value="DF">Distrito Federal</option>
                                            <option @if($beneficiario->endereco->estado == 'ES') selected @endif value="ES">Espírito Santo</option>
                                            <option @if($beneficiario->endereco->estado == 'GO') selected @endif value="GO">Goiás</option>
                                            <option @if($beneficiario->endereco->estado == 'MA') selected @endif value="MA">Maranhão</option>
                                            <option @if($beneficiario->endereco->estado == 'MT') selected @endif value="MT">Mato Grosso</option>
                                            <option @if($beneficiario->endereco->estado == 'MS') selected @endif value="MS">Mato Grosso do Sul</option>
                                            <option @if($beneficiario->endereco->estado == 'MG') selected @endif value="MG">Minas Gerais</option>
                                            <option @if($beneficiario->endereco->estado == 'PA') selected @endif value="PA">Pará</option>
                                            <option @if($beneficiario->endereco->estado == 'PB') selected @endif value="PB">Paraíba</option>
                                            <option @if($beneficiario->endereco->estado == 'PR') selected @endif value="PR">Paraná</option>
                                            <option @if($beneficiario->endereco->estado == 'PE') selected @endif value="PE">Pernambuco</option>
                                            <option @if($beneficiario->endereco->estado == 'PI') selected @endif value="PI">Piauí</option>
                                            <option @if($beneficiario->endereco->estado == 'RJ') selected @endif value="RJ">Rio de Janeiro</option>
                                            <option @if($beneficiario->endereco->estado == 'RN') selected @endif value="RN">Rio Grande do Norte</option>
                                            <option @if($beneficiario->endereco->estado == 'RS') selected @endif value="RS">Rio Grande do Sul</option>
                                            <option @if($beneficiario->endereco->estado == 'RO') selected @endif value="RO">Rondônia</option>
                                            <option @if($beneficiario->endereco->estado == 'RR') selected @endif value="RR">Roraima</option>
                                            <option @if($beneficiario->endereco->estado == 'SC') selected @endif value="SC">Santa Catarina</option>
                                            <option @if($beneficiario->endereco->estado == 'SP') selected @endif value="SP">São Paulo</option>
                                            <option @if($beneficiario->endereco->estado == 'SE') selected @endif value="SE">Sergipe</option>
                                            <option @if($beneficiario->endereco->estado == 'TO') selected @endif value="TO">Tocantins</option>
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
                                        <textarea class="form-control @error('observacao') is-invalid @enderror" type="text" name="observacao" id="observacao" cols="30" rows="5" placeholder="Digite alguma Observação">{{$beneficiario->observacao}}</textarea>
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
                                <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" form="form-edit-beneficiario" style="width: 100%">Salvar</button>
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

            function limpa_formulário_cep() {
                //Limpa valores do formulário de cep.
                document.getElementById('rua').value=("");
                document.getElementById('bairro').value=("");
                document.getElementById('cidade').value=("");
                document.getElementById('uf').value=("");
            }

            function limpa_formulário_cep_empresa() {
                //Limpa valores do formulário de cep.
                document.getElementById('rua_da_empresa').value=("");
                document.getElementById('bairro_da_empresa').value=("");
            }

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

            function pesquisacep(valor) {
                //Nova variável "cep" somente com dígitos.
                var cep = valor.replace(/\D/g, '');
                //Verifica se campo cep possui valor informado.
                if (cep != "") {
                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;
                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {
                        //Preenche os campos com "..." enquanto consulta webservice.
                        document.getElementById('rua').value="...";
                        document.getElementById('bairro').value="...";
                        //Cria um elemento javascript.
                        var script = document.createElement('script');
                        //Sincroniza com o callback.
                        script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
                        //Insere script no documento e carrega o conteúdo.
                        document.body.appendChild(script);
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        exibirModalCepInvalido();;
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            }

            function pesquisacepEmpresa(valor) {
                //Nova variável "cep" somente com dígitos.
                var cep = valor.replace(/\D/g, '');
                //Verifica se campo cep possui valor informado.
                if (cep != "") {
                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;
                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {
                        //Preenche os campos com "..." enquanto consulta webservice.
                        document.getElementById('rua_da_empresa').value="...";
                        document.getElementById('bairro_da_empresa').value="...";
                        //Cria um elemento javascript.
                        var script = document.createElement('script');
                        //Sincroniza com o callback.
                        script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback_empresa';
                        //Insere script no documento e carrega o conteúdo.
                        document.body.appendChild(script);
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep_empresa();
                        exibirModalCepInvalido();
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep_empresa();
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
</x-guest-layout>
