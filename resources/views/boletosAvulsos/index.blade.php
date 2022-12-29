<x-app-layout>
    @section('content')
    @can('isSecretario', \App\Models\User::class)
        <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
            <div class="form-row justify-content-center">
                <div class="col-md-12">
                    <div class="form-row">
                        <div class="col-md-12">
                            <h4 class="card-title">Cadastrar uma empresa</h4>
                            <h5 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('boletosAvulsos.index')}}">Boletos Avulsos</a> > Cadastrar empresa</h5>
                        </div>
                        
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card card-borda-esquerda" style="width: 100%;">
                        <div class="card-body">
                            <form id="form-cadastrar-empresa" method="POST" action="{{route('boletosAvulsos.store')}}">
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
                                    <div class="col-md-8 form-group">
                                        <label for="cpf_cnpj">{{ __('CPF/CNPJ') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        
                                        <input onkeyup="mask_cpf_cnpj();" id="cpf_cnpj" class="form-control @error('cpf_cnpj') is-invalid @enderror" type="text" name="cpf_cnpj" value="{{old('cpf_cnpj')}}" required autofocus autocomplete="cpf_cnpj">
                                        @error('pessoa')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mt-4">
                                        <button class="btn btn-primary" style="height: 50px;" onClick="preencherEmpresaExistente()">
                                            Consultar
                                        </button>
                                    </div>    
                                </div>

                                <div class="form-row">
                                    <div id="email_empresa_div" style="display: none" class="col-md-8 form-group">
                                        <label for="email_empresa">{{ __('E-mail empresa') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        
                                        <input id="email_empresa" class="form-control @error('email_empresa') is-invalid @enderror" type="text" name="email_empresa" value="{{old('email_empresa')}}" autocomplete="email_empresa">
                                        @error('email_empresa')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="celular_da_empresa">{{ __('Contato') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="celular_da_empresa" class="form-control celular @error('celular_da_empresa') is-invalid @enderror" type="text" name="celular_da_empresa" value="{{old('celular_da_empresa')}}" required autocomplete="celular">
                                        @error('celular_da_empresa')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="nome_empresa">{{ __('Razão social/Nome') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="nome_empresa" class="form-control @error('nome_da_empresa') is-invalid @enderror" type="text" name="nome_da_empresa" value="{{old('nome_da_empresa')}}" required autofocus autocomplete="nome_empresa">
                                        @error('nome_da_empresa')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cep_da_empresa">{{ __('CEP') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="cep_da_empresa" class="form-control cep @error('cep_da_empresa') is-invalid @enderror" type="text" name="cep_da_empresa" value="{{old('cep_da_empresa')}}" required autofocus autocomplete="cep_da_empresa" onblur="pesquisacepEmpresa(this.value);">
                                        @error('cep_da_empresa')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="bairro_da_empresa">{{ __('Bairro') }}<span style="color: red; font-weight: bold;">*</span></label>
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
                                        <label for="rua_da_empresa">{{ __('Rua') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="rua_da_empresa" class="form-control @error('rua_da_empresa') is-invalid @enderror" type="text" name="rua_da_empresa" value="{{old('rua_da_empresa')}}" required autocomplete="rua_da_empresa">
                                        @error('rua_da_empresa')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="numero_da_empresa">{{ __('Número') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="numero_da_empresa" class="form-control @error('numero_da_empresa') is-invalid @enderror" type="text" name="numero_da_empresa" value="{{old('numero_da_empresa')}}" required autocomplete="numero_da_empresa">
                                        @error('numero_da_empresa')
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
                                <hr>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label for="multa">{{ __('Valor da multa (R$)') }}<span style="color: red; font-weight: bold;">*</span></label>
                                            <input type="number" step="0.01" id="multa" class="form-control @error('multa') is-invalid @enderror" type="text" name="multa" value="{{old('multa')}}" required autofocus autocomplete="nome_empresa">
                                            @error('multa')
                                                <div id="validationServer03Feedback" class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div style="width:100%; height:396px; display: inline-block;  background-color: #f3f3f3; overflow:auto;">
                                            <h3 style="text-align: center; margin-top: 10px;">INFRAÇÕES</h3>
                                            <h5 style="text-align: center;">Art. 111. A pena de multa será imposta com observância dos seguintes limites:</h5>
                                            <ol style="list-style-type: upper-roman; margin: 50px;">
                                                <li>nas infrações leves, de R$ 500,00 (quinhetos reais) a R$ 5.000,00 (cinco mil reais)</li>
                                                <li>nas infrações médias, de R$ 5001,00 (cinco mil e um reais) a R$ 10.000,00 (dez mil reais)</li>
                                                <li>nas infrações graves, de R$ 10.001,00 (dez mil e um reais) a R$ 25.000,00 (vinte e cinco mil reais)</li>
                                                <li>nas infrações gravíssimas, de R$ 25.001,00 (vinte e cinco mil e um reais) a R$ 100.000,00 (cem mil reais)</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <div class="form-row">
                                <div class="col-md-6 form-group"></div>
                                <div class="col-md-6 form-group">
                                    <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" style="width: 100%;" form="form-cadastrar-empresa">Gerar boleto</button>
                                </div>
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
        <!-- Modal -->
        <div class="modal fade" id="aviso-modal-fora" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #4A7836;">
                        <h5 class="modal-title" id="exampleModalLabel" style="color: white;">Aviso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        O cadastro não está disponivel para empresas fora do municipio de garanhuns!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-color-dafault" data-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="aviso-modal-empresa-nao-existe" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #dc3545;">
                        <h5 class="modal-title" id="exampleModalLabel" style="color: white;">Aviso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        Empresa não cadastrada no sistema! É necessario o preenchimento dos dados para 
                        geração do boleto.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-color-dafault" data-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    @endcan
        
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

            window.selecionarSetor = function(){
                //setor
                var historySelectList = $('select#idSelecionarSetor');
                var $setor_id = $('option:selected', historySelectList).val();
                limparLista();
                $.ajax({
                    url:"{{route('ajax.listar.cnaes')}}",
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
                                var html = `<div id="cnaeCard_`+$setor_id+`_`+data.responseJSON.cnaes[i].id+`" class="d-flex justify-content-center card-cnae" onmouseenter="mostrarBotaoAdicionar(`+data.responseJSON.cnaes[i].id+`)">
                                                <div class="mr-auto p-2" id="`+data.responseJSON.cnaes[i].id+`">`+data.responseJSON.cnaes[i].nome+`</div>
                                                <div style="width:140px; height:25px; text-align:right;">
                                                    <div id="cardSelecionado`+data.responseJSON.cnaes[i].id+`" class="btn-group" style="display:none;">
                                                        <div id="botaoCardSelecionado`+data.responseJSON.cnaes[i].id+`" class="btn btn-success btn-color-dafault btn-sm"  onclick="add_Lista(`+$setor_id+`, `+data.responseJSON.cnaes[i].id+`)" >Adicionar</div>
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
            var divBtn = elemento.children[1].children[0].children[0];

            if(elemento.parentElement == naTabela){
                $('#listaCnaes').append(elemento);
                divBtn.style.backgroundColor = "#dc3545";
                divBtn.style.borderColor = "#dc3545";
                divBtn.textContent = "Remover";
                var html = `<input id ="inputCnae_`+$id+`" hidden name="cnaes_id[]" value="`+$id+`">`;
                $('#cnaeCard_'+$setor+'_'+$id).append(html);
            }else{
                var historySelectList = $('select#idSelecionarSetor');
                var $setor_id = $('option:selected', historySelectList).val();
                if($setor == $setor_id){
                    $('#dentroTabelaCnaes').append(elemento);
                    divBtn.style.backgroundColor = "var(--primaria)";
                    divBtn.style.borderColor = "var(--primaria)";
                    divBtn.textContent = "Adicionar";
                    $('#inputCnae_'+$id).remove();
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

            function limparLista() {
                var cnaes = document.getElementById('tabelaCnaes').children[0];
                cnaes.innerHTML = "";
            }

            function mostrarDiv(select) {
                document.getElementById('selecionar-cpf-cnpj').style.display = "none";
                document.getElementById('div-btn-troca').style.display = "block";
                if (select.value == "física") {
                    document.getElementById('div-cpf').style.display = "block";
                    document.getElementById('div-cnpj').style.display = "none";
                } else if(select.value == "jurídica") {
                    document.getElementById('div-cpf').style.display = "none";
                    document.getElementById('div-cnpj').style.display = "block";
                }
            }

            function trocar() {
                if (document.getElementById('div-cpf').style.display == "block") {
                    document.getElementById('div-cpf').style.display = "none";
                    document.getElementById('cpf').value = null;
                    document.getElementById('div-cnpj').style.display = "block";
                } else {
                    document.getElementById('div-cpf').style.display = "block";
                    document.getElementById('cnpj').value = null;
                    document.getElementById('div-cnpj').style.display = "none";
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

            function limpa_formulário_cep_empresa() {
                //Limpa valores do formulário de cep.
                document.getElementById('rua_da_empresa').value=("");
                document.getElementById('bairro_da_empresa').value=("");
            }

            function exibirModalCepInvalido() {
                $('#aviso-modal-fora').modal('show');
            }

            function exibirModalEmpresaInexistente() {
                $('#aviso-modal-empresa-nao-existe').modal('show');
            }

            function exibirModal() {
                $('#btn-modal-aviso').click();
            }

            function exibirModalCep() {
                $('#btn-modal-cep-nao-encontrado').click();
            }
            
            function emailHidden() {
                // console.log("aqui")
                var div_email = document.getElementById("email_empresa_div");
                if (div_email.style.display === "none") {
                    div_email.style.display = "block";
                }
            }

            function emailEnable() {
                var div_email = document.getElementById("email_empresa_div");
                if (div_email.style.display === "block") {
                    div_email.style.display = "none";
                }
            }

            function mask_cpf_cnpj() {
                $("#cpf_cnpj").keydown(function(){
                try {
                    $("#cpf_cnpj").unmask();
                } catch (e) {}

                var tamanho = $("#cpf_cnpj").val().length;

                if(tamanho < 11){
                    $("#cpf_cnpj").mask("999.999.999-99");
                } else {
                    $("#cpf_cnpj").mask("99.999.999/9999-99");
                }

                // ajustando foco
                var elem = this;
                setTimeout(function(){
                    // mudo a posição do seletor
                    elem.selectionStart = elem.selectionEnd = 10000;
                }, 0);
                // reaplico o valor para mudar o foco
                var currentValue = $(this).val();
                $(this).val('');
                $(this).val(currentValue);
            });

            }

            function preencherEmpresaExistente() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                url: '{{route('boletosAvulsos.buscarEmpresa')}}', 
                type: 'POST',
                dataType: 'json',
                data: {
                        'cpf_cnpj': $('#cpf_cnpj').val()
                },
                success: function (data) {
                    if(data == 'inexistente'){
                        exibirModalEmpresaInexistente();
                        emailHidden();
                    }else {
                        emailEnable();
                        $('#nome_empresa').val(data[0]['nome']);
                        $('#cep_da_empresa').val(data[1]['cep']);
                        $('#rua_da_empresa').val(data[1]['rua']);
                        $('#numero_da_empresa').val(data[1]['numero']);
                        $('#bairro_da_empresa').val(data[1]['bairro']);
                        $('#cidade_da_empresa').val(data[1]['cidade']);
                        $('#estado_da_empresa').val(data[1]['estado']);
                        $('#complemento_da_empresa').val(data[1]['complemento']);
                        $('#celular_da_empresa').val(data[2]['numero']);
                    }
		        }
	            });
            }

        </script>
    @endpush
    @endsection
</x-app-layout>
