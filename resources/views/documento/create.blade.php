<x-app-layout>
    @section('content')
    <div class="container" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Cadastrar um novo documento</h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('documentos.index')}}">Documentos</a> > Criar documento</h6>
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
                        <form method="POST" id="cria-documento" action="{{route('documentos.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="nome">{{ __('Nome') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="nome" class="form-control apenas_letras @error('nome') is-invalid @enderror" type="text" name="nome"
                                        value="{{old('nome')}}" required autofocus autocomplete="nome" placeholder="Digite o nome do documento...">

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
                                    <input type="checkbox" class="checkbox-licenciamento" name="simplificada" id="simplificada" @if(old('simplificada') != null) checked @endif>
                                    <label for="simplificada">{{ __('Padr??o na licen??a simplificada') }}</label>

                                    @error('simplificada')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="checkbox-licenciamento" name="pr??via" id="pr??via" @if(old('pr??via') != null) checked @endif>
                                    <label for="pr??via">{{ __('Padr??o na licen??a pr??via') }}</label>

                                    @error('pr??via')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="checkbox-licenciamento" name="instala????o" id="instala????o" @if(old('instala????o') != null) checked @endif>
                                    <label for="instala????o">{{ __('Padr??o na licen??a de instala????o') }}</label>

                                    @error('instala????o')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="checkbox-licenciamento" name="opera????o" id="opera????o" @if(old('opera????o') != null) checked @endif>
                                    <label for="opera????o">{{ __('Padr??o na licen??a de opera????o') }}</label>

                                    @error('opera????o')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="checkbox-licenciamento" name="regulariza????o" id="regulariza????o" @if(old('regulariza????o') != null) checked @endif>
                                    <label for="regulariza????o">{{ __('Padr??o na licen??a de regulariza????o') }}</label>

                                    @error('regulariza????o')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="checkbox-licenciamento" name="autoriza????o_ambiental" id="autoriza????o_ambiental" @if(old('autoriza????o_ambiental') != null) checked @endif>
                                    <label for="autoriza????o_ambiental">{{ __('Padr??o na licen??a de autoriza????o ambiental') }}</label>

                                    @error('opera????o')
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
            alert("O arquivo deve ter no m??ximo 2MB!");
            this.value = "";
        };
    });
</script>
@endsection
</x-app-layout>
