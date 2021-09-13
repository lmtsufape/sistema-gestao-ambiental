<x-guest-layout>
    <div style="background-color: rgb(236, 236, 243)">
        <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
            <div class="form-row justify-content-center">
                <div class="col-md-8">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            @php
                                $setores = \App\Models\Setor::all();
                            @endphp
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <h4>Informações do requerente</h4>
                                    </div>
                                </div>
                                <div class="form-row">
                                    
                                    <div class="col-md-6 form-group">
                                        <label for="name">{{ __('Name') }}</label>
                                        <input id="name" class="form-control apenas_letras @error('name') is-invalid @enderror" type="text" name="name" value="{{old('name')}}" required autofocus autocomplete="name">

                                        @error('name')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="email">{{ __('Email') }}</label>
                                        <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{old('email')}}" required autofocus autocomplete="email">

                                        @error('email')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="password">{{ __('Password') }}</label>
                                        <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autofocus autocomplete="new-password">

                                        @error('password')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                        <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cpf">{{ __('CPF') }}</label>
                                        <input id="cpf" class="form-control simple-field-data-mask @error('cpf') is-invalid @enderror" type="text" name="cpf" value="{{old('cpf')}}" required autofocus autocomplete="cpf" data-mask="000.000.000-00">

                                        @error('cpf')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="celular">{{ __('Contato') }}</label>
                                        <input id="celular" class="form-control celular @error('celular') is-invalid @enderror" type="text" name="celular" value="{{old('celular')}}" required autocomplete="celular">

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
                                        <input id="rg" class="form-control @error('rg') is-invalid @enderror" type="text" name="rg" value="{{old('rg')}}" required autofocus autocomplete="rg">

                                        @error('rg')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="orgao_emissor">{{ __('Orgão emissor') }}</label>
                                        <input id="orgao_emissor" class="form-control @error('orgão_emissor') is-invalid @enderror" type="text" name="orgão_emissor" value="{{old('orgão_emissor')}}" required autocomplete="orgão_emissor">

                                        @error('orgão_emissor')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cep">{{ __('CEP') }}</label>
                                        <input id="cep" class="form-control cep @error('cep') is-invalid @enderror" type="text" name="cep" value="{{old('cep')}}" required autofocus autocomplete="cep" onblur="pesquisacep(this.value);">

                                        @error('cep')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="bairro">{{ __('Bairro') }}</label>
                                        <input id="bairro" class="form-control @error('bairro') is-invalid @enderror" type="text" name="bairro" value="{{old('bairro')}}" required autofocus autocomplete="bairro">

                                        @error('bairro')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="rua">{{ __('Rua') }}</label>
                                        <input id="rua" class="form-control @error('rua') is-invalid @enderror" type="text" name="rua" value="{{old('rua')}}" required autocomplete="rua">

                                        @error('rua')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="numero">{{ __('Número') }}</label>
                                        <input id="numero" class="form-control  @error('número') is-invalid @enderror" type="text" name="número" value="{{old('número')}}" required autocomplete="número">

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
                                        <input type="hidden" name="cidade" value="Garanhuns">
                                        <input id="cidade" class="form-control @error('cidade') is-invalid @enderror" type="text" value="Garanhuns" required disabled autofocus autocomplete="cidade">

                                        @error('cidade')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="estado">{{ __('Estado') }}</label>
                                        <input type="hidden" name="estado" value="PE">
                                        <select id="estado" class="form-control @error('estado') is-invalid @enderror" type="text" required autocomplete="estado" disabled>
                                            <option value=""  hidden>-- Selecione o UF --</option>
                                            <option selected value="PE">Pernambuco</option>
                                        </select>
                                        @error('estado')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <label for="complemento">{{ __('Complemento') }}</label>
                                        <textarea class="form-control @error('complemento') is-invalid @enderror" type="text" name="complemento" id="complemento" cols="30" rows="5">{{old('complemento')}}</textarea>

                                        @error('complemento')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <h4>Informações da empresa</h4>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="nome_empresa">{{ __('Name') }}</label>
                                        <input id="nome_empresa" class="form-control apenas_letras @error('nome_da_empresa') is-invalid @enderror" type="text" name="nome_da_empresa" value="{{old('nome_da_empresa')}}" required autofocus autocomplete="nome_empresa">

                                        @error('nome_da_empresa')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="cnpj">{{ __('CNPJ') }}</label>
                                        <input id="cnpj" class="form-control @error('cnpj') is-invalid @enderror" type="text" name="cnpj" value="{{old('cnpj')}}" required autocomplete="cnpj">

                                        @error('cnpj')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="celular_da_empresa">{{ __('Contato') }}</label>
                                        <input id="celular_da_empresa" class="form-control celular @error('celular_da_empresa') is-invalid @enderror" type="text" name="celular_da_empresa" value="{{old('celular_da_empresa')}}" required autocomplete="celular">

                                        @error('celular_da_empresa')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="porte">{{ __('Porte') }}</label>
                                        <select id="porte" class="form-control @error('porte') is-invalid @enderror" type="text" name="porte" required autofocus autocomplete="porte">
                                            <option selected disabled value="">-- Selecione o porte da sua empresa --</option>
                                            <option @if(old('porte') == 1) selected @endif value="1">Micro</option>
                                            <option @if(old('porte') == 2) selected @endif value="2">Pequeno</option>
                                            <option @if(old('porte') == 3) selected @endif value="3">Médio</option>
                                            <option @if(old('porte') == 4) selected @endif value="4">Grande</option>
                                            <option @if(old('porte') == 5) selected @endif value="5">Especial</option>
                                        </select>

                                        @error('porte')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cep_da_empresa">{{ __('CEP') }}</label>
                                        <input id="cep_da_empresa" class="form-control cep @error('cep_da_empresa') is-invalid @enderror" type="text" name="cep_da_empresa" value="{{old('cep_da_empresa')}}" required autofocus autocomplete="cep_da_empresa" onblur="pesquisacepEmpresa(this.value);">

                                        @error('cep_da_empresa')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="bairro_da_empresa">{{ __('Bairro') }}</label>
                                        <input id="bairro_da_empresa" class="form-control @error('bairro_da_empresa') is-invalid @enderror" type="text" name="bairro_da_empresa" value="{{old('bairro_da_empresa')}}" required autofocus autocomplete="bairro_da_empresa">

                                        @error('bairro_da_empresa')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="rua_da_empresa">{{ __('Rua') }}</label>
                                        <input id="rua_da_empresa" class="form-control @error('rua_da_empresa') is-invalid @enderror" type="text" name="rua_da_empresa" value="{{old('rua_da_empresa')}}" required autocomplete="rua_da_empresa">

                                        @error('rua_da_empresa')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="numero_da_empresa">{{ __('Número') }}</label>
                                        <input id="numero_da_empresa" class="form-control @error('número_da_empresa') is-invalid @enderror" type="text" name="número_da_empresa" value="{{old('número_da_empresa')}}" required autocomplete="número_da_empresa">

                                        @error('número_da_empresa')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cidade_da_empresa">{{ __('Cidade') }}</label>
                                        <input type="hidden" name="cidade_da_empresa" value="Garanhuns">
                                        <input id="cidade_da_empresa" class="form-control @error('cidade_da_empresa') is-invalid @enderror" type="text" value="Garanhuns" required disabled autofocus autocomplete="cidade_da_empresa">

                                        @error('cidade_da_empresa')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="estado_da_empresa">{{ __('Estado') }}</label>
                                        <input type="hidden" name="estado_da_empresa" value="PE">
                                        <select id="estado_da_empresa" class="form-control @error('estado_da_empresa') is-invalid @enderror" type="text" required autocomplete="estado_da_empresa" disabled>
                                            <option value=""  hidden>-- Selecione o UF --</option>
                                            <option selected value="PE">Pernambuco</option>
                                        </select>

                                        @error('estado_da_empresa')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <label for="complemento_da_empresa">{{ __('Complemento') }}</label>
                                        <textarea class="form-control @error('complemento_da_empresa') is-invalid @enderror" type="text" name="complemento_da_empresa" id="complemento_da_empresa" cols="30" rows="5">{{old('complemento_da_empresa')}}</textarea>

                                        @error('complemento_da_empresa')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <div class="form-row">
                                            <div class="form-group col-md-12" >
                                                <label for="setor">{{ __('Setor') }}</label>
                                                <select required class="form-control @error('setor') is-invalid @enderror" id="idSelecionarSetor" onChange="selecionarSetor(this)" name="setor">
                                                    <option value="">-- Selecionar o Setor --</option>
                                                    @foreach ($setores as $setor)
                                                        <option value={{$setor->id}}>{{$setor->nome}}</option>
                                                    @endforeach
                                                </select>

                                                @error('setor')
                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="btn-group col-md-12">
                                                <div class="col-md-6 styleTituloDoInputCadastro" style="margin-left:-15px;margin-right:30px;margin-bottom:10px;">Lista de CNAE</div>
                                                <div class="col-md-12 input-group input-group-sm mb-2">
                                                    {{-- <input type="text" class="form-control" placeholder="Nome ou código do CNAE"> --}}
                                                </div>

                                            </div>
                                            <div class="form-row col-md-12">
                                                <div style="width:100%; height:250px; display: inline-block; border: 1.5px solid #f2f2f2; border-radius: 2px; overflow:auto;">
                                                    <table id="tabelaCnaes" cellspacing="0" cellpadding="1"width="100%" >
                                                        <tbody id="dentroTabelaCnaes">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="styleTituloDoInputCadastro" for="exampleFormControlSelect1">CNAE selecionado</label>
                                        <div class="form-group col-md-12 areaMeusCnaes" id="listaCnaes">

                                        </div>
                                    </div>
                                </div>
                                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                    <div class="mt-4">
                                        <x-jet-label for="terms">
                                            <div class="flex items-center">
                                                <x-jet-checkbox name="terms" id="terms"/>

                                                <div class="ml-2">
                                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </x-jet-label>
                                    </div>
                                @endif

                                <div class="flex items-center justify-end mt-4">
                                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                                        {{ __('Already registered?') }}
                                    </a>

                                    <x-jet-button class="ml-4">
                                        {{ __('Register') }}
                                    </x-jet-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.selecionarSetor = function(){
            //setor
            var historySelectList = $('select#idSelecionarSetor');
            var $setor_id = $('option:selected', historySelectList).val();

            $.ajax({
                url:'setor/ajax-listar-cnaes',
                type:"get",
                data: {"setor_id": $setor_id},
                dataType:'json',
                /*success: function(response){
                    console.log(response.responseJSON);
                    for(var i = 0; i < data.responseJSON.cnaes.length; i++){
                        var html = data.responseJSON.cnaes[i];
                        $('#tabelaCnaes tbody').append(html);
                    }
                },*/

                complete: function(data) {
                    if(data.responseJSON.success){
                        for(var i = 0; i < data.responseJSON.cnaes.length; i++){
                            var naLista = document.getElementById('listaCnaes');
                            var html = `<div id="cnaeCard_`+$setor_id+`_`+data.responseJSON.cnaes[i].id+`" class="d-flex justify-content-center cardMeuCnae" onmouseenter="mostrarBotaoAdicionar(`+data.responseJSON.cnaes[i].id+`)">
                                            <input hidden name="cnaes_id[]" value="`+data.responseJSON.cnaes[i].id+`">
                                            <div class="mr-auto p-2" id="`+data.responseJSON.cnaes[i].id+`">`+data.responseJSON.cnaes[i].nome+`</div>
                                            <div style="width:140px; height:25px; text-align:right;">
                                                <div id="cardSelecionado`+data.responseJSON.cnaes[i].id+`" class="btn-group" style="display:none;">
                                                    <div id="botaoCardSelecionado`+data.responseJSON.cnaes[i].id+`" class="btn btn-success btn-sm"  onclick="add_Lista(`+$setor_id+`, `+data.responseJSON.cnaes[i].id+`)" >Adicionar</div>
                                                </div>
                                            </div>
                                        </div>`;
                            if(document.getElementById('cnaeCard_'+$setor_id+'_'+data.responseJSON.cnaes[i].id) == null){
                                $('#tabelaCnaes tbody').append(html);
                            }
                        }
                    }
                }
            });
        }

        window.add_Lista = function($setor, $id) {
            var elemento = document.getElementById('cnaeCard_'+$setor+'_'+$id);
            var naTabela = document.getElementById('dentroTabelaCnaes');
            if(elemento.parentElement == naTabela){
                $('#listaCnaes').append(elemento);
            }else{
                var historySelectList = $('select#idSelecionarSetor');
                var $setor_id = $('option:selected', historySelectList).val();
                if($setor == $setor_id){
                    $('#dentroTabelaCnaes').append(elemento);
                }else{
                    document.getElementById('listaCnaes').removeChild(elemento);
                }
            }

        }

        var tempIdCard = -1;
        window.mostrarBotaoAdicionar = function(valor){
            if(tempIdCard == -1){
                document.getElementById("cardSelecionado"+valor).style.display = "block";
                this.tempIdCard=document.getElementById("cardSelecionado"+valor);
            }else if(tempIdCard != -1){
                tempIdCard.style.display = "none";
                document.getElementById("cardSelecionado"+valor).style.display = "block";
                this.tempIdCard=document.getElementById("cardSelecionado"+valor);

            }

        }

        $(document).ready(function($) {
            $('#cpf').mask('000.000.000-00');
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
                if (conteudo.localidade != "Garanhuns" || conteudo.uf != "PE") {
                    alert('O cadastro não está disponivel para empresas fora do municipio de garanhuns!');
                }
            } //end if.
            else {
                //CEP não Encontrado.
                limpa_formulário_cep();
                alert("CEP não encontrado.");
            }
        }

        function meu_callback_empresa(conteudo) {
            console.log(conteudo);
            if (!("erro" in conteudo)) {
                //Atualiza os campos com os valores.
                document.getElementById('rua_da_empresa').value=(conteudo.logradouro);
                document.getElementById('bairro_da_empresa').value=(conteudo.bairro);
                if (conteudo.localidade != "Garanhuns" || conteudo.uf != "PE") {
                    alert('O cadastro não está disponivel para empresas fora do municipio de garanhuns!');
                }
            } //end if.
            else {
                //CEP não Encontrado.
                limpa_formulário_cep_empresa();
                alert("CEP não encontrado.");
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
                    alert("Formato de CEP inválido.");
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
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep_empresa();
            }
        }
    </script>
</x-guest-layout>
