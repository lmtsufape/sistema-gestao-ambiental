<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Denúncias') }}
        </h2>
    </x-slot>

    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">Cadastrar denúncia</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Denúncias > Criar denúncia</h6>
                            </div>
                        </div>
                        <div div class="form-row">
                            @if(session('success'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-success" role="alert">
                                        <p>{{session('success')}}</p>
                                    </div>
                                </div>
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
                                <div class="col-md-12 form-group">
                                    <label for="texto">{{ __('Denúncia') }}</label>
                                    <textarea class="form-control @error('texto') is-invalid @enderror" id="denuncia-ckeditor" 
                                        rows="5" name="texto"></textarea>
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
                                <button type="button" id="btn-add-imagem" onclick="addImagem()" class="btn btn-primary" 
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
                                                <input type="file" class="@error('imagem.'.$b) is-invalid @enderror" name="imagem[]" id="imagem">
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
                                                    <input type="file" class="@error('imagem.'.$b) is-invalid @enderror" name="imagem[]" id="imagem">
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
                                                    <input type="file" class="@error('imagem.'.$b) is-invalid @enderror" name="imagem[]" id="imagem">
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
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6" style="text-align: right">
                                <button type="submit" id="submit-denuncia" class="btn btn-success" form="cria-denuncia" style="width: 100%">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    ClassicEditor
        .create( document.querySelector( '#denuncia-ckeditor' ) )
        .then( editor => {   
             document.querySelector( '#submit-denuncia' ).addEventListener( 'click', (event) => {
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
        var campo_imagem = `<div class="col-md-5" style="margin: 10px 10px 0 0;"> 
                                    <label for="imagem">{{ __('Selecione a imagem') }}</label>
                                    <input type="file" name="imagem[]" id="imagem">
                                    <label for="comentarios" style="margin-right: 10px;">{{ __('Comentário') }}</label>
                                    <input type="text" class="form-control" name="comentario[]" id="comentario">
                                    <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Remover imagem</button>
                            </div>`;

        $('#imagens').append(campo_imagem);
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