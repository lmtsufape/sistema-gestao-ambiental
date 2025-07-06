<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-10">
                        <h4 class="card-title">Cadastrar uma empresa/serviço</h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('empresas.index')}}">Empresas</a> > Criar empresa/serviço</h6>
                    </div>
                    <div class="col-md-2">
                        {{-- <a title="Voltar" href="{{route('empresas.index')}}">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a> --}}
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#xmlModal">Importar via XML</button>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-borda-esquerda" style="width: 100%;">
                    <div class="card-body">
                        <form id="form-cadastrar-empresa" method="POST" action="{{route('empresas.store')}}">
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
                                <div class="col-md-12 form-group">
                                    <label for="nome_empresa">{{ __('Razão social/Nome') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="nome_empresa" class="form-control @error('nome_da_empresa') is-invalid @enderror" type="text" name="nome_da_empresa" value="{{old('nome_da_empresa') ?? $empresa->nome ?? ''}}" required autofocus autocomplete="nome_empresa">
                                    @error('nome_da_empresa')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div id="selecionar-cpf-cnpj" class="col-md-6 form-group">
                                    <label for="tipo_de_pessoa">{{ __('Tipo de pessoa') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select id="tipo_de_pessoa" class="form-control @error('tipo_de_pessoa') is-invalid @enderror" name="tipo_de_pessoa" required autocomplete="tipo_de_pessoa">
                                        <option disabled selected value="">-- Selecione o tipo de pessoa --</option>
                                        <option @if(old('tipo_de_pessoa') == "física") selected @endif value="física">Pessoa física</option>
                                        <option @if(old('tipo_de_pessoa') == "jurídica" || !empty($empresa->cnpj)) selected @endif value="jurídica">Pessoa jurídica</option>
                                    </select>
                                    @error('tipo_de_pessoa')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group d-none" id="div-cnpj">
                                    <label for="cnpj">{{ __('CNPJ') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="cnpj" class="form-control @error('cnpj') is-invalid @enderror" type="text" name="cnpj" value="{{old('cnpj') ?? $empresa->cnpj ?? ''}}" autocomplete="cnpj">

                                    @error('cnpj')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group d-none" id="div-cpf">
                                    <label for="cpf">{{ __('CPF') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="cpf" class="form-control @error('cpf') is-invalid @enderror" type="text" name="cpf" value="{{old('cpf')}}" autocomplete="cpf">
                                    @error('cpf')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-2 d-none" id="div-btn-troca">
                                    <button type="button" id="trocar" class="btn btn-success btn-color-dafault w-75 h-50">Trocar</button>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="celular_da_empresa">{{ __('Contato') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="celular_da_empresa" class="form-control celular @error('celular_da_empresa') is-invalid @enderror" type="text" name="celular_da_empresa" value="{{old('celular_da_empresa') ?? $empresa->contato ?? ''}}" required autocomplete="celular">
                                    @error('celular_da_empresa')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="cep_da_empresa">{{ __('CEP') }}<span class="text-danger">*</span></label>
                                    <input id="cep_da_empresa"
                                           name="cep_da_empresa"
                                           type="text"
                                           class="form-control cep @error('cep_da_empresa') is-invalid @enderror"
                                           value="{{ old('cep_da_empresa') ?? $empresa->cep ?? '' }}"
                                           required
                                           onblur="pesquisacepEmpresa(this.value);">
                                    @error('cep_da_empresa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="bairro_da_empresa">{{ __('Bairro') }}<span class="text-danger">*</span></label>
                                    <input id="bairro_da_empresa"
                                           name="bairro_da_empresa"
                                           type="text"
                                           class="form-control @error('bairro_da_empresa') is-invalid @enderror"
                                           value="{{ old('bairro_da_empresa') ?? $empresa->bairro ?? '' }}"
                                           required>
                                    @error('bairro_da_empresa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="rua_da_empresa">{!! __('Logradouro <small>(Rua, Avenida...)</small>') !!}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="rua_da_empresa" class="form-control @error('rua_da_empresa') is-invalid @enderror" type="text" name="rua_da_empresa" value="{{$empresa->logradouro ?? old('rua_da_empresa')}}" required autocomplete="rua_da_empresa">
                                    @error('rua_da_empresa')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="numero_da_empresa">{{ __('Número') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="numero_da_empresa" class="form-control @error('numero_da_empresa') is-invalid @enderror" type="text" name="numero_da_empresa" value="{{$empresa->numero ?? old('numero_da_empresa')}}" required autocomplete="numero_da_empresa">
                                    @error('numero_da_empresa')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="cidade_da_empresa">{{ __('Cidade') }}<span class="text-danger">*</span></label>
                                    <input id="cidade_da_empresa"
                                           name="cidade_da_empresa"
                                           type="text"
                                           class="form-control @error('cidade_da_empresa') is-invalid @enderror"
                                           value="{{ old('cidade_da_empresa') ?? $empresa->cidade ?? '' }}"
                                           required>
                                    @error('cidade_da_empresa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="estado_da_empresa">{{ __('Estado') }}<span class="text-danger">*</span></label>
                                    <select id="estado_da_empresa"
                                            name="estado_da_empresa"
                                            class="form-control @error('estado_da_empresa') is-invalid @enderror"
                                            required>
                                        <option value="" hidden>-- Selecione o UF --</option>
                                        @foreach ([
                                            'AC','AL','AP','AM','BA','CE','DF','ES','GO','MA',
                                            'MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN',
                                            'RS','RO','RR','SC','SP','SE','TO'
                                        ] as $uf)
                                            <option value="{{ $uf }}"
                                                {{ (old('estado_da_empresa') ?? $empresa->estado ?? '') === $uf ? 'selected' : '' }}>
                                                {{ $uf }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('estado_da_empresa')
                                    <div class="invalid-feedback">{{ $message }}</div>
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
                                <div class="col-md-6 form-group">
                                    <label for="porte">{{ __('Porte') }}<span style="color: red; font-weight: bold;">*</span></label> <a href="{{route('info.porte')}}" title="Como classificar o porte?" target="_blanck">(como classificar o porte?)</a>
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
                                <div class="form-group col-md-6">
                                    <label for="setor">{{ __('Grupo') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select required class="form-control @error('setor') is-invalid @enderror" id="setor" name="setor">
                                        <option value="" disabled selected>-- Selecionar o Grupo --</option>
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
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="row col-md-12">
                                        <label class="styleTituloDoInputCadastro">Lista de CNAE</label>
                                    </div>
                                    <div class="row col-md-12">
                                        <div class="alert alert-warning" role="alert" style="width: 100%;">
                                            <h5 class="alert-heading">Aviso!</h5>
                                            <p class="mb-0">Caso a sua empresa/serviço não possua um cnae adequado entre os listados, selecione o cnae "Atividades similares" do grupo que ela faz parte.</p>
                                        </div>
                                    </div>
                                    <div class="row col-md-12">
                                        <ul id="lista_esquerda" style="width:100%; height:250px; display: inline-block; overflow:auto; background-color: #f3f3f3;"></ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="styleTituloDoInputCadastro" for="exampleFormControlSelect1">CNAE selecionado</label>
                                    <ul class="areaMeusCnaes" id="lista_direita" style="width:100%; height:396px; display: inline-block; overflow:auto; background-color: #f3f3f3;">
                                        <input type="hidden" id="cnaes_id" name="cnaes_id" value="{{ old('cnaes_id') }}">
                                    </ul>
                                    @error('cnaes_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="col-md-6 form-group"></div>
                            <div class="col-md-6 form-group">
                                <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" style="width: 100%;" form="form-cadastrar-empresa">Salvar</button>
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
    @push('modals')
        @include('empresa.importacaoModal')
        @include('empresa.comparativoModal')

    @endpush

    @push ('scripts')
        <script>
            window.meu_callback_empresa = function(conteudo) {
                if (!("erro" in conteudo)) {
                    document.getElementById('rua_da_empresa').value    = conteudo.logradouro;
                    document.getElementById('bairro_da_empresa').value = conteudo.bairro;
                    document.getElementById('cidade_da_empresa').value = conteudo.localidade;
                    document.getElementById('estado_da_empresa').value = conteudo.uf;
                } else {
                    limpa_formulario_cep_empresa();
                    $('#aviso-modal-cep-nao-encontrado').modal('show');
                }
            };

            // Dispara a busca via CEP
            window.pesquisacepEmpresa = function(valor) {
                var cep = valor.replace(/\D/g, '');
                if (cep) {
                    var validacep = /^[0-9]{8}$/;
                    if (validacep.test(cep)) {
                        ['rua_da_empresa','bairro_da_empresa','cidade_da_empresa','estado_da_empresa']
                            .forEach(id => document.getElementById(id).value = '…');
                        var script = document.createElement('script');
                        script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback_empresa';
                        document.body.appendChild(script);
                    } else {
                        limpa_formulario_cep_empresa();
                        $('#aviso-modal-cep-invalido').modal('show');
                    }
                } else {
                    limpa_formulario_cep_empresa();
                }
            };

            function limpa_formulario_cep_empresa() {
                ['rua_da_empresa','bairro_da_empresa','cidade_da_empresa','estado_da_empresa']
                    .forEach(id => document.getElementById(id).value = '');
            }
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

                $('#setor').click(function(){
                    var setor_id = $(this).val();
                    $('#lista_esquerda').empty();

                    axios.get("{{ route('ajax.listar.cnaes') }}", {
                        params: {
                            setor_id: setor_id
                        }
                    })
                    .then(response => {
                        for(var i = 0; i < response.data.cnaes.length; i++){
                            var html = `<li id="cnaeCard_`+setor_id+`_`+response.data.cnaes[i].id+`" class="d-flex justify-content-center align-items-center card-cnae">
                                            <div class="mr-auto p-2" id="`+response.data.cnaes[i].id+`">`+response.data.cnaes[i].nome+`</div>

                                            <div id="cardSelecionado`+response.data.cnaes[i].id+`" class="btn-group d-none" style="width:140px; height:40px;">
                                                <button id="${response.data.cnaes[i].id}" class="btn btn-success botao-card" data-setor_id="${setor_id}">Adicionar</button>
                                            </div>
                                        </li>`;
                            if($('#cnaeCard_'+setor_id+'_'+response.data.cnaes[i].id).length === 0){
                                $('#lista_esquerda').append(html);
                            }
                        }
                    })
                })

                $(document).on("click", ".botao-card", function(){
                    event.preventDefault();
                    let elemento = $(this).parent();
                    let tabela_esquerda = $('#lista_esquerda');
                    let btn = $(this);
                    let array = []

                    if(tabela_esquerda.is(elemento.parent().parent())){
                        if ($('#cnaes_id').val()) {
                            array = $('#cnaes_id').val().split(',');
                            array.push($(this).attr('id'));
                        } else {
                            array.push($(this).attr('id'));
                        }
                        $('#cnaes_id').val(array.join(','));
                        $('#lista_direita').append(elemento.parent());
                        btn.text('Remover').addClass('btn-danger').removeClass('btn-success');

                    }else{
                        let id = $(this).attr('id');
                        array = $('#cnaes_id').val().split(',')
                        array = array.filter(function (value){
                            return value !== id;
                        })
                        $('#cnaes_id').val(array.join(','));

                        if($(this).data('setor_id') == $('#setor').val()){
                            $('#lista_esquerda').append(elemento.parent());
                            btn.text('Adicionar').addClass('btn-success').removeClass('btn-danger')

                        }else{
                            elemento.parent().remove();
                        }
                    }
                });

                $(document).on('mouseenter', '.card-cnae', function() {
                    $(this).find('div').eq(1).removeClass('d-none');
                }).on('mouseleave', '.card-cnae', function() {
                    $(this).find('div').eq(1).addClass('d-none');
                });

                $('#tipo_de_pessoa').on('change', function() {
                    mostrar($(this).val());
                });

                if(@json(!empty($empresa->eh_cnpj ?? old('tipo_de_pessoa')))){
                    mostrar($('#tipo_de_pessoa').val())
                }

                function mostrar(elemento){
                    $('#selecionar-cpf-cnpj').addClass('d-none');
                    $('#div-btn-troca').removeClass('d-none');
                    $('#div-btn-troca').addClass(['d-flex', 'align-items-center', 'mt-3'])
                    if (elemento == "física") {
                        $('#div-cpf').removeClass('d-none');
                        $('#div-cnpj').addClass('d-none');
                    } else if(elemento == "jurídica") {
                        $('#div-cpf').addClass('d-none');
                        $('#div-cnpj').removeClass('d-none');
                    }
                }

                $('#trocar').on('click', function(){
                    if (!$('#div-cpf').hasClass('d-none')) {
                        $('#div-cpf').addClass('d-none');
                        $('#cpf').val(null);
                        $('#div-cnpj').removeClass('d-none');
                    } else {
                        $('#div-cpf').removeClass('d-none');
                        $('#cnpj').val(null);
                        $('#div-cnpj').addClass('d-none');
                    }
                })

                function meu_callback_empresa(conteudo) {
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

                if (performance.navigation.type === 1) {
                    // Se a página for recarregada
                    window.location.href = "{{ route('empresas.create') }}";
                }
            });


        </script>
    @endpush
    @endsection
</x-app-layout>
