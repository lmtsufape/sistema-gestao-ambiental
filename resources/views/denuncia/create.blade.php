<x-guest-layout>
    @component('layouts.nav_bar')@endcomponent

    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Registrar denúncia</h4>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        <a title="Voltar" href="{{route('welcome')}}">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a>
                        <a class="btn btn-primary btn-color-dafault" data-toggle="modal" data-target="#modalAcompanharDenuncia">Acompanhar denúncia</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div div class="form-row">
                            @if(session('success'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-success" role="alert">
                                        <p>{{session('success')}}</p>
                                    </div>
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-danger" role="alert">
                                        <p>{{session('error')}}</p>
                                    </div>
                                </div>
                            @endif
                            @if(session('success'))
                                <script>
                                    $(function() {
                                        jQuery.noConflict();
                                        $('#modalProtocolo').modal('show');
                                    });
                                </script>
                            @endif
                        </div>
                        <form method="POST" id="cria-denuncia" action="{{route('denuncias.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="empresa">Empresas cadastradas:</label>
                                    <select class="form-control @error('empresa_id') is-invalid @enderror"
                                            name="empresa_id" id="empresas" onChange="showCampoEmpresaNaoCadastrada(this)">
                                        <option disable="" hidden="" selected>-- Selecionar Empresa --</option>
                                        @foreach ($empresas as $empresa)
                                            <option value="{{$empresa->id}}" {{old("empresa_id") == $empresa->id ? 'selected' : ""}}>{{$empresa->nome}}</option>
                                        @endforeach
                                        <option value="none" {{old("empresa_id") == 'none' ? 'selected' : ""}}>Outro</option>
                                    </select>
                                    @error('empresa_id')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row" id="empresa_info">
                                <div id="campo_empresa_nao_cadastrada" @if (!old("empresa_nao_cadastrada")) style="display: none;" @endif
                                        class="col-md-6 form-group">
                                    <label for="empresa_nao_cadastrada">{{ __('Denunciado (Nome da empresa ou pessoa física)') }}</label>
                                    <input id="empresa_nao_cadastrada" class="form-control @error('empresa_nao_cadastrada') is-invalid @enderror" type="text" name="empresa_nao_cadastrada"
                                        value="{{old('empresa_nao_cadastrada')}}">
                                    @error('empresa_nao_cadastrada')
                                        <div id="validationServer02Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div id="campo_endereco_empresa_nao_cadastrada" @if (!old("endereco")) style="display: none;" @endif
                                        class="col-md-6 form-group">
                                    <label for="endereco">{{ __('Endereço') }}</label>
                                    <input id="endereco" class="form-control @error('endereco') is-invalid @enderror" type="text" name="endereco" value="{{old('endereco')}}">
                                     @error('endereco')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="denunciante">{{ __('Seu nome (Opcional)') }}</label>
                                    <input id="denunciante" class="form-control @error('denunciante') is-invalid @enderror" type="text" name="denunciante"
                                        value="{{old('denunciante')}}">
                                    @error('denunciante')
                                        <div id="validationServer02Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <label for="texto">{{ __('Denúncia') }}</label>
                                    <textarea id="denuncia-ckeditor" name="texto"></textarea>
                                    @error('texto')
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
                                <button type="button" id="btn-add-imagem" onclick="addImagem()" class="btn btn-primary btn-color-dafault"
                                    style="margin-top:10px; margin-bottom:10px;">
                                    Adicionar Imagem
                                </button>
                            </div>
                            <div id="imagens" class="form-row">
                                @if ($errors->has('imagem.*') && $errors->has('comentario.*'))
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
                                    @foreach ($errors->get('comentario.*') as $i => $comentarios)
                                        @foreach ($comentarios as $b => $opcao)
                                                <label for="comentarios" style="margin-right: 10px;">{{ __('Comentário') }}     </label>
                                                <input type="text" class="form-control @error('comentario.'.$b) is-invalid @enderror" name="comentario[]" id="comentario">
                                                @error('comentario.'.$b)
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
                                                    <input type="text" class="form-control" name="comentario[]" id="comentario">
                                                    <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Remover imagem</button>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    @else
                                        @foreach ($errors->get('comentario.*') as $i => $comentarios)
                                            @foreach ($comentarios as $b => $opcao)
                                                <div class="col-md-5" style="margin: 10px 10px 0 0;">
                                                    <label for="imagem">{{ __('Selecione a imagem') }}</label>
                                                    <input type="file" class="@error('imagem.'.$b) is-invalid @enderror" name="imagem[]" id="imagem" accept="image/*">
                                                    <label for="comentarios" style="margin-right: 10px;">{{ __('Comentário') }}     </label>
                                                    <input type="text" class="form-control @error('comentario.'.$b) is-invalid @enderror" name="comentario[]" id="comentario">
                                                    @error('comentario.'.$b)
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

                            {{--<div class="form-row">
                                <div class="col-md-6">
                                    <label for="video">{{ __('Anexar videos') }}</label>
                                </div>
                            </div>
                            <div class="form-row">
                                <button type="button" id="btn-add-video" onclick="addVideo()" class="btn btn-primary btn-color-dafault"
                                    style="margin-top:10px; margin-bottom:10px;">
                                    Adicionar Video
                                </button>
                            </div>

                            <div id="videos" class="form-row">
                                @if ($errors->has('video.*') && $errors->has('comentario.*'))
                                    @foreach ($errors->get('video.*') as $i => $videos)
                                        @foreach ($videos as $b => $opcao)
                                            <div class="col-md-5" style="margin: 10px 10px 0 0;">
                                                <label for="video">{{ __('Selecione o video') }}</label>
                                                <input type="file" class="@error('video.'.$b) is-invalid @enderror" name="video[]" id="video">
                                                @error('video.*'.$b)
                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                        {{ $opcao }}
                                                    </div>
                                                @enderror
                                        @endforeach
                                    @endforeach
                                    @foreach ($errors->get('comentario.*') as $i => $comentarios)
                                        @foreach ($comentarios as $b => $opcao)
                                                <label for="comentarios" style="margin-right: 10px;">{{ __('Comentário') }}     </label>
                                                <input type="text" class="form-control @error('comentario.'.$b) is-invalid @enderror" name="comentario[]" id="comentario">
                                                @error('comentario.'.$b)
                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                        {{ $opcao }}
                                                    </div>
                                                @enderror
                                                <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Remover video</button>
                                            </div>
                                        @endforeach
                                    @endforeach
                                @else
                                    @if($errors->has('video.*'))
                                        @foreach ($errors->get('video.*') as $i => $videos)
                                            @foreach ($videos as $b => $opcao)
                                                <div class="col-md-5" style="margin: 10px 10px 0 0;">
                                                    <label for="video">{{ __('Selecione o video') }}</label>
                                                    <input type="file" class="@error('video.'.$b) is-invalid @enderror" name="video[]" id="video">
                                                    @error('video.*'.$b)
                                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                                            {{ $opcao }}
                                                        </div>
                                                    @enderror
                                                    <label for="comentarios" style="margin-right: 10px;">{{ __('Comentário') }}</label>
                                                    <input type="text" class="form-control" name="comentario[]" id="comentario">
                                                    <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Remover video</button>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    @else
                                        @foreach ($errors->get('comentario.*') as $i => $comentarios)
                                            @foreach ($comentarios as $b => $opcao)
                                                <div class="col-md-5" style="margin: 10px 10px 0 0;">
                                                    <label for="video">{{ __('Selecione o video') }}</label>
                                                    <input type="file" class="@error('video.'.$b) is-invalid @enderror" name="video[]" id="video">
                                                    <label for="comentarios" style="margin-right: 10px;">{{ __('Comentário') }}     </label>
                                                    <input type="text" class="form-control @error('comentario.'.$b) is-invalid @enderror" name="comentario[]" id="comentario">
                                                    @error('comentario.'.$b)
                                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                                            {{ $opcao }}
                                                        </div>
                                                    @enderror
                                                    <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Remover video</button>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    @endif
                                @endif
                            </div>--}}

                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="alert alert-warning" role="alert">
                                        <h5 class="alert-heading">Envio de vídeos</h5>
                                        <hr>
                                        <p class="mb-0">Caso precise enviar algum vídeo, pedimos para que seja enviado no endereço exemplo@gov.com.br. Manteremos o anonimato do denunciante.</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6" style="text-align: right">
                                <button type="submit" id="submeterFormBotao" class="btn btn-success btn-color-dafault submeterFormBotao" form="cria-denuncia" style="width: 100%">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @component('layouts.footer')@endcomponent

    <!-- Modal Protocolo -->
    <div class="modal fade" id="modalProtocolo" role="dialog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #dcd935;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: rgb(66, 66, 66);">Protocolo de denúncia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="word-break: break-all">
                    Anote o seguinte protocolo para acompanhar o status da denúncia
                    <br>
                    Protocolo:
                    <strong>{{session('protocolo')}}</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal acompanhar denuncia -->
    <div class="modal fade" id="modalAcompanharDenuncia" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #278b45;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Acompanhe o status da sua denúncia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="status-denuncia" method="GET" action="{{route('denuncias.acompanhar')}}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <label for="protocolo">{{ __('Protocolo') }}</label>
                                <input id="protocolo" class="form-control @error('protocolo') is-invalid @enderror" type="text" name="protocolo" value="{{old('protocolo')}}" required autofocus autocomplete="protocolo">

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
                    <button type="submit" id="submeterFormBotao" class="btn btn-success submeterFormBotao" form="status-denuncia">Ir</button>
                </div>
            </div>
        </div>
    </div>

<script>
    var $videoId = 1;
    ClassicEditor
        .create( document.querySelector( '#denuncia-ckeditor' ) )
        .then( editor => {
             document.querySelector( '#submeterFormBotao' ).addEventListener( 'click', (event) => {
                const editorData = editor.getData();

                if(editorData == ""){
                    alert("O campo de denúncia não pode estar vazio");
                    event.preventDefault();
                }
            } );
        } )
        .catch( error => {
            console.error( error );
        } );

    function addImagem() {
        var campo_imagem = `<div class="card shadow bg-white" style="width: 50%;">
                                <div class="card-body">
                                    <label for="imagem">{{ __('Selecione a imagem') }}</label><br>
                                    <input type="file" name="imagem[]" id="imagem" accept="image/*"><br>
                                    <label for="comentarios" style="margin-right: 10px;">{{ __('Comentário') }}</label>
                                    <textarea type="text" class="form-control" name="comentario[]" id="comentario"></textarea>
                                    <button type="button" onclick="this.parentElement.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Remover imagem</button>
                                </div>
                            </div>`;

        $('#imagens').append(campo_imagem);
    }

    function addVideo() {
        var campo_video = `<div class="card shadow bg-white style="width: 50%;">
                                <div class="card-body">
                                    <label for="video">{{ __('Selecione o video') }}</label><br>
                                    <input type="file" name="video[]" id="video`+$videoId+`" onChange="checarTamanho(`+$videoId+`)"><br>
                                    <label for="comentarios" style="margin-right: 10px;">{{ __('Comentário') }}</label>
                                    <textarea type="text" class="form-control" name="comentario[]" id="comentario" ></textarea>
                                    <button type="button" onclick="this.parentElement.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Remover video</button>
                                </div>
                            </div>`;
        $videoId += 1;
        $('#videos').append(campo_video);
    }

    function checarTamanho(id){
        console.log(id);
        let video = $('#video'+id);
        if(video){
            if(video[0].files[0].size > 52428800){
                alert("Mídias não podem ultrapassar o valor máximo de 50MB!");
                video[0].value = "";
            }
        }
    }

    function showCampoEmpresaNaoCadastrada(){
        let select_empresas = $('select#empresas');
        let id_empresa = $('option:selected', select_empresas).val();

        if (id_empresa == "none") {
            document.getElementById('campo_empresa_nao_cadastrada').style.display = '';
            document.getElementById('campo_endereco_empresa_nao_cadastrada').style.display = '';
            document.getElementById('empresa_nao_cadastrada').required = true;
            document.getElementById('endereco').required = true;
        }
        else{
            document.getElementById('campo_empresa_nao_cadastrada').style.display = 'none';
            document.getElementById('campo_endereco_empresa_nao_cadastrada').style.display = 'none';
            document.getElementById('empresa_nao_cadastrada').required = false;
            document.getElementById('endereco').required = false;
        }
    }

    $(function() {
        showCampoEmpresaNaoCadastrada();
    });
</script>
</x-guest-layout>
