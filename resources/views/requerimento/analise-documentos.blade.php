<x-app-layout>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        <h5 class="card-title">Analisar documentação do requerimento de
                            @if($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['primeira_licenca'])
                                {{__('primeira licença')}}
                            @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['renovacao'])
                                {{__('renovação')}}
                            @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['autorizacao'])
                                {{__('autorização')}}
                            @endif
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">Requerimentos > Analisar documentação</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        <a class="btn my-2" href="{{route('requerimentos.show', ['requerimento' => $requerimento])}}" style="cursor: pointer;"><img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}"  alt="Voltar" title="Voltar"></a>
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
                                <h6 class="card-subtitle mb-2 text-muted"><span style="color: red; font-weight: bold;">*</span> Campo obrigatório</h6></div>
                            </div>
                        </div>
                        <div class="form-row justify-content-center">
                            <form method="POST" id="analisar-documentos" action="{{route('requerimento.analisar.documentos', $requerimento->id)}}">
                                <input type="hidden" name="requerimento_id" value="{{$requerimento->id}}">
                                @csrf
                                <table class="table">
                                    <tbody>
                                        @foreach ($documentos as $documento)
                                            <tr>
                                                <td>
                                                    <div>
                                                        <div class="form-row justify-content-between">
                                                            <div class="col-md-10">
                                                                <label for="documento_{{$documento->id}}" style="color: black; font-weight: bolder;"> {{$documento->nome}} </label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                @if($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->caminho != null) <a href="{{route('requerimento.documento', ['requerimento_id' => $requerimento->id, 'documento_id' => $documento->id])}}" target="_blank"><img src="{{asset('img/file-pdf-solid.svg')}}" alt="arquivo atual" style="width: 16px;"></a> @endif
                                                            </div>
                                                        </div>
                                                        <span class="linha"></span>
                                                    </div>
                                                    <div class="form-row justify-content-between">
                                                        <div class="form-group col-md-4">
                                                            <label><span style="color: red; font-weight: bold;">*</span> Avalie o documento:</label><br>
                                                            <label for="aceito">{{ __('Aceito') }}</label>
                                                            <input type="radio" name="analise_{{$documento->id}}" value="{{\App\Models\Checklist::STATUS_ENUM['aceito']}}" required @if(old('analise_{{$documento->id}}') || ($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->status == \App\Models\Checklist::STATUS_ENUM['aceito'])) checked @endif>

                                                            <label for="recusado">{{ __('Recusado') }}</label>
                                                            <input type="radio" name="analise_{{$documento->id}}" value="{{\App\Models\Checklist::STATUS_ENUM['recusado']}}" required @if(old('analise_{{$documento->id}}') || ($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->status == \App\Models\Checklist::STATUS_ENUM['recusado'])) checked @endif>
                                                            <input type="hidden" name="documentos_id[]" value="{{$documento->id}}">
                                                        </div>
                                                        <div class="form-group col-md-8">
                                                            <label for="comentario_{{$documento->id}}">{{ __('Comentário') }}</label>
                                                            <textarea id="comentario_{{$documento->id}}" class="form-control @error('comentario'.$documento->id) is-invalid @enderror" type="text" name="comentario_{{$documento->id}}" autofocus autocomplete="comentario_{{$documento->id}}">@if(old('comentario_'.$documento->id)!=null){{old('comentario_'.$documento->id)}}@else{{$requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->comentario}}@endif</textarea>

                                                            @error('comentario_{{$documento->id}}')
                                                                <div id="validationServer03Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <div class="card-footer">
                            <div class="form-row justify-content-center">
                                <div class="col-md-6"></div>
                                    <div class="col-md-6" style="text-align: right">
                                        <button type="submit" id="submeterFormBotao" class="btn btn-success" form="analisar-documentos" style="width: 100%">Enviar análise</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
