<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Editar documento</h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('documentos.index')}}">Documentos</a> > Editar documento</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        {{-- <a title="Voltar" href="{{route('documentos.index')}}">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card card-borda-esquerda" style="width: 100%;">
                    <div class="card-body">
                        <form method="POST" id="cria-documento" action="{{route('documentos.update', $documento->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="nome">{{ __('Nome') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="nome" class="form-control apenas_letras @error('nome') is-invalid @enderror" type="text" name="nome"
                                        value="{{ $documento->nome }}" required autofocus autocomplete="nome" placeholder="Digite o nome do documento...">

                                    @error('nome')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="documento_modelo">{{ __('Modelo do documento') }}</label>
                                    <input id="documento_modelo" class="form-control @error('documento_modelo') is-invalid @enderror" type="file" accept=".pdf"
                                        name="documento_modelo" value="{{old('documento_modelo')}}" autofocus autocomplete="documento_modelo">

                                    @error('documento_modelo')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="checkbox-licenciamento" name="simplificada" id="simplificada" @if(old('simplificada', $documento->padrao_simplificada) != null) checked @endif>
                                    <label for="simplificada">{{ __('Padrão na licença simplificada') }}</label>

                                    @error('simplificada')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="checkbox-licenciamento" name="prêvia" id="prêvia" @if(old('prêvia', $documento->padrao_previa) != null) checked @endif>
                                    <label for="prêvia">{{ __('Padrão na licença prévia') }}</label>

                                    @error('prêvia')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="checkbox-licenciamento" name="instalação" id="instalação" @if(old('instalação', $documento->padrao_instalacao) != null) checked @endif>
                                    <label for="instalação">{{ __('Padrão na licença de instalação') }}</label>

                                    @error('instalação')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="checkbox-licenciamento" name="operação" id="operação" @if(old('operação', $documento->padrao_operacao) != null) checked @endif>
                                    <label for="operação">{{ __('Padrão na licença de operação') }}</label>

                                    @error('operação')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="checkbox-licenciamento" name="regularização" id="regularização" @if(old('regularização', $documento->padrao_regularizacao) != null) checked @endif>
                                    <label for="regularização">{{ __('Padrão na licença de regularização') }}</label>

                                    @error('regularização')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="checkbox-licenciamento" name="autorização_ambiental" id="autorização_ambiental" @if(old('autorização_ambiental', $documento->padrao_autorizacao_ambiental) != null) checked @endif>
                                    <label for="autorização_ambiental">{{ __('Padrão na licença de autorização ambiental') }}</label>

                                    @error('operação')
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
                                <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" form="cria-documento" style="width: 100%">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $("#documento_modelo").change(function(){
        if(this.files[0].size > 2097152){
            alert("O arquivo deve ter no máximo 2MB!");
            this.value = "";
        };
    });
</script>
@endsection
</x-app-layout>
