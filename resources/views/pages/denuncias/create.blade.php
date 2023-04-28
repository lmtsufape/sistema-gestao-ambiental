<div class="container" style="padding-top: 3rem; padding-bottom: 6rem;">
    <div class="form-row justify-content-center">
        <div class="col-md-12">
            <div class="form-row">
                <div class="col-md-8">
                    <h4 class="card-title">Registro de denúncia</h4>
                </div>
                <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                    {{-- <a title="Voltar" href="{{route('welcome')}}">
                        <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                    </a> --}}
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
                    <form method="POST" id="cria-denuncia" action="{{route('denuncias.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="empresa">Empresas cadastradas:<span style="color: red; font-weight: bold;">*</span></label>
                            <select class="form-control selectpicker @error('empresa_id') is-invalid @enderror" data-live-search="true" title="Selecione uma empresa"
                                    name="empresa_id" id="empresas" onChange="showCampoEmpresaNaoCadastrada(this)">
                                <option disable="" hidden="" selected>-- Selecionar Empresa --</option>
                                @foreach ($empresas as $empresa)
                                    <option value="{{$empresa->id}}" {{old("empresa_id") == $empresa->id ? 'selected' : ""}}>{{$empresa->nome}}</option>
                                @endforeach
                                <option value="none" {{old("empresa_id") == 'none' ? 'selected' : ""}}>Empresa não cadastrada</option>
                            </select>
                            @error('empresa_id')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-row justify-content-between" id="empresa_info">
                            <div id="campo_empresa_nao_cadastrada" @if (!old("empresa_nao_cadastrada")) style="display: none;" @endif
                                    class="col-md-12 form-group">
                                <label for="empresa_nao_cadastrada">{{ __('Denunciado (Nome da empresa ou pessoa física)') }}<span style="color: red; font-weight: bold;">*</span></label>
                                <input id="empresa_nao_cadastrada" class="form-control @error('empresa_nao_cadastrada') is-invalid @enderror" type="text" name="empresa_nao_cadastrada"
                                    value="{{old('empresa_nao_cadastrada')}}">
                                @error('empresa_nao_cadastrada')
                                    <div id="validationServer02Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div id="campo_endereco_empresa_nao_cadastrada" @if (!old("endereco")) style="display: none;" @endif
                                    class="col-md-12 form-group">
                                <label for="endereco">{{ __('Endereço') }}<span style="color: red; font-weight: bold;">*</span></label>
                                <input id="endereco" class="form-control @error('endereco') is-invalid @enderror" type="text" name="endereco" value="{{old('endereco')}}">
                                @error('endereco')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="denunciante">{{ __('Seu nome (Opcional)') }}</label>
                            <input id="denunciante" class="form-control @error('denunciante') is-invalid @enderror" type="text" name="denunciante"
                                value="{{old('denunciante')}}">
                            @error('denunciante')
                                <div id="validationServer02Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="texto">{{ __('Descrição') }}<span style="color: red; font-weight: bold;">*</span></label>
                            <textarea @error('texto') class="is-invalid" @enderror id="denuncia-ckeditor" name="texto" cols="30" rows="10"></textarea><br>
                            @error('texto')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-row justify-content-between">
                            <div class="col-md-8">
                                <label for="imagem">{{ __('Imagens anexadas') }}</label>
                            </div>
                            <div class="col-md-4" style="text-align: right">
                                <input type="hidden" id="imagem_indice" value="-1">
                                <a title="Adicionar imagem" id="btn-add-imagem" onclick="addImagem()" style="cursor: pointer;">
                                    <img class="icon-licenciamento " src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de adicionar imagem">
                                </a>
                            </div>
                        </div>
                        <div>
                            <input type="hidden" id="tamanhoTotal" value="0">
                            <div id="imagens" class="form-row">
                                {{-- style="width:100%; height:300px; overflow:auto;" --}}
                                <div class="col-md-4">
                                    <div>
                                        <label for="file-input-imagem_indice">
                                            <img id="imagem_previaimagem_indice" class="img-fluid" src="{{asset('/img/nova_imagem.PNG')}}" alt="imagem de anexo" style="cursor: pointer;"/>
                                        </label>
                                        <input style="display: none;" type="file" name="imagem[]" id="file-input-imagem_indice" accept="image/*" onchange="loadPreview(event, 'imagem_indice')">
                                    </div>
                                    <div class="row justify-content-between">
                                        <div class="col-md-6" style="text-align: right">
                                            <div id="nomeimagem_indice" style="display: none; font-style: italic;"></div>
                                        </div>
                                        <div class="col-md-6" style="text-align: right">
                                            <a style="cursor: pointer; color: #ec3b3b; font-weight: bold;" onclick="this.parentElement.parentElement.parentElement.remove()">remover</a>
                                        </div>
                                    </div>
                                </div>

                                @if ($errors->has('imagem.*') && $errors->has('comentario.*'))
                                    @foreach ($errors->get('imagem.*') as $i => $images)
                                        @foreach ($images as $b => $opcao)
                                            <div class="col-md-4" style="margin: 10px 10px 0 0;">
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
                                                <div class="col-md-4" style="margin: 10px 10px 0 0;">
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
                                                <div class="col-md-4" style="margin: 10px 10px 0 0;">
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
                        </div>
                        <div class="form-group">
                            <label for="customFilearquivo">Arquivo anexado</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" accept="application/pdf" id="customFilearquivo" name="arquivoFile" lang="pt">
                                <label class="custom-file-label" for="customFilearquivo">Selecione um arquivo</label>
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="form row">
                        <div class="col-md-12">
                            <div class="alert alert-warning" role="alert">
                                <h5 class="alert-heading">Envio de vídeos</h5>
                                <hr>
                                <p class="mb-0">Caso necessite submeter algum vídeo, solicitamos que o faça pelo e-mail <a href="mailto:meioambientegaranhuns@gmail.com" class="text-decoration-none text-reset">meioambientegaranhuns@gmail.com</a>. Manteremos o anonimato do denunciante.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form-row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <button type="submit" id="submeterFormBotao" class="btn btn-success btn-color-dafault submeterFormBotao" form="cria-denuncia" style="width: 100%">Registrar denúncia</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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
            <div class="modal-body">
                Sua denúncia foi recebida com sucesso! Ela se encontra sob análise da Secretária de Desenvolvimento Rural e Meio Ambiente. Acompanhe a tramitação dela por meio do seguinte protocolo:
                <strong>{{session('protocolo')}}</strong><br>
                Você também pode consultar a denúncia pela página inicial no módulo 
                <strong>CONSULTE SEU PROTOCOLO AQUI</strong> 

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
            <div class="modal-header" style="background-color: var(--primaria);">
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
                <button type="submit" id="submeterFormBotao" class="btn btn-success btn-color-dafault  submeterFormBotao" form="status-denuncia">Ir</button>
            </div>
        </div>
    </div>
