<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ficha de Análise de Risco em árvore') }}
        </h2>
    </x-slot>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">Ficha de Análise de Risco em árvore</h5>
                            </div>
                        </div>
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
                        <form method="POST" id="ficha-form" action="{{ route('podas.fichas.store', ['solicitacao' => $solicitacao]) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="condicoes">Condições da árvore<span style="color: red; font-weight: bold;">
                                            *</span></label>
                                    <input id="condicoes" class="form-control @error('condicoes') is-invalid @enderror"
                                        type="text" name="condicoes" value="{{ old('condicoes') }}" autocomplete="condicoes">
                                    @error('condicoes')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="localizacao">Localização<span style="color: red; font-weight: bold;">
                                            *</span></label>
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
                                    <button type="submit" class="btn btn-success btn-color-dafault"
                                        style="width: 100%;">Confirmar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @component('layouts.footer')@endcomponent

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
</x-app-layout>
