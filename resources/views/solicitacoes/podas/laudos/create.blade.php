<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-12">
                        <h4 class="card-title">Laudo Técnico Ambiental</h4>
                        @can('usuarioInterno', \App\Models\User::class)
                            <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('podas.index', 'pendentes')}}">Poda/Supressão</a> > Avaliar solicitação de poda/supressão {{$solicitacao->protocolo}} > Laudo</h6>
                        @endcan
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        {{-- <a class="btn my-2" href="{{route('podas.edit', $solicitacao)}}" style="cursor: pointer;"><img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}"  alt="Voltar" title="Voltar"></a> --}}
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
                        </div>
                        <form method="POST" id="ficha-form" action="{{ route('podas.laudos.store', ['solicitacao' => $solicitacao]) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="condicoes">Condições da árvore<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="condicoes" class="form-control @error('condicoes') is-invalid @enderror"
                                        type="text" name="condicoes" value="{{ old('condicoes') }}" autocomplete="condicoes">
                                    @error('condicoes')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="localizacao">Localização<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="localizacao"
                                        class="form-control simple-field-data-mask @error('localizacao') is-invalid @enderror"
                                        type="text" name="localizacao" value="{{ old('localizacao') }}">
                                    @error('localizacao')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            @if ($solicitacao->area == 2)
                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <label id="licenca" for="licenca">Licença Ambiental</label>
                                        <br>
                                        <label class="label-input btn btn-success btn-enviar-doc" for="licenca"><img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-up-20-regular.svg')}}" alt="Icone de envio do arquivo" title="Enviar arquivo"></label>
                                        <label for="licenca"></label>
                                        <input id="licenca" type="file" class="input-enviar-arquivo @error('imagem_principal') is-invalid @enderror" accept=".pdf" name="licenca">

                                        @error('licenca')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label id="pdf" for="pdf">Arquivo PDF</label>
                                    <br>
                                    <label class="label-input btn btn-success btn-enviar-doc" for="enviar_arquivo"><img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-up-20-regular.svg')}}" alt="Icone de envio do arquivo" title="Enviar arquivo" ></label>
                                    <label for="enviar_arquivo"></label>
                                    <input id="enviar_arquivo" type="file" class="input-enviar-arquivo @error('imagem_principal') is-invalid @enderror" accept=".pdf" name="pdf">

                                    @error('pdf')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="imagem">{{ __('Anexar imagens') }}</label>
                                    <br/>
                                    @error('imagem')
                                        @foreach ($errors->get('imagem') as $erro)
                                            <div class="invalid-feedback d-block">
                                                {{$erro}}
                                            </div>
                                        @endforeach
                                    @enderror
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

    @push ('scripts')
        <script>
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
        </script>
    @endpush
    @endsection
</x-app-layout>
