<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Enviar documentação') }}
        </h2>
    </x-slot>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">Requerimento de
                                    @if($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['primeira_licenca'])
                                        {{__('primeira licença')}}
                                    @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['renovacao'])
                                        {{__('renovação')}}
                                    @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['autorizacao'])
                                        {{__('autorização')}}
                                    @endif
                                </h5>
                                <h6 class="card-subtitle mb-2 text-muted">Requerimentos > Enviar documentação</h6>
                            </div>
                        </div>
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
                        @if($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['documentos_requeridos'])
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Atenção!</strong> Todos os documentos devem estar autenticados!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form method="POST" id="enviar-documentos" action="{{route('requerimento.enviar.documentos', $requerimento->id)}}" enctype="multipart/form-data">
                            <input type="hidden" name="requerimento_id" value="{{$requerimento->id}}">
                            @csrf
                            <table class="table">
                                <tbody>
                                    @foreach ($documentos as $documento)
                                        <tr>
                                            <td>
                                                <div class="col-md-6 form-group">
                                                    <label for="documento_{{$documento->id}}" style="color: black; font-weight: bolder;"><span style="color: red; font-weight: bold;">*</span> {{$documento->nome}} </label>
                                                    @if($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->caminho != null) <a href="{{route('requerimento.documento', ['requerimento_id' => $requerimento->id, 'documento_id' => $documento->id])}}" target="_blank"><img src="{{asset('img/file-pdf-solid.svg')}}" alt="arquivo atual" style="width: 16px;"></a> @endif

                                                    @if($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->status == \App\Models\Checklist::STATUS_ENUM['nao_enviado'])
                                                        <div class="card">
                                                            <div class="card-body">
                                                                Aguardando envio do documento
                                                            </div>
                                                        </div>
                                                    @elseif($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->status == \App\Models\Checklist::STATUS_ENUM['recusado'])
                                                        <div class="card">
                                                            <div class="card-body">
                                                                Documento recusado
                                                            </div>
                                                            @if($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->comentario != null)
                                                                <div class="card-body">
                                                                    Motivo: {{$requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->comentario}}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @elseif($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->status == \App\Models\Checklist::STATUS_ENUM['enviado'])
                                                        <div class="card">
                                                            <div class="card-body">
                                                                Documento enviado
                                                            </div>
                                                        </div>
                                                    @elseif($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->status == \App\Models\Checklist::STATUS_ENUM['aceito'])
                                                        <div class="card">
                                                            <div class="card-body">
                                                                Documento aceito
                                                            </div>
                                                            @if($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->comentario != null)
                                                                <div class="card-body">
                                                                    Motivo: {{$requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->comentario}}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif

                                                    @if($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->status == \App\Models\Checklist::STATUS_ENUM['nao_enviado']
                                                        || $requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->status == \App\Models\Checklist::STATUS_ENUM['recusado'])
                                                        <input id="documento_{{$documento->id}}" class="form-control @error('documento_{{$documento->id}}') is-invalid @enderror" type="file" accept=".pdf"
                                                        name="documentos[]" value="{{$documento->id}}" required autofocus autocomplete="documento_{{$documento->id}}">
                                                        <input type="hidden" name="documentos_id[]" value="{{$documento->id}}">

                                                        @error('documento_{{$documento->id}}')
                                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                        <div class="card-footer">
                            <div class="form-row justify-content-center">
                                <div class="col-md-6"></div>
                                <div class="col-md-6" style="text-align: right">
                                    @if ($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['documentos_requeridos'])
                                        <button data-toggle="modal" data-target="#modalStaticConfirmarEnvio" class="btn btn-success" style="width: 100%">Enviar</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal confirmar envio -->
    <div class="modal fade" id="modalStaticConfirmarEnvio" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #f3c062;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Confirmação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja enviar estes documentos? A modificação de algum documento só poderá ser feita caso o mesmo seja recusado pelo analista.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="submeterFormBotao" class="btn btn-warning" form="enviar-documentos">Enviar</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
