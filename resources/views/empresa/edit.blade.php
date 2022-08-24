<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-12">
                        <h4 class="card-title">Editar uma empresa/serviço</h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('empresas.index')}}">Empresas</a> > Editar empresa/serviço</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        {{-- <a title="Voltar" href="{{route('empresas.index')}}">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-borda-esquerda" style="width: 100%;">
                    <div class="card-body">
                        <form id="form-editar-empresa" method="POST" action="{{route('empresas.update', ['empresa' => $empresa])}}">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
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
                                    <label for="nome_empresa">{{ __('Name') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="nome_empresa" class="form-control @error('nome_da_empresa') is-invalid @enderror" type="text" name="nome_da_empresa" value="{{old('nome_da_empresa', $empresa->nome)}}" required autofocus autocomplete="nome_empresa">
                                    @error('nome_da_empresa')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div id="selecionar-cpf-cnpj" class="col-md-6 form-group" style="display: none;">
                                    {{-- <label for="pessoa">{{ __('Tipo de pessoa') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select id="pessoa" class="form-control @error('tipo_de_pessoa') is-invalid @enderror" name="tipo_de_pessoa" required autocomplete="pessoa" onchange="mostrarDiv(this)">
                                        <option disabled selected value="">-- Selecione o tipo de pessoa --</option>
                                        <option @if(old('tipo_de_pessoa') == "física") selected @endif value="física">Pessoa física</option>
                                        <option @if(old('tipo_de_pessoa') == "jurídica") selected @endif value="jurídica">Pessoa jurídica</option>
                                    </select>
                                    @error('tipo_de_pessoa')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror --}}
                                </div>
                                <div class="col-md-4 form-group" id="div-cnpj" style="@if(old('cnpj') != null || $empresa->eh_cnpj) display: block; @else display: none; @endif">
                                    <label for="cnpj">{{ __('CNPJ') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="cnpj" class="form-control @error('cnpj') is-invalid @enderror" type="text" name="cnpj" value="@if($empresa->eh_cnpj){{old('cnpj', $empresa->cpf_cnpj)}}@else{{old('cnpj')}}@endif" autocomplete="cnpj">

                                    @error('cnpj')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group" id="div-cpf" style="@if(old('cpf') != null || !$empresa->eh_cnpj) display: block; @else display: none; @endif">
                                    <label for="cpf">{{ __('CPF') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="cpf" class="form-control @error('cpf') is-invalid @enderror" type="text" name="cpf" value="@if(!$empresa->eh_cnpj){{old('cpf', $empresa->cpf_cnpj)}}@else{{old('cpf')}}@endif" autocomplete="cpf">
                                    @error('cpf')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-2 form-group" id="div-btn-troca" style="display: block; top: 32px; margin-bottom: 50px;">
                                    <button type="button" class="btn btn-success btn-color-dafault" style="width: 100%;" onclick="trocar()">Trocar</button>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="celular_da_empresa">{{ __('Contato') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="celular_da_empresa" class="form-control celular @error('celular_da_empresa') is-invalid @enderror" type="text" name="celular_da_empresa" value="{{old('celular_da_empresa', $empresa->telefone->numero)}}" required autocomplete="celular">
                                    @error('celular_da_empresa')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="porte">{{ __('Porte') }}<span style="color: red; font-weight: bold;">*</span></label> <a href="{{route('info.porte')}}" title="Como classificar o porte?" target="_blanck">(como classificar o porte?)</a>
                                    <select id="porte" class="form-control @error('porte') is-invalid @enderror" type="text" name="porte" required autofocus autocomplete="porte">
                                        <option selected disabled value="">-- Selecione o porte da sua empresa --</option>
                                        <option @if(old('porte', $empresa->porte) == 1) selected @endif value="1">Micro</option>
                                        <option @if(old('porte', $empresa->porte) == 2) selected @endif value="2">Pequeno</option>
                                        <option @if(old('porte', $empresa->porte) == 3) selected @endif value="3">Médio</option>
                                        <option @if(old('porte', $empresa->porte) == 4) selected @endif value="4">Grande</option>
                                        <option @if(old('porte', $empresa->porte) == 5) selected @endif value="5">Especial</option>
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
                                    <label for="cep_da_empresa">{{ __('CEP') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="cep_da_empresa" class="form-control cep @error('cep_da_empresa') is-invalid @enderror" type="text" name="cep_da_empresa" value="{{old('cep_da_empresa', $empresa->endereco->cep)}}" required autofocus autocomplete="cep_da_empresa" onblur="pesquisacepEmpresa(this.value);">
                                    @error('cep_da_empresa')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="bairro_da_empresa">{{ __('Bairro') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="bairro_da_empresa" class="form-control @error('bairro_da_empresa') is-invalid @enderror" type="text" name="bairro_da_empresa" value="{{old('bairro_da_empresa', $empresa->endereco->bairro)}}" required autofocus autocomplete="bairro_da_empresa">
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
                                    <input id="rua_da_empresa" class="form-control @error('rua_da_empresa') is-invalid @enderror" type="text" name="rua_da_empresa" value="{{old('rua_da_empresa', $empresa->endereco->rua)}}" required autocomplete="rua_da_empresa">
                                    @error('rua_da_empresa')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="numero_da_empresa">{{ __('Número') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="numero_da_empresa" class="form-control @error('número_da_empresa') is-invalid @enderror" type="text" name="número_da_empresa" value="{{old('número_da_empresa', $empresa->endereco->numero)}}" required autocomplete="número_da_empresa">
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
                                    <textarea class="form-control @error('complemento_da_empresa') is-invalid @enderror" type="text" name="complemento_da_empresa" id="complemento_da_empresa" cols="30" rows="5">{{old('complemento_da_empresa', $empresa->endereco->complemento)}}</textarea>
                                    @error('complemento_da_empresa')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="setor">{{ __('Grupo') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select required class="form-control @error('setor') is-invalid @enderror  @error('cnaes_id') is-invalid @enderror
                                            @error('cnaes_id.*') is-invalid @enderror" id="idSelecionarSetor" onChange="selecionarSetor(this)" name="setor">
                                        <option value="">-- Selecionar o Grupo --</option>
                                        @foreach ($setores as $setor)
                                            <option @if($empresa->cnaes()->exists() && $empresa->cnaes()->first()->setor->id == $setor->id) selected @endif value={{$setor->id}}>{{$setor->nome}}</option>
                                        @endforeach
                                    </select>
                                    @error('setor')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    @error('cnaes_id')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    @error('cnaes_id.*')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="row col-md-12">
                                        <label class="styleTituloDoInputCadastro">Lista de CNAE</label>
                                    </div>
                                    <div class="row col-md-12">
                                        <div style="width:100%; height:400px; display: inline-block; overflow:auto; background-color: #f3f3f3;">
                                            <table id="tabelaCnaes" cellspacing="0" cellpadding="1"width="100%" >
                                                <tbody id="dentroTabelaCnaes"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="styleTituloDoInputCadastro" for="exampleFormControlSelect1">CNAE selecionado</label>
                                    <div style="width:100%; height:400px; display: inline-block; overflow:auto; background-color: #f3f3f3;">
                                        <table cellspacing="0" cellpadding="1"width="100%" >
                                            <tbody class="areaMeusCnaes" id="listaCnaes">
                                                @foreach ($empresa->cnaes as $cnae)
                                                    <div id="cnaeCard_{{$cnae->setor->id}}_{{$cnae->id}}" class="d-flex justify-content-center card-cnae" onmouseenter="mostrarBotaoAdicionar('{{$cnae->id}}')">
                                                        <div class="mr-auto p-2" id="{{$cnae->id}}">{{$cnae->nome}}</div>
                                                        <div style="width:140px; height:25px; text-align:right;">
                                                            <div id="cardSelecionado{{$cnae->id}}" class="btn-group" style="display:none;">
                                                                <div id="botaoCardSelecionado{{$cnae->id}}" class="btn btn-danger btn-sm"  onclick="add_Lista('{{$cnae->setor->id}}', '{{$cnae->id}}')" >Remover</div>
                                                            </div>
                                                        </div>
                                                        <input id ="inputCnae_{{$cnae->id}}" type="hidden" name="cnaes_id[]" value="{{$cnae->id}}">
                                                    </div>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="col-md-6 form-group"></div>
                            <div class="col-md-6 form-group">
                                <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" style="width: 100%;" form="form-editar-empresa">Salvar</button>
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

    <script>
        $(document).ready(function($) {
            selecionarSetor();
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

        function exibirModal() {
            $('#btn-modal-aviso').click();
        }

        function exibirModalCep() {
            $('#btn-modal-cep-nao-encontrado').click();
        }
    </script>
    @endsection
</x-app-layout>
