<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Editar notícia</h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('noticias.index')}}">Notícias</a> > Editar notícia</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        {{-- @can('create', App\Models\Noticia::class) --}}
                        {{-- <a title="Voltar" href="{{route('noticias.index')}}">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a> --}}
                        {{-- @endif --}}
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            @if(session('success'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-success" role="alert">
                                        <p>{{session('success')}}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <form method="POST" class="form-envia-documentos" id="editar-noticia" action="{{route('noticias.update', ['noticia' => $noticia])}}" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="titulo">Título<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="titulo" name="título" type="text" class="form-control" value="{{old('título', $noticia->titulo)}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="imagem_principal">Imagem principal<span style="color: red; font-weight: bold;">*</span></label> <a href="{{asset('storage/'.$noticia->imagem_principal)}}" target="_blanck">Imagem atual</a>
                                    <br>
                                    <label class="label-input btn btn-success btn-enviar-doc" for="enviar_arquivo"><img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-up-20-regular.svg')}}" alt="Icone de envio do documento" title="Enviar documento" ></label>
                                    <label for="label-input-arquivo" for="enviar_arquivo"></label>
                                    <input id="enviar_arquivo" type="file" class="input-enviar-arquivo @error('imagem_principal') is-invalid @enderror" accept="image/*" name="imagem_principal">

                                    @error('imagem_principal')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <input id="publicar" name="publicar" type="checkbox" @if(old('publicar', $noticia->publicada) == "on") checked @endif>
                                    <label for="publicar">Publicar</label>
                                </div>
                                <div class="col-md-6">
                                    <input id="destaque" name="destaque" type="checkbox" @if(old('destaque', $noticia->destaque) == "on") checked @endif>
                                    <label for="destaque">Notícia em destaque</label>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="texto">{{ __('Texto') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <textarea class="form-control @error('texto') is-invalid @enderror" id="texto"
                                        rows="5" name="texto" required>{{old('texto', $noticia->texto)}}</textarea>
                                    @error('texto')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6" style="text-align: right">
                                <button type="submit" class="btn btn-success btn-color-dafault  submeterFormBotao" form="editar-noticia" style="width: 100%">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        CKEDITOR.replace('texto');

        $(document).ready(function() {
            $(".input-enviar-arquivo").change(function(){
                var label = this.parentElement.children[3];
                label.textContent = editar_caminho($(this).val());
            });
        });

        function editar_caminho(string) {
            return string.split("\\")[string.split("\\").length - 1];
        }
    </script>
    @endsection
</x-app-layout>
