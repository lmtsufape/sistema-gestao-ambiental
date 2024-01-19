<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Analisar exigências de documentação do requerimento de
                            @if($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['primeira_licenca'])
                                {{__('primeira licença')}}
                            @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['renovacao'])
                                {{__('renovação')}}
                            @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['autorizacao'])
                                {{__('autorização')}}
                            @endif
                        </h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('requerimentos.index', 'atuais')}}">Requerimentos</a> > Analisar exigências - {{$requerimento->empresa->nome}}</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        {{-- <a class="btn my-2" href="{{route('requerimentos.show', ['requerimento' => $requerimento])}}" style="cursor: pointer;"><img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}"  alt="Voltar" title="Voltar"></a> --}}
                    </div>
                </div>
                <div class="card" style="width: 100%;">
                    <div class="card-body">

                        @error('error')
                            <div class="alert alert-danger" role="alert">
                                {{$message}}
                            </div>
                        @enderror
                        @if(session('success'))
                            <div class="col-md-12" style="margin-top: 5px;">
                                <div class="alert alert-success" role="alert">
                                    <p>{{session('success')}}</p>
                                </div>
                            </div>
                        @endif
                        <div class="row" >
                            <div class="col-md-12" style="text-align: right; padding-top: 7px;">
                                <h6 class="card-subtitle mb-2 text-muted"><span style="color: red; font-weight: bold;">*</span> Campo obrigatório</h6>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-sm-12">
                                <form class="form-envia-documentos" method="POST" id="analisar-exigencias_documentos" action="{{route('requerimento.analisar.exigencias.documentos', $requerimento->id)}}">
                                    <input type="hidden" name="requerimento_id" value="{{$requerimento->id}}">
                                    @csrf
                                    @if (!empty($documentos))
                                        @foreach ($documentos as $i => $documento)
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <label class="titulo-documento" for="documento_{{$documento->id}}" style="color: black; font-weight: bolder;"><span style="color: red; font-weight: bold;">*</span> {{$documento->nome}} </label>
                                                </div>
                                                <div class="col-md-1" style="text-align: right; float: right;">
                                                    @if($requerimento_documento->where('documento_id', $documento->id)->first()->anexo_arquivo != null) <a href="{{route('requerimento.exigencia.documento.download', ['requerimento_id' => $requerimento->id, 'documento_id' => $documento->id])}}" target="_blank"><img src="{{asset('img/eye-svgrepo-com-green.svg')}}" alt="arquivo atual" style="width: 30px; margin-top: 2px;"></a> @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <div>Ação</div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <input id="aceito{{$documento->id}}" class="form-input-radio" type="radio" name="analise_{{$documento->id}}" value="{{\App\Models\RequerimentoDocumento::STATUS_ENUM['aceito']}}" required @if(old('analise_{{$documento->id}}') || ($requerimento_documento->where('documento_id', $documento->id)->first()->status == \App\Models\RequerimentoDocumento::STATUS_ENUM['aceito'])) checked @endif>
                                                            <label for="aceito{{$documento->id}}">{{ __('Aceito') }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <input id="recusado{{$documento->id}}" class="form-input-radio" type="radio" name="analise_{{$documento->id}}" value="{{\App\Models\RequerimentoDocumento::STATUS_ENUM['recusado']}}" required @if(old('analise_{{$documento->id}}') || ($requerimento_documento->where('documento_id', $documento->id)->first()->status == \App\Models\RequerimentoDocumento::STATUS_ENUM['recusado'])) checked @endif>
                                                            <label for="recusado{{$documento->id}}">{{ __('Recusado') }}</label>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="documentos_id[]" value="{{$documento->id}}">
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <label for="comentario_{{$documento->id}}">{{ __('Comentário') }}</label>
                                                    <textarea id="comentario_{{$documento->id}}" class="form-control @error('comentario'.$documento->id) is-invalid @enderror" type="text" name="comentario_{{$documento->id}}" autofocus autocomplete="comentario_{{$documento->id}}">@if(old('comentario_'.$documento->id)!=null){{old('comentario_'.$documento->id)}}@else{{$requerimento_documento->where('documento_id', $documento->id)->first()->comentario_anexo}}@endif</textarea>
    
                                                    @error('comentario_{{$documento->id}}')
                                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            @if ($i != $documentos->count() - 1)
                                                <hr style="background-color: black; border: 1px solid black;">
                                            @endif
                                        @endforeach
                                        @foreach ($requerimento_documento as $outro_documento)
                                            @if($outro_documento->nome_outro_documento != null)
                                                @if ($outro_documento->count() - 1 != $documentos->count() - 1)
                                                    <hr style="background-color: black; border: 1px solid black;">
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <label class="titulo-documento" style="color: black; font-weight: bolder;"><span style="color: red; font-weight: bold;">*</span> {{$outro_documento->nome_outro_documento}} </label>
                                                    </div>
                                                    <div class="col-md-1" style="text-align: right; float: right;">
                                                        @if($outro_documento->arquivo_outro_documento != null) <a  href="{{route('requerimento.exigencia.outro.documento', ['requerimento_id' => $requerimento->id])}}" target="_blank"><img src="{{asset('img/eye-svgrepo-com-green.svg')}}" alt="arquivo atual" style="width: 30px; margin-top: 2px;"></a> @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-sm-4">
                                                        <div>Ação</div>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <input id="aceito{{$outro_documento->id}}" class="form-input-radio" type="radio" name="analise_outro{{$outro_documento->id}}" value="{{\App\Models\RequerimentoDocumento::STATUS_ENUM['aceito']}}" required @if(old('analise_outro{{$outro_documento->id}}') || ($outro_documento->status == \App\Models\RequerimentoDocumento::STATUS_ENUM['aceito'])) checked @endif>
                                                                <label for="aceito{{$outro_documento->id}}">{{ __('Aceito') }}</label>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <input id="recusado{{$outro_documento->id}}" class="form-input-radio" type="radio" name="analise_outro{{$outro_documento->id}}" value="{{\App\Models\RequerimentoDocumento::STATUS_ENUM['recusado']}}" required @if(old('analise_outro{{$outro_documento->id}}') || ($outro_documento->status == \App\Models\RequerimentoDocumento::STATUS_ENUM['recusado'])) checked @endif>
                                                                <label for="recusado{{$outro_documento->id}}">{{ __('Recusado') }}</label>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="outros_documentos_id[]" value="{{$outro_documento->id}}">
                                                    </div>
                                                    <div class="form-group col-sm-8">
                                                        <label for="comentario_outro_{{$outro_documento->id}}">{{ __('Comentário') }}</label>
                                                        <textarea id="comentario_outro_{{$outro_documento->id}}" class="form-control @error('comentario_outro_'.$outro_documento->id) is-invalid @enderror" type="text" name="comentario_outro_{{$outro_documento->id}}" autofocus autocomplete="comentario_outro_{{$outro_documento->id}}">@if(old('comentario_outro_'.$outro_documento->id)!=null){{old('comentario_outro_'.$outro_documento->id)}}@else{{$outro_documento->comentario_outro_documento}}@endif</textarea>

                                                        @error('comentario_outro_{{$outro_documento->id}}')
                                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                            @break
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="row">
                                            <div class="col-md-11">
                                            @if ($requerimento_documento_outro)
                                                    <label class="titulo-documento" for="documento_{{$requerimento_documento_outro->id}}" style="color: black; font-weight: bolder;">
                                                        <span style="color: red; font-weight: bold;">*</span> {{$requerimento_documento_outro->someOtherProperty}}
                                            @endif                                            </div>
                                            <div class="col-md-1" style="text-align: right; float: right;">
                                                @if($requerimento_documento_outro->arquivo_outro_documento != null) <a href="{{route('requerimento.exigencia.outro.documento', ['requerimento_id' => $requerimento->id])}}" target="_blank"><img src="{{asset('img/eye-svgrepo-com-green.svg')}}" alt="arquivo atual" style="width: 30px; margin-top: 2px;"></a> @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <div>Ação</div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <input id="aceito{{$requerimento_documento_outro->id}}" class="form-input-radio" type="radio" name="analise_outro{{$requerimento_documento_outro->id}}" value="{{\App\Models\RequerimentoDocumento::STATUS_ENUM['aceito']}}" required @if(old('analise_{{$requerimento_documento_outro->id}}') || ($requerimento_documento_outro->status == \App\Models\RequerimentoDocumento::STATUS_ENUM['aceito'])) checked @endif>
                                                        <label for="aceito{{$requerimento_documento_outro->id}}">{{ __('Aceito') }}</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <input id="recusado{{$requerimento_documento_outro->id}}" class="form-input-radio" type="radio" name="analise_outro{{$requerimento_documento_outro->id}}" value="{{\App\Models\RequerimentoDocumento::STATUS_ENUM['recusado']}}" required @if(old('analise_{{$requerimento_documento_outro->id}}') || ($requerimento_documento_outro->status == \App\Models\RequerimentoDocumento::STATUS_ENUM['recusado'])) checked @endif>
                                                        <label for="recusado{{$requerimento_documento_outro->id}}">{{ __('Recusado') }}</label>
                                                    </div>
                                                </div>
                                               
                                                <input type="hidden" name="outros_documentos_id[]" value="{{$requerimento_documento_outro->id}}">
                                            </div>
                                            <div class="form-group col-sm-8">
                                                <label for="comentario_outro_{{$requerimento_documento_outro->id}}">{{ __('Comentário') }}</label>
                                                <textarea id="comentario_outro_{{$requerimento_documento_outro->id}}" class="form-control @error('comentario'.$requerimento_documento_outro->id) is-invalid @enderror" type="text" name="comentario_outro_{{$requerimento_documento_outro->id}}" autofocus autocomplete="comentario_outro_{{$requerimento_documento_outro->id}}">@if(old('comentario_outro_'.$requerimento_documento_outro->id)!=null){{old('comentario_outro_'.$requerimento_documento_outro->id)}}@else{{$requerimento_documento_outro->comentario_outro_documento}}@endif</textarea>

                                                @error('comentario_{{$requerimento_documento_outro->id}}')
                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    @if (!empty($documentos))
                        @foreach ($requerimento_documento as $pivot)
                            @if ($pivot->status != \App\Models\RequerimentoDocumento::STATUS_ENUM['aceito'])
                                @can('isSecretarioOrAnalista', \App\Models\User::class)
                                    <div class="card-footer">
                                        <div class="form-row justify-content-center">
                                            <div class="col-md-6"></div>
                                            <div class="col-md-6" style="text-align: right;">
                                                <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" form="analisar-exigencias_documentos" style="width: 100%">Enviar análise</button>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                                @break
                            @endif
                        @endforeach
                    @else
                        @if($requerimento_documento_outro->status != \App\Models\RequerimentoDocumento::STATUS_ENUM['aceito'])
                            @can('isSecretarioOrAnalista', \App\Models\User::class)
                                <div class="card-footer">
                                    <div class="form-row justify-content-center">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6" style="text-align: right;">
                                            <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" form="analisar-exigencias_documentos" style="width: 100%">Enviar análise</button>
                                        </div>
                                    </div>
                                </div>
                            @endcan
                        @endif             
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