</div>

@push ('scripts')
<script>
    $('#customFilearquivo').change(function(e){
        var fileName = e.target.files[0].name;
        $('.custom-file-label').html(fileName);
    });
    var $videoId = 1;
    CKEDITOR.replace('denuncia-ckeditor', {
        height: 400
    });

    document.querySelector( '#submeterFormBotao' ).addEventListener( 'click', (event) => {
        var messageLength = CKEDITOR.instances['denuncia-ckeditor'].getData().replace(/<[^>]*>/gi, '').length;
        if(!messageLength){
            alert("O campo de denúncia não pode estar vazio");
            event.preventDefault();
        }
    });


    function addImagem() {
        if($('#imagens').children().length >= 20){
            alert("A quantidade máxima de imagens é 20!");
        }else{
            var indice = document.getElementById("imagem_indice");
            var imagem_indice = parseInt(document.getElementById("imagem_indice").value)+1;
            indice.value = imagem_indice;

            var campo_imagem = `<div class="col-md-4">
                                    <div class="">
                                        <label for="file-input-`+imagem_indice+`">
                                            <img id="imagem_previa`+imagem_indice+`" class="img-fluid" src="{{asset('/img/nova_imagem.PNG')}}" alt="imagem de anexo" style="cursor: pointer;"/>
                                        </label>
                                        <input style="display: none;" type="file" name="imagem[]" id="file-input-`+imagem_indice+`" accept="image/*" onchange="loadPreview(event, `+imagem_indice+`)">
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <div class="col-md-6" style="text-align: right">
                                            <div id="nome`+imagem_indice+`" style="display: none; font-style: italic;"></div>
                                        </div>
                                        <div class="col-md-6" style="text-align: right">
                                            <a style="cursor: pointer; color: #ec3b3b; font-weight: bold;" onclick="removerImagem(this, `+imagem_indice+`)">remover</a>
                                        </div>
                                    </div>
                                    {{--<div class="form-row">
                                        <label for="comentarios"">{{ __('Comentário') }}</label>
                                        <textarea type="text" class="form-control" name="comentario[]" id="comentario"></textarea>
                                    </div>--}}
                                </div>`;

            $('#imagens').append(campo_imagem);
            $("#file-input-"+imagem_indice).click();
        }
    }

    function removerImagem(image, id){
        let imagem = $('#file-input-'+id);
        if(imagem[0].files[0]){
            let total = document.getElementById('tamanhoTotal');
            total.value = parseInt(total.value) - imagem[0].files[0].size;
        }
        image.parentElement.parentElement.parentElement.remove();
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

    var loadPreview = function(event, indice) {
        if(checarTamanhoIndividual(indice) && checarTamanhoTotal(indice)){
            var reader = new FileReader();
            reader.onload = function(){
            var output = document.getElementById('imagem_previa'+indice);
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
            document.getElementById('nome'+indice).innerHTML = event.target.files[0].name;
            document.getElementById('nome'+indice).style.display = "block";
        }
    };

    function checarTamanhoIndividual(id){
        let imagem = $('#file-input-'+id);
        if(imagem[0].files[0]){
            const fileSize = imagem[0].files[0].size / 1024 / 1024;
            if(fileSize > 2){
                alert("A imagem deve ter no máximo 2MB!");
                imagem.value = "";
                imagem[0].parentElement.parentElement.remove();
                return false;
            }
        }
        return true;
    };

    function checarTamanhoTotal(id){
        let total = document.getElementById('tamanhoTotal');
        console.log(total.value);
        let imagem = $('#file-input-'+id);
        if(imagem[0].files[0]){
            const fileSize = imagem[0].files[0].size / 1024 / 1024;
            const totalSize = parseInt(total.value) / 1024 / 1024;
            if(totalSize+fileSize > 8){
                alert("A soma dos tamanhos da imagem não deve ultrapassar 8MB!");
                imagem.value = "";
                imagem[0].parentElement.parentElement.remove();
                return false;
            }
        }
        total.value = parseInt(total.value) + imagem[0].files[0].size;
        return true;
    };

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
@endpush
