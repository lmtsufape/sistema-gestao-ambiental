@guest
<x-guest-layout>

    <div class="container" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Realizar solicitação de poda/supressão</h4>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        {{-- <a class="btn my-2" href="{{route('podas.requerente.index')}}" style="cursor: pointer;"><img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}"  alt="Voltar" title="Voltar"></a> --}}
                        <a class="btn btn-success btn-color-dafault" data-toggle="modal"
                            data-target="#modalAcompanharSolicitacao">Acompanhar solicitação
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div div class="form-row">
                            @if (session('success'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-success" role="alert">
                                        <p>{{ session('success') }}</p>
                                    </div>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-danger" role="alert">
                                        <p>{{ session('error') }}</p>
                                    </div>
                                </div>
                            @endif
                            @if (session('success'))
                                @push ('scripts')
                                    <script>
                                        $(function() {
                                            jQuery.noConflict();
                                            $('#modalProtocolo').modal('show');
                                        });
                                    </script>
                                @endpush
                            @endif
                        </div>
                        <form method="POST" id="cria-solicitacao" action="{{ route('podas.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="cep">{{ __('CEP') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="cep" class="form-control cep @error('cep') is-invalid @enderror" type="text" name="cep" value="{{old('cep')}}" required autofocus autocomplete="cep" onblur="pesquisacep(this.value);">
                                    @error('cep')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="bairro">{{ __('Bairro') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="bairro" class="form-control @error('bairro') is-invalid @enderror" type="text" name="bairro" value="{{old('bairro')}}" required autofocus autocomplete="bairro">
                                    @error('bairro')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="rua">{{ __('Rua') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="rua" class="form-control @error('rua') is-invalid @enderror" type="text" name="rua" value="{{old('rua')}}" required autocomplete="rua">
                                    @error('rua')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="numero">{{ __('Número') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="numero" class="form-control  @error('numero') is-invalid @enderror" type="text" name="numero" value="{{old('numero')}}" required autocomplete="numero">
                                    @error('numero')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                @php
                                    $areas = App\Models\SolicitacaoPoda::AREA_ENUM;
                                @endphp
                                <div class="col-md-6 form-group">
                                    <label for="area">{{ __('Área') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select class="form-control" @error('area') is-invalid @enderror" type="text" name="area" id="area">
                                        <option value="" selected disabled >-- Selecione a área --</option>
                                        <option @if(old('area') == $areas['publica']) selected @endif value="{{ $areas['publica'] }}">Pública</option>
                                        <option @if(old('area') == $areas['privada']) selected @endif value="{{ $areas['privada'] }}">Privada</option>
                                    </select>
                                    @error('area')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="cidade">{{ __('Cidade') }}</label>
                                    <input id="cidade" class="form-control @error('cidade') is-invalid @enderror" type="text" name="cidade" value="Garanhuns" required autofocus autocomplete="cidade" readonly>
                                    @error('cidade')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="estado">{{ __('Estado') }}</label>
                                    <select id="estado" class="form-control @error('estado') is-invalid @enderror" type="text" readonly required autocomplete="estado" name="estado">
                                        <option selected value="PE">Pernambuco</option>
                                    </select>
                                    @error('estado')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="complemento">{{ __('Complemento/Ponto de referência') }}</label>
                                    <input class="form-control" value="{{old('complemento', '')}}" @error('complemento') is-invalid @enderror" type="text" name="complemento" id="complemento"/>
                                    @error('complemento')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="comentario">{{ __('Poda de árvores (Qual o motivo da solicitação?)') }}</label>
                                    <textarea class="form-control" @error('comentario') is-invalid @enderror" type="text" name="comentario" id="comentario">{{old('comentario', '')}}</textarea>
                                    @error('comentario')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="imagem">{{ __('Anexar imagens') }}</label>
                                </div>
                            </div>
                            <div class="form-row">
                                <button type="button" id="btn-add-imagem"
                                    onclick="addImagem()"
                                    class="btn btn-primary btn-color-dafault"
                                    style="margin-top:10px; margin-bottom:10px;">
                                    Adicionar Imagem
                                </button>
                            </div>
                            <div id="imagens" class="form-row">
                                @if ($errors->has('imagem.*') && $errors->has('comentarios.*'))
                                    @foreach ($errors->get('imagem.*') as $i => $images)
                                        @foreach ($images as $b => $opcao)
                                            <div class="col-md-5" style="margin: 10px 10px 0 0;">
                                                <label for="imagem">{{ __('Selecione a imagem') }}</label>
                                                <input type="file" class="@error('imagem.'.$b) is-invalid @enderror" name="imagem[]" id="imagem" accept="image/*">
                                                @error('imagem.*'.$b)
                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                        {{ $opcao }}
                                                    </div>
                                                @enderror
                                        @endforeach
                                    @endforeach
                                    @foreach ($errors->get('comentarios.*') as $i => $comentarios)
                                        @foreach ($comentarios as $b => $opcao)
                                                <label for="comentarios" style="margin-right: 10px;">{{ __('Comentário') }}     </label>
                                                <input type="text" class="form-control @error('comentarios.'.$b) is-invalid @enderror" name="comentarios[]" id="comentarios">
                                                @error('comentarios.'.$b)
                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                        {{ $opcao }}
                                                    </div>
                                                @enderror
                                                <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Remover imagem</button>
                                            </div>
                                        @endforeach
                                    @endforeach
                                @else
                                    @if($errors->has('imagem.*'))
                                        @foreach ($errors->get('imagem.*') as $i => $images)
                                            @foreach ($images as $b => $opcao)
                                                <div class="col-md-5" style="margin: 10px 10px 0 0;">
                                                    <label for="imagem">{{ __('Selecione a imagem') }}</label>
                                                    <input type="file" class="@error('imagem.'.$b) is-invalid @enderror" name="imagem[]" id="imagem" accept="image/*">
                                                    @error('imagem.*'.$b)
                                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                                            {{ $opcao }}
                                                        </div>
                                                    @enderror
                                                    <label for="comentarios" style="margin-right: 10px;">{{ __('Comentário') }}</label>
                                                    <input type="text" class="form-control" name="comentarios[]" id="comentarios">
                                                    <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Remover imagem</button>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    @else
                                        @foreach ($errors->get('comentarios.*') as $i => $comentarios)
                                            @foreach ($comentarios as $b => $opcao)
                                                <div class="col-md-5" style="margin: 10px 10px 0 0;">
                                                    <label for="imagem">{{ __('Selecione a imagem') }}</label>
                                                    <input type="file" class="@error('imagem.'.$b) is-invalid @enderror" name="imagem[]" id="imagem" accept="image/*">
                                                    <label for="comentarios" style="margin-right: 10px;">{{ __('Comentário') }}     </label>
                                                    <input type="text" class="form-control @error('comentarios.'.$b) is-invalid @enderror" name="comentarios[]" id="comentarios">
                                                    @error('comentarios.'.$b)
                                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                                            {{ $opcao }}
                                                        </div>
                                                    @enderror
                                                    <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Remover imagem</button>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    @endif
                                @endif
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group"></div>
                                <div class="col-md-6 form-group">
                                    <button type="submit" class="submeterFormBotao btn btn-success btn-color-dafault"
                                        style="width: 100%;">Confirmar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="modalProtocolo" role="dialog" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #dcd935;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: rgb(66, 66, 66);">Protocolo da
                        solicitação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="word-break: break-all">
                    Anote o seguinte protocolo para acompanhar o status da solicitação
                    <br>
                    Protocolo:
                    <strong>{{ session('protocolo') }}</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal acompanhar solicitacao -->
    <div class="modal fade" id="modalAcompanharSolicitacao" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: var(--primaria);">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Acompanhe o status da sua
                        solicitação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="status-solicitacao" method="GET" action="{{ route('podas.status') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <label for="protocolo">{{ __('Protocolo') }}</label>
                                <input id="protocolo" class="form-control @error('protocolo') is-invalid @enderror"
                                    type="text" name="protocolo" value="{{ old('protocolo') }}" required autofocus
                                    autocomplete="protocolo">
                                @error('protocolo')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="submeterFormBotao btn btn-success btn-color-dafault" form="status-solicitacao">Ir</button>
                </div>
            </div>
        </div>
    </div>

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
                    O cadastro não está disponivel para solicitações fora do municipio de garanhuns!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-color-dafault" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    @push ('scripts')
        <script>
            function addImagem() {
                var campo_imagem = `<div class="card shadow bg-white" style="width: 50%;">
                                        <div class="card-body">
                                            <label for="imagem">{{ __('Selecione a imagem') }}</label><br>
                                            <input type="file" name="imagem[]" id="imagem" accept="image/*"><br>
                                            <label for="comentarios" style="margin-right: 10px;">{{ __('Comentário') }}</label>
                                            <textarea type="text" class="form-control" name="comentarios[]" id="comentarios"></textarea>
                                            <button type="button" onclick="this.parentElement.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Remover imagem</button>
                                        </div>
                                    </div>`;

                $('#imagens').append(campo_imagem);
            }

            function pesquisacep(valor) {
                rural = trim(str_replace('-', valor));
                //Nova variável "cep" somente com dígitos.
                var cep = valor.replace(/\D/g, '');
                //Verifica se campo cep possui valor informado.
                if (cep != "") {
                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;
                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {
                         
                        if(rural != "899"){
                        //Preenche os campos com "..." enquanto consulta webservice.
                        document.getElementById('rua').value="...";
                        document.getElementById('bairro').value="...";
                        //Cria um elemento javascript.
                        var script = document.createElement('script');
                        //Sincroniza com o callback.
                        script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
                        //Insere script no documento e carrega o conteúdo.
                        document.body.appendChild(script);
                        }
                        else{
                            exibirModalAreaRural();
                        }

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

            function limpa_formulário_cep() {
                //Limpa valores do formulário de cep.
                document.getElementById('cep').value=("");
                document.getElementById('rua').value=("");
                document.getElementById('bairro').value=("");
            }

            function exibirModalCepInvalido() {
                jQuery.noConflict();
                $('#aviso-modal-fora').modal('show');
            }

            function exibirModalAreaRural() {
                $('#btn-modal-cep-invalido').click();
            }

            function meu_callback(conteudo) {
                if (!("erro" in conteudo)) {
                    //Atualiza os campos com os valores.
                    document.getElementById('rua').value=(conteudo.logradouro);
                    document.getElementById('bairro').value=(conteudo.bairro);
                    console.log(conteudo.localidade);
                    if (conteudo.localidade != "Garanhuns" || conteudo.uf != "PE") {
                        exibirModalCepInvalido();
                        limpa_formulário_cep();
                    }
                }
                else {
                    limpa_formulário_cep();
                }
            }
        </script>
    @endpush
</x-guest-layout>
@else
<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Realizar solicitação de poda/supressão</h4>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        {{-- <a class="btn my-2" href="{{route('podas.requerente.index')}}" style="cursor: pointer;"><img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}"  alt="Voltar" title="Voltar"></a> --}}
                        <a class="btn btn-success btn-color-dafault" data-toggle="modal"
                            data-target="#modalAcompanharSolicitacao">Acompanhar solicitação
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div div class="form-row">
                            @if (session('success'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-success" role="alert">
                                        <p>{{ session('success') }}</p>
                                    </div>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-danger" role="alert">
                                        <p>{{ session('error') }}</p>
                                    </div>
                                </div>
                            @endif
                            @if (session('success'))
                                @push ('scripts')
                                    <script>
                                        $(function() {
                                            jQuery.noConflict();
                                            $('#modalProtocolo').modal('show');
                                        });
                                    </script>
                                @endpush
                            @endif
                        </div>
                        <form method="POST" id="cria-solicitacao" action="{{ route('podas.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="cep">{{ __('CEP') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="cep" class="form-control cep @error('cep') is-invalid @enderror" type="text" name="cep" value="{{old('cep')}}" required autofocus autocomplete="cep" onblur="pesquisacep(this.value);">
                                    @error('cep')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="bairro">{{ __('Bairro') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="bairro" class="form-control @error('bairro') is-invalid @enderror" type="text" name="bairro" value="{{old('bairro')}}" required autofocus autocomplete="bairro">
                                    @error('bairro')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="rua">{{ __('Rua') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="rua" class="form-control @error('rua') is-invalid @enderror" type="text" name="rua" value="{{old('rua')}}" required autocomplete="rua">
                                    @error('rua')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="numero">{{ __('Número') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="numero" class="form-control  @error('numero') is-invalid @enderror" type="text" name="numero" value="{{old('numero')}}" required autocomplete="numero">
                                    @error('numero')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                @php
                                    $areas = App\Models\SolicitacaoPoda::AREA_ENUM;
                                @endphp
                                <div class="col-md-6 form-group">
                                    <label for="area">{{ __('Área') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select class="form-control" @error('area') is-invalid @enderror" type="text" name="area" id="area">
                                        <option value="" selected disabled >-- Selecione a área --</option>
                                        <option @if(old('area') == $areas['publica']) selected @endif value="{{ $areas['publica'] }}">Pública</option>
                                        <option @if(old('area') == $areas['privada']) selected @endif value="{{ $areas['privada'] }}">Privada</option>
                                    </select>
                                    @error('area')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="cidade">{{ __('Cidade') }}</label>
                                    <input id="cidade" class="form-control @error('cidade') is-invalid @enderror" type="text" name="cidade" value="Garanhuns" required autofocus autocomplete="cidade" readonly>
                                    @error('cidade')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="estado">{{ __('Estado') }}</label>
                                    <select id="estado" class="form-control @error('estado') is-invalid @enderror" type="text" readonly required autocomplete="estado" name="estado">
                                        <option selected value="PE">Pernambuco</option>
                                    </select>
                                    @error('estado')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="celular">{{ __('Contato') }}</label>
                                    <input id="celular" class="form-control celular @error('celular') is-invalid @enderror" type="text" name="celular" value="{{old('celular')}}" autocomplete="celular" placeholder="(00) 00000-0000">
                                    @error('celular')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    </div>

                                <div class="col-md-12 form-group">
                                    <label for="complemento">{{ __('Complemento/Ponto de referência') }}</label>
                                    <input class="form-control" value="{{old('complemento', '')}}" @error('complemento') is-invalid @enderror" type="text" name="complemento" id="complemento"/>
                                    @error('complemento')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="comentario">{{ __('Poda de árvores (Qual o motivo da solicitação?)') }}</label>
                                    <textarea class="form-control" @error('comentario') is-invalid @enderror" type="text" name="comentario" id="comentario">{{old('comentario', '')}}</textarea>
                                    @error('comentario')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="imagem">{{ __('Anexar imagens') }}</label>
                                </div>
                            </div>
                            <div class="form-row">
                                <button type="button" id="btn-add-imagem"
                                    onclick="addImagem()"
                                    class="btn btn-primary btn-color-dafault"
                                    style="margin-top:10px; margin-bottom:10px;">
                                    Adicionar Imagem
                                </button>
                            </div>
                            <div id="imagens" class="form-row">
                                @if ($errors->has('imagem.*') && $errors->has('comentarios.*'))
                                    @foreach ($errors->get('imagem.*') as $i => $images)
                                        @foreach ($images as $b => $opcao)
                                            <div class="col-md-5" style="margin: 10px 10px 0 0;">
                                                <label for="imagem">{{ __('Selecione a imagem') }}</label>
                                                <input type="file" class="@error('imagem.'.$b) is-invalid @enderror" name="imagem[]" id="imagem" accept="image/*">
                                                @error('imagem.*'.$b)
                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                        {{ $opcao }}
                                                    </div>
                                                @enderror
                                        @endforeach
                                    @endforeach
                                    @foreach ($errors->get('comentarios.*') as $i => $comentarios)
                                        @foreach ($comentarios as $b => $opcao)
                                                <label for="comentarios" style="margin-right: 10px;">{{ __('Comentário') }}     </label>
                                                <input type="text" class="form-control @error('comentarios.'.$b) is-invalid @enderror" name="comentarios[]" id="comentarios">
                                                @error('comentarios.'.$b)
                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                        {{ $opcao }}
                                                    </div>
                                                @enderror
                                                <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Remover imagem</button>
                                            </div>
                                        @endforeach
                                    @endforeach
                                @else
                                    @if($errors->has('imagem.*'))
                                        @foreach ($errors->get('imagem.*') as $i => $images)
                                            @foreach ($images as $b => $opcao)
                                                <div class="col-md-5" style="margin: 10px 10px 0 0;">
                                                    <label for="imagem">{{ __('Selecione a imagem') }}</label>
                                                    <input type="file" class="@error('imagem.'.$b) is-invalid @enderror" name="imagem[]" id="imagem" accept="image/*">
                                                    @error('imagem.*'.$b)
                                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                                            {{ $opcao }}
                                                        </div>
                                                    @enderror
                                                    <label for="comentarios" style="margin-right: 10px;">{{ __('Comentário') }}</label>
                                                    <input type="text" class="form-control" name="comentarios[]" id="comentarios">
                                                    <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Remover imagem</button>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    @else
                                        @foreach ($errors->get('comentarios.*') as $i => $comentarios)
                                            @foreach ($comentarios as $b => $opcao)
                                                <div class="col-md-5" style="margin: 10px 10px 0 0;">
                                                    <label for="imagem">{{ __('Selecione a imagem') }}</label>
                                                    <input type="file" class="@error('imagem.'.$b) is-invalid @enderror" name="imagem[]" id="imagem" accept="image/*">
                                                    <label for="comentarios" style="margin-right: 10px;">{{ __('Comentário') }}     </label>
                                                    <input type="text" class="form-control @error('comentarios.'.$b) is-invalid @enderror" name="comentarios[]" id="comentarios">
                                                    @error('comentarios.'.$b)
                                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                                            {{ $opcao }}
                                                        </div>
                                                    @enderror
                                                    <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Remover imagem</button>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    @endif
                                @endif
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group"></div>
                                <div class="col-md-6 form-group">
                                    <button type="submit" class="submeterFormBotao btn btn-success btn-color-dafault"
                                        style="width: 100%;">Confirmar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="modalProtocolo" role="dialog" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #dcd935;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: rgb(66, 66, 66);">Protocolo da
                        solicitação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="word-break: break-all">
                    Anote o seguinte protocolo para acompanhar o status da solicitação
                    <br>
                    Protocolo:
                    <strong>{{ session('protocolo') }}</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal acompanhar solicitacao -->
    <div class="modal fade" id="modalAcompanharSolicitacao" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: var(--primaria);">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Acompanhe o status da sua
                        solicitação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="status-solicitacao" method="GET" action="{{ route('podas.status') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <label for="protocolo">{{ __('Protocolo') }}</label>
                                <input id="protocolo" class="form-control @error('protocolo') is-invalid @enderror"
                                    type="text" name="protocolo" value="{{ old('protocolo') }}" required autofocus
                                    autocomplete="protocolo">
                                @error('protocolo')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="submeterFormBotao btn btn-success btn-color-dafault" form="status-solicitacao">Ir</button>
                </div>
            </div>
        </div>
    </div>

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
                    O cadastro não está disponivel para solicitações fora do municipio de garanhuns!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-color-dafault" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    @push ('scripts')
        <script>

            $(document).ready(function($) {
                var SPMaskBehavior = function(val) {
                        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                    },
                    spOptions = {
                        onKeyPress: function(val, e, field, options) {
                            field.mask(SPMaskBehavior.apply({}, arguments), options);
                        }
                    };
                $('.celular').mask(SPMaskBehavior, spOptions);
            });

            function addImagem() {
                var campo_imagem = `<div class="card shadow bg-white" style="width: 50%;">
                                        <div class="card-body">
                                            <label for="imagem">{{ __('Selecione a imagem') }}</label><br>
                                            <input type="file" name="imagem[]" id="imagem" accept="image/*"><br>
                                            <label for="comentarios" style="margin-right: 10px;">{{ __('Comentário') }}</label>
                                            <textarea type="text" class="form-control" name="comentarios[]" id="comentarios"></textarea>
                                            <button type="button" onclick="this.parentElement.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Remover imagem</button>
                                        </div>
                                    </div>`;

                $('#imagens').append(campo_imagem);
            }

            function pesquisacep(valor) {
                rural = trim(str_replace('-', valor));
                //Nova variável "cep" somente com dígitos.
                var cep = valor.replace(/\D/g, '');
                //Verifica se campo cep possui valor informado.
                if (cep != "") {
                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;
                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {
                        //Preenche os campos com "..." enquanto consulta webservice.
                        if(rural != "899"){
                        //Preenche os campos com "..." enquanto consulta webservice.
                        document.getElementById('rua').value="...";
                        document.getElementById('bairro').value="...";
                        //Cria um elemento javascript.
                        var script = document.createElement('script');
                        //Sincroniza com o callback.
                        script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
                        //Insere script no documento e carrega o conteúdo.
                        document.body.appendChild(script);
                        }
                        else{
                            exibirModalAreaRural();
                        }
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

            function limpa_formulário_cep() {
                //Limpa valores do formulário de cep.
                document.getElementById('cep').value=("");
                document.getElementById('rua').value=("");
                document.getElementById('bairro').value=("");
            }

            function exibirModalCepInvalido() {
                jQuery.noConflict();
                $('#aviso-modal-fora').modal('show');
            }
            
            function exibirModalAreaRural() {
                $('#btn-modal-cep-invalido').click();
            }

            function meu_callback(conteudo) {
                if (!("erro" in conteudo)) {
                    //Atualiza os campos com os valores.
                    document.getElementById('rua').value=(conteudo.logradouro);
                    document.getElementById('bairro').value=(conteudo.bairro);
                    console.log(conteudo.localidade);
                    if (conteudo.localidade != "Garanhuns" || conteudo.uf != "PE") {
                        exibirModalCepInvalido();
                        limpa_formulário_cep();
                    }
                }
                else {
                    limpa_formulário_cep();
                }
            }
        </script>
    @endpush
    @endsection
</x-app-layout>

@endguest
