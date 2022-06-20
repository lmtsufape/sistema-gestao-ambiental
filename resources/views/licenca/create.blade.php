<x-app-layout>
    @section('content')
    <div class="container" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Emitir licença</h4>
                        <h6 class="card-subtitle mb-2 text-muted">Programação > Emitir licença</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        <a title="Voltar" href="{{route('visitas.index')}}">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <form method="POST" id="emitir-licenca-form" action="{{route('licenca.store')}}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="visita" id="visita" value="{{$visita->id}}">
                            <input type="hidden" name="requerimento" id="requerimento" value="{{$requerimento->id}}">
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="licenca">{{__('Tipo de licença')}}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select name="tipo_de_licença" id="tipo_de_licença" class="form-control @error('tipo_de_licença') is-invalid @enderror" required>
                                        <option @if(old('tipo_de_licença', $requerimento->tipo_licenca) == \App\Models\Licenca::TIPO_ENUM['simplificada']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['simplificada']}}">Simplificada</option>
                                        <option @if(old('tipo_de_licença', $requerimento->tipo_licenca) == \App\Models\Licenca::TIPO_ENUM['previa']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['previa']}}">Prévia</option>
                                        <option @if(old('tipo_de_licença', $requerimento->tipo_licenca) == \App\Models\Licenca::TIPO_ENUM['instalacao']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['instalacao']}}">Instalação</option>
                                        <option @if(old('tipo_de_licença', $requerimento->tipo_licenca) == \App\Models\Licenca::TIPO_ENUM['operacao']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['operacao']}}">Operação</option>
                                        <option @if(old('tipo_de_licença', $requerimento->tipo_licenca) == \App\Models\Licenca::TIPO_ENUM['regularizacao']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['regularizacao']}}">Regularização</option>
                                        <option @if(old('tipo_de_licença', $requerimento->tipo_licenca) == \App\Models\Licenca::TIPO_ENUM['autorizacao_ambiental']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['autorizacao_ambiental']}}">Autorização</option>
                                    </select>

                                    @error('tipo_de_licença')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="data_de_validade">{{__('Data de validade')}}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input type="date" class="form-control @error('data_de_validade') is-invalid @enderror" name="data_de_validade" id="data_de_validade" value="{{old('data_de_validade')}}" required>

                                    @error('data_de_validade')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="licenca">{{__('Licença')}}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input type="file" name="licença" id="licença" class="form-control" required accept=".pdf">

                                    @error('licença')
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
                                <button type="submit" class="btn btn-success submeterFormBotao" form="emitir-licenca-form" style="width: 100%">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
