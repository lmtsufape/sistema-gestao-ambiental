<x-guest-layout>


    <div style="background-color: rgb(236, 236, 243)">
        <div class="container-fluid" style="padding-top: 5rem; padding-bottom: 8rem;">
            <div class="form-row justify-content-center">
                <div class="col-md-10">
                    <div class="form-row">
                        <div class="col-md-8">
                            <h4 class="card-title">Cadastre-se</h4>
                        </div>
                        <div class="col-md-4" style="text-align: right">
                            <h6 style="position: relative; top: 8px;"><span style="color: red; font-weight: bold;">*</span> Campos obrigatórios</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row justify-content-center">
                <div class="col-md-10">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            @php
                                $setores = \App\Models\Setor::all();
                            @endphp
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="name">{{ __('Name') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="name" class="form-control apenas_letras @error('name') is-invalid @enderror" type="text" name="name" value="{{old('name')}}" required autofocus autocomplete="name" placeholder="Digite seu nome aqui...">
                                        @error('name')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="email">{{ __('Email') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{old('email')}}" required autocomplete="email" placeholder="email@gmail.com">
                                        @error('email')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="password">{{ __('Password') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autofocus autocomplete="new-password">
                                        <small>Deve ter no mínimo 8 caracteres</small>
                                        @error('password')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="password_confirmation">{{ __('Confirm Password') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cpf">{{ __('CPF') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="cpf" class="form-control simple-field-data-mask @error('cpf') is-invalid @enderror" type="text" name="cpf" value="{{old('cpf')}}" required autofocus autocomplete="cpf" data-mask="000.000.000-00" placeholder="000.000.000-00">
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
                                        <label for="rg">{{ __('RG') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="rg" class="form-control @error('rg') is-invalid @enderror" type="text" name="rg" value="{{old('rg')}}" required autofocus autocomplete="rg" placeholder="Digite o número de seu RG...">
                                        @error('rg')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="orgao_emissor">{{ __('Orgão emissor') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="orgao_emissor" class="form-control @error('orgão_emissor') is-invalid @enderror" type="text" name="orgão_emissor" value="{{old('orgão_emissor')}}" required autocomplete="orgão_emissor" placeholder="O orgão emissor do RG...">
                                        @error('orgão_emissor')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <hr class="divisor">
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cep">{{ __('CEP') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="cep" class="form-control cep @error('cep') is-invalid @enderror" type="text" name="cep" value="{{old('cep')}}" required autofocus autocomplete="cep" onblur="pesquisacep(this.value);" placeholder="00000-000">
                                        @error('cep')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="bairro">{{ __('Bairro') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="bairro" class="form-control @error('bairro') is-invalid @enderror" type="text" name="bairro" value="{{old('bairro')}}" required autofocus autocomplete="bairro" placeholder="Digite o bairro onde mora...">
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
                                        <input id="rua" class="form-control @error('rua') is-invalid @enderror" type="text" name="rua" value="{{old('rua')}}" required autocomplete="rua" placeholder="Digite a rua onde mora...">
                                        @error('rua')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="numero">{{ __('Número') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="numero" class="form-control  @error('número') is-invalid @enderror" type="text" name="número" value="{{old('número')}}" required autocomplete="número" placeholder="Digite o número de sua casa...">
                                        @error('número')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cidade">{{ __('Cidade') }}</label>
                                        <input id="cidade" class="form-control @error('cidade') is-invalid @enderror" type="text" name="cidade" value="Garanhuns" required autofocus autocomplete="cidade" placeholder="Digite a cidade que mora...">
                                        @error('cidade')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="uf">{{ __('Estado') }}</label>
                                        <select id="uf" class="form-control @error('uf') is-invalid @enderror" type="text" required autocomplete="estado" name="uf">
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
                                        <label for="complemento">{{ __('Complemento') }}</label>
                                        <textarea class="form-control @error('complemento') is-invalid @enderror" type="text" name="complemento" id="complemento" cols="30" rows="5" placeholder="Digite qual o complemento que mora (Casa, Apartamento, etc)">{{old('complemento')}}</textarea>
                                        @error('complemento')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                    <div class="mt-2">
                                        <x-jet-label for="terms">
                                            <div class="flex items-center">
                                                <x-jet-checkbox name="terms" id="terms" class="checkbox-licenciamento" required/>

                                                <div class="ml-2">
                                                    {!! __('Eu aceito os :terms_of_service e a :privacy_policy.', [
                                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Termos de Serviço').'</a>',
                                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Política de Privacidade').'</a>',
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </x-jet-label>
                                    </div>
                                    <div class="mt-2">
                                        <x-jet-label for="declaracao">
                                            <div class="flex items-center">
                                                <x-jet-checkbox name="declaracao" id="declaracao" class="checkbox-licenciamento" required/>

                                                <div class="ml-2">
                                                    {!! __('Declaro sob as penas da lei que todas as informações prestadas são verdadeiras e estou ciente de eventual responsabilidade administrativa, cível e criminal que tais informações possam gerar.') !!}
                                                </div>
                                            </div>
                                        </x-jet-label>
                                    </div>
                                @endif

                                <div class="flex items-center justify-end mt-4">
                                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                                        {{ __('Already registered?') }}
                                    </a>

                                    <button type="submit" class="btn btn-success btn-color-dafault" style="margin-left: 15px;">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="display: none;">
            <!-- Button trigger modal -->
        <button id="btn-modal-aviso" type="button" class="btn btn-primary" data-toggle="modal" data-target="#aviso-modal-fora">
            Launch demo modal
        </button>

        <button id="btn-modal-cep-nao-encontrado" type="button" class="btn btn-primary" data-toggle="modal" data-target="#aviso-modal-cep-nao-encontrado">
            Launch demo modal
        </button>
        <button id="btn-modal-cep-invalido" type="button" class="btn btn-primary" data-toggle="modal" data-target="#aviso-modal-cep-invalido">
            Launch demo modal
        </button>
    </div>
     <!-- Modal -->
     <div class="modal fade" id="aviso-modal-cep-nao-encontrado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #dc3545;">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: white;">Aviso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    CEP não encontrado!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="aviso-modal-cep-invalido" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #dc3545;">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: white;">Aviso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    Formato do CEP inválido!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>


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
</x-guest-layout>
