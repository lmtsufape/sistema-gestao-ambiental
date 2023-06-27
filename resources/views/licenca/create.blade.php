<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
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
                    <div class="col-md-12">
                        <h4 class="card-title">Emitir licença</h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('requerimentos.index', 'atuais')}}">Requerimentos</a> > Emitir licença</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        {{-- <a title="Voltar" href="{{route('visitas.index')}}">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <form method="POST" id="emitir-licenca-form" action="{{route('licenca.store')}}" enctype="multipart/form-data">
                            @csrf
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
                                    <input type="date" class="form-control" name="data_de_validade" id="data_de_validade" value="{{old('data_de_validade')}}">
                                    <label for="">Licença Permanente</label>
                                    <input type="checkbox" name="licenca_permanente" id="licenca_permanente" onclick="data_inf()">

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
                                    <div>
                                        <label for="licença" class="label-input btn btn-success btn-enviar-doc w-100">
                                            <img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-up-20-regular.svg')}}" alt="Icone de envio do documento" title="Enviar documento">
                                            {{ __('Clique para selecionar o arquivo') }}
                                        </label>
                                        <label id="labelarquivoselecionado" class="d-empty" for="licença"></label>
                                        <input id="licença" class="input-enviar-arquivo d-none @error('licença') is-invalid @enderror" type="file" accept=".pdf"
                                            name="licença" value="{{old('licença')}}" autofocus autocomplete="licença">
                                    </div>
                                    @error('licença')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <a class="btn" data-toggle="modal" data-target="#documentos" style="text-align: left;">
                                <img class="icon-licenciamento" src="{{asset('img/add-documents-svgrepo-com.svg')}}" alt="Requisitar documentos" title="Requisitar documentos">
                                <strong>Requisitar documentos</strong>
                            </a>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6" style="text-align: right">
                                <button type="submit" class="btn btn-success btn-color-dafault  submeterFormBotao" form="emitir-licenca-form" style="width: 100%">Salvar</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="documentos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: var(--primaria);">
                                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Requisitar documentos</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="documentos-form" method="POST" action="{{route('licenca.requisitar.documentos', $requerimento->id)}}">
                                        @csrf
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <h6 style="font-weight: bolder;">Documentos que o empresário deve enviar</h6>
                                            </div>
                                        </div>
                                        @foreach ($documentos as $i => $documento)
                                            <div class="form-check mt-3">
                                                <input id="documento-{{$documento->id}}" class="form-check-input" type="checkbox" name="documentos[]" value="{{$documento->id}}" @if(old('documentos.'.$i) != null) checked @endif>
                                                <label for="documento-{{$documento->id}}" class="form-check-label">{{$documento->nome}}</label>
                                            </div>
                                        @endforeach
                                        <div class="form-check mt-3">
                                            <input id="opcao-outros" class="form-check-input" type="checkbox">
                                            <label for="opcao-outros" class="form-check-label">Outro</label>
                                        </div>
                                        <div class="form-group mt-3" id="campo-outros" style="display: none;">
                                            <label for="nome-documento">Nome do Documento</label>
                                            <input type="text" class="form-control" id="nome-documento" name="nome_documento" value="{{ old('nome_documento') }}">
                                        </div>
                                        <br>
                                        <label for="prazo_exigencia">{{ __('Prazo para envio das exigências') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input class="form-control @error('prazo_exigencia') is-invalid @enderror" type="date"  id="prazo_exigencia" name="prazo_exigencia" required autofocus autocomplete="data_marcada">
        
                                        @error('prazo_exigencia')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button form="documentos-form"type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" class="btn btn-primary">Requisitar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push ('scripts')
        <script>

            const checkboxOutros = document.getElementById('opcao-outros');
            const campoOutros = document.getElementById('campo-outros');

            checkboxOutros.addEventListener('change', function() {
                if (this.checked) {
                    campoOutros.style.display = 'block';
                } else {
                    campoOutros.style.display = 'none';
                }
            });

            $(".input-enviar-arquivo").change(function(){
                $('#labelarquivoselecionado').text(editar_caminho($(this).val()));
            });
            function editar_caminho(string) {
                return string.split("\\")[string.split("\\").length - 1];
            }

            function data_inf(){
                let option = document.getElementById("data_de_validade");

                option.value = '3000-12-31';

                if(option.readOnly == true){
                    option.readOnly = false;
                }
                else{
                    option.readOnly = true;
                }
            }
        </script>
    @endpush
    @endsection
</x-app-layout>
