<x-app-layout>
    @section('content')
    <div class="container container-profile" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="container">
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div class="row">
                    <div class="col-md-2 form-group justify-content-center">
                        <img id="photo"src="{{auth()->user()->profile_photo_path != null ? asset('storage/'.auth()->user()->profile_photo_path) : asset('img/user_img_perfil.png')}}" alt="Imagem de perfil">
                        <div id="selecionar" onclick="editarFoto()">
                            Editar
                        </div>
                        <div class="form-photo-profile" style="display: none;">
                            <input id="photo_input" type="file" name="foto_de_perfil" form="form-alterar-dados-basicos">
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="row" style="margin-top: 10px;">
                            <label class="title-profile">{{auth()->user()->name}}</label>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <label class="subtitle-profile">Usuário</label>

                            @error('foto_de_perfil')
                                <div id="validationServer03Feedback" class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif
            <br>
            <div class="row">
                <div class="col-md-6">
                    <form id="form-alterar-dados-basicos" method="POST" action="{{route('usuarios.dados')}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col-md-11">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <h4 class="subtitle-form">DADOS BÁSICOS</h4>
                                    </div>
                                </div>
                                @if(session('success_dados_basicos'))
                                    <div class="form-row">
                                        <div class="col-md-12" style="margin-top: 5px;">
                                            <div class="alert alert-success" role="alert" style="display: block;">
                                                <p>{{session('success_dados_basicos')}}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <br>
                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <label for="nome_de_exibição">Nome de exibição</label>
                                        <input type="text" id="nome_de_exibição" name="nome_de_exibição" class="form-control apenas_letras @error('nome_de_exibição') is-invalid @enderror" value="{{old('nome_de_exibição', auth()->user()->name)}}">

                                        @error('nome_de_exibição')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <label for="rg">RG</label>
                                        <input type="text" id="rg" name="rg" class="form-control @error('rg') is-invalid @enderror" @if(auth()->user()->requerente != null) value="{{old('rg', auth()->user()->requerente->rg)}}"@else value="" disabled @endif>

                                        @error('rg')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <label for="orgao_emissor">Orgão emissor</label>
                                        <input type="text" id="orgão_emissor" name="orgão_emissor" class="form-control @error('orgão_emissor') is-invalid @enderror"  @if(auth()->user()->requerente != null) value="{{old('orgão_emissor', auth()->user()->requerente->orgao_emissor)}}" @else value="" disabled @endif>

                                        @error('orgão_emissor')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <label for="cpf">CPF</label>
                                        <input type="text" id="cpf" name="cpf" class="form-control @error('cpf') is-invalid @enderror"  @if(auth()->user()->requerente != null) value="{{old('cpf', auth()->user()->requerente->cpf)}}" @else value="" disabled @endif>

                                        @error('cpf')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <label for="telefone">Telefone</label>
                                        <input type="text" id="telefone" name="telefone" class="form-control celular @error('telefone') is-invalid @enderror"  @if(auth()->user()->requerente != null) value="{{old('telefone', auth()->user()->requerente->telefone->numero)}}" @else value="" disabled @endif>

                                        @error('telefone')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 form-group" style="text-align: right;">
                                        <button type="submit" class="submeterFormBotao btn btn-success btn-color-dafault" style="width: 50%;" form="form-alterar-dados-basicos">Alterar dados</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    @if(auth()->user()->requerente != null)
                        <div class="col-md-12 form-group">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <h4 class="subtitle-form">ENDEREÇO</h4>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="card card-endereco-profile">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <h5 class="title-card">Pessoal</h5>
                                            </div>
                                            <div class="col-md-3" style="text-align: right;">
                                            <button class="card-edit" data-toggle="modal" data-target="#modal-editar-endereco" style="cursor: pointer;"><span id="edit-endereco-pessoal">EDITAR</span></button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if(auth()->user()->requerente != null)
                                                    {{auth()->user()->requerente->endereco->rua}}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if(auth()->user()->requerente != null)
                                                    Número: {{auth()->user()->requerente->endereco->numero}}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if(auth()->user()->requerente != null)
                                                    CEP {{auth()->user()->requerente->endereco->cep}} - {{auth()->user()->requerente->endereco->cidade}}, {{auth()->user()->requerente->endereco->estado}}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <br>
            @if(auth()->user()->requerente != null)
                <div class="row">
                    <div class="col-md-12 form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <h5 class="subtitle-form">ENDEREÇO(S) DA(S) EMPRESA(S)/SERVIÇO(S)</h5>
                            </div>
                        </div>
                    </div>
                    @foreach (auth()->user()->empresas as $empresa)
                        <div class="col-md-6">
                            <div class="form-row">
                                <div class="col-md-11">
                                    <div class="card card-endereco-profile">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <h5 class="title-card">{{$empresa->nome}}</h5>
                                                </div>
                                                <div class="col-md-3" style="text-align: right;">
                                                    <button class="card-edit" onclick="window.location='{{route('empresas.edit', ['empresa' => $empresa])}}'"><span>EDITAR</span></button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    {{$empresa->endereco->rua}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    Número: {{$empresa->endereco->numero}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    CEP {{$empresa->endereco->cep}} - {{$empresa->endereco->cidade}}, {{$empresa->endereco->estado}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @if(auth()->user()->requerente != null)
    <div class="modal fade" id="modal-editar-endereco" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: var(--primaria);">
                    <h5 class="modal-title text-white">Atualizar endereço pessoal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-atualizar-endereco" method="POST" action="{{route('usuarios.atualizar.endereco')}}">
                        @csrf
                        @method('PUT')
                        <div class="container">
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="cep">CEP</label>
                                    <input id="cep" name="cep" type="text" class="form-control cep @error('cep') is-invalid @enderror" value="{{old('cep', auth()->user()->requerente->endereco->cep)}}" onblur="pesquisacep(this.value);">

                                    @error('cep')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-8 form-group">
                                    <label for="rua">Rua</label>
                                    <input id="rua" name="rua" type="text" class="form-control @error('rua') is-invalid @enderror" value="{{old('rua', auth()->user()->requerente->endereco->rua)}}">

                                    @error('rua')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="número">Número</label>
                                    <input id="número" name="número" type="text" class="form-control @error('número') is-invalid @enderror" value="{{old('número', auth()->user()->requerente->endereco->numero)}}">

                                    @error('número')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="bairro">Bairro</label>
                                    <input id="bairro" name="bairro" type="text" class="form-control @error('bairro') is-invalid @enderror" value="{{old('bairro', auth()->user()->requerente->endereco->bairro)}}">

                                    @error('bairro')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="cidade">Cidade</label>
                                    <input id="cidade" name="cidade" type="text" class="form-control @error('cidade') is-invalid @enderror" value="{{old('cidade', auth()->user()->requerente->endereco->cidade)}}">

                                    @error('cidade')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="uf">Estado</label>
                                    <select id="uf" class="form-control @error('uf') is-invalid @enderror" type="text" required autocomplete="estado" name="uf">
                                        <option value="" selected disabled >-- Selecione o UF --</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'AC') selected @endif value="AC">Acre</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'AL') selected @endif value="AL">Alagoas</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'AP') selected @endif value="AP">Amapá</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'AM') selected @endif value="AM">Amazonas</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'BA') selected @endif value="BA">Bahia</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'CE') selected @endif value="CE">Ceará</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'DF') selected @endif value="DF">Distrito Federal</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'ES') selected @endif value="ES">Espírito Santo</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'GO') selected @endif value="GO">Goiás</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'MA') selected @endif value="MA">Maranhão</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'MT') selected @endif value="MT">Mato Grosso</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'MS') selected @endif value="MS">Mato Grosso do Sul</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'MG') selected @endif value="MG">Minas Gerais</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'PA') selected @endif value="PA">Pará</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'PB') selected @endif value="PB">Paraíba</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'PR') selected @endif value="PR">Paraná</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'PE') selected @endif value="PE">Pernambuco</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'PI') selected @endif value="PI">Piauí</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'RJ') selected @endif value="RJ">Rio de Janeiro</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'RN') selected @endif value="RN">Rio Grande do Norte</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'RS') selected @endif value="RS">Rio Grande do Sul</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'RO') selected @endif value="RO">Rondônia</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'RR') selected @endif value="RR">Roraima</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'SC') selected @endif value="SC">Santa Catarina</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'SP') selected @endif value="SP">São Paulo</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'SE') selected @endif value="SE">Sergipe</option>
                                        <option @if(old('uf', auth()->user()->requerente->endereco->estado) == 'TO') selected @endif value="TO">Tocantins</option>
                                    </select>

                                    @error('bairro')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="complemento">Cidade</label>
                                    <textarea id="complemento" name="complemento" type="text" class="form-control @error('complemento') is-invalid @enderror">{{old('complemento', auth()->user()->requerente->endereco->complemento)}}</textarea>

                                    @error('complemento')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="submeterFormBotao btn btn-success btn-color-dafault" form="form-atualizar-endereco">Salvar</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @push ('scripts')
        <script>
            function editarFoto() {
                $('#photo_input').click();
            }

            function preview() {
                if (this.files && this.files[0]) {
                    var file = new FileReader();
                    file.onload = function(e) {
                        document.getElementById("photo").src = e.target.result;
                    };
                    file.readAsDataURL(this.files[0]);
                }
            }

            document.getElementById("photo_input").addEventListener("change", preview, false);

            function limpa_formulario_cep() {
                //Limpa valores do formulário de cep.
                document.getElementById('rua').value=("");
                document.getElementById('bairro').value=("");
                document.getElementById('cidade').value=("");
                document.getElementById('uf').value=("");
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
                    limpa_formulario_cep();
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
                        limpa_formulario_cep();
                        exibirModalCepInvalido();;
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulario_cep();
                }
            }

            function exibirModalCep() {
                $('#btn-modal-cep-nao-encontrado').click();
            }

            function exibirModalCepInvalido() {
                $('#btn-modal-cep-invalido').click();
            }

            $(document).ready(function() {
                $('#cpf').mask('000.000.000-00');
                $('#rg').mask('00000000');
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
        </script>
        @if (old('rua') != null)
            <script>
                $(document).ready(function(){
                    $('#edit-endereco-pessoal').click();
                });
            </script>
        @endif
    @endpush
    @endsection
</x-app-layout>
