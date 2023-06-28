<x-app-layout>
    @section('content')

    <div>
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Enviar exigências para finalizar requerimento de
                            @if($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['primeira_licenca'])
                                {{__('primeira Licença')}}
                            @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['renovacao'])
                                {{__('renovação')}}
                            @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['autorizacao'])
                                {{__('autorização')}}
                            @endif
                        </h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('requerimentos.index', 'atuais')}}">Requerimentos</a> > Enviar exigências - {{$requerimento->empresa->nome}}</h6>
                    </div>
                    @can('isSecretarioOrAnalista', \App\Models\User::class)
                        <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                            {{-- <a class="btn my-2" href="{{route('requerimentos.show', ['requerimento' => $requerimento])}}" style="cursor: pointer;"><img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}"  alt="Voltar" title="Voltar"></a> --}}
                        </div>
                    @endcan
                    @can('isRequerente', \App\Models\User::class)
                        <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                            {{-- <a class="btn my-2"  href="javascript:window.history.back();" style="cursor: pointer;"><img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}"  alt="Voltar" title="Voltar"></a> --}}
                        </div>
                    @endcan
                </div>
                <div class="card">
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

                        <form class="form-envia-documentos" id="envia-documentos-exigencias" method="POST" action="{{route('requerimento.enviar.exigencias.documentos', $requerimento->id)}}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="requerimento_id" value="{{$requerimento->id}}">
                            @if (!empty($documentos))
                                @foreach ($documentos as $documento)
                                    <div class="col-md-12" style="background-color: black; border: 1px solid black;"></div>
                                    <div class="card">
                                        <div class="card-body bg-white">
                                            <div class="form-row">
                                                <div class="col-md-8">
                                                    <label class="titulo-documento" for="documento_{{$documento->id}}">{{$documento->nome}}<span style="color: red">*</span></label>
                                                </div>
                                                <div class="col-md-4" style="text-align: left;">
                                                    @switch($requerimento_documento->where('documento_id', $documento->id)->first()->status)
                                                            @case($status['aceito'])
                                                                <img class="icon-licenciamento" width="20px;" src="{{asset('img/concluido.svg')}}"  alt="Icone de documento deferido" title="Documento deferido"> (documento deferido)
                                                                @break
                                                            @case($status['nao_enviado'])
                                                                <img class="icon-licenciamento" width="20px;" src="{{asset('img/pendente.svg')}}"  alt="Icone de documento pendente" title="Documento pendente"> (documento pendente)
                                                                @break
                                                            @case($status['enviado'])
                                                                <img class="icon-licenciamento" width="20px;" src="{{asset('img/carbon_document-tasks.svg')}}"  alt="Icone de documento anexado" title="documento anexado"> (documento anexado)
                                                                @break
                                                            @case($status['analisado'])
                                                                <img class="icon-licenciamento" width="20px;" src="{{asset('img/ep_warning-filled.svg')}}"  alt="Icone de documento indeferido" title="Documento indeferido"> (documento indeferido)
                                                                @break
                                                            @case($status['recusado'])
                                                                <img class="icon-licenciamento" width="20px;" src="{{asset('img/ep_warning-filled.svg')}}"  alt="Icone de documento indeferido" title="Documento indeferido"> (documento indeferido)
                                                                @break
                                                    @endswitch
                                                </div>
                                            </div>
                                            @if (!empty($documentos))
                                                @error('arquivos.'.$documento->id)
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div id="validationServer03Feedback" class="invalid-feedback font-weight-bold" style="display: block">
                                                                    {{ $message }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @enderror
                                            @endif
                                            @if (!empty($documentos))
                                                @if ($documento->documento_modelo != null)
                                                    <div class="form-row">
                                                        <div class="col-md-12" style="text-align: left;">
                                                            <div class="justify-content-between">
                                                                <a class="modelo-doc" href="{{route("documentos.show", $documento->id)}}">
                                                                    <img class="icon-licenciamento" width="20px;" src="{{asset('img/ci_file-pdf.svg')}}" alt="Icone do documento pdf" title="Modelo para {{$documento->nome}}" >
                                                                    modelo do documento
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                            <div class="form-group">
                                                @switch($requerimento_documento->where('documento_id', $documento->id)->first()->status)
                                                    @case($status['aceito'])
                                                        <div class="row justify-content-center" style="padding-top: 1rem;">
                                                            @if($requerimento_documento->where('documento_id', $documento->id)->first()->comentario_anexo != null)
                                                                <div class="card card-doc-aceito mb-3">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <strong>Comentário: </strong>{{$requerimento_documento->where('documento_id', $documento->id)->first()->comentario_anexo}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="card card-enviar-doc text-center">
                                                                <div class="card-body">
                                                                    <img style="width: 30px; display: inline-block;" src="{{asset('img/fa-solid_file-download.svg')}}"  alt="Icone de baixar documento" title="Baixar documento">
                                                                    <div class="row" style="padding-top: 10px">
                                                                        <div class="col-md-12">
                                                                            <a class="btn btn-success btn-enviar-doc" href="{{route('requerimento.exigencia.documento.download', ['requerimento_id' => $requerimento->id, 'documento_id' => $documento->id])}}">
                                                                                <img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-down-20-regular.svg')}}" alt="Icone de download do documento" title="Download documento" >
                                                                                Baixar arquivo @if($requerimento_documento->where('documento_id', $documento->id)->first()->status == \App\Models\RequerimentoDocumento::STATUS_ENUM['aceito'])anexado @else enviado @endif
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @break
                                                    @case($status['nao_enviado'])
                                                        <div class="row justify-content-center" style="padding-top: 1rem;">
                                                            <div class="card card-enviar-doc text-center">
                                                                <div class="card-body">
                                                                    <img style="width: 30px; display: inline-block;" src="{{asset('img/fa-solid_file-upload.svg')}}"  alt="Icone de enviar documento" title="Enviar documento">
                                                                    <div class="row" style="padding-top: 10px">
                                                                        <div class="col-md-12 @error('arquivos.'.$documento->id) is-invalid @enderror">
                                                                            <label class="label-input btn btn-success btn-enviar-doc" for="enviar_arquivo_{{$documento->id}}"><img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-up-20-regular.svg')}}" alt="Icone de envio do documento" title="Enviar documento" ></label>
                                                                            <br><label for="label-input-arquivo" for="enviar_arquivo_{{$documento->id}}"></label>
                                                                            <input name="documentos[{{$documento->id}}]" id="enviar_arquivo_{{$documento->id}}" type="file" class="input-enviar-arquivo " accept=".pdf" onchange="showAttachmentSuccess(this)">
                                                                            <small>Enviar arquivo com extensão .pdf e tamanho máximo de 2mb</small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @break
                                                    @case($status['enviado'])
                                                        <div class="row justify-content-center" style="padding-top: 1rem;">
                                                            <div class="card card-enviar-doc text-center">
                                                                <div class="card-body">
                                                                    <img style="width: 30px; display: inline-block;" src="{{asset('img/fa-solid_file-download.svg')}}"  alt="Icone de baixar documento" title="Baixar documento">
                                                                    @if ($requerimento_documento->where('documento_id', $documento->id)->first()->status == \App\Models\RequerimentoDocumento::STATUS_ENUM['aceito'])
                                                                    <img style="width: 30px; display: inline-block;" src="{{asset('img/fa-solid_file-upload.svg')}}"  alt="Icone de enviar documento" title="Enviar documento">
                                                                    @endif
                                                                    <div class="row" style="padding-top: 10px">
                                                                        <div class="col-md-12  @error('arquivos.'.$documento->id) is-invalid @enderror">
                                                                            <a class="btn btn-success btn-enviar-doc" href="{{route('requerimento.exigencia.documento.download', ['requerimento_id' => $requerimento->id, 'documento_id' => $documento->id])}}">
                                                                                <img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-down-20-regular.svg')}}" alt="Icone de download do documento" title="Download documento" >
                                                                                @if($requerimento_documento->where('documento_id', $documento->id)->first()->status == \App\Models\RequerimentoDocumento::STATUS_ENUM['enviado'])
                                                                                    Baixar arquivo enviado
                                                                                @else
                                                                                    Baixe o arquivo @if($requerimento_documento->where('documento_id', $documento->id)->first()->status == \App\Models\RequerimentoDocumento::STATUS_ENUM['aceito'])anexado @else enviado @endif
                                                                                @endif
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @break
                                                    @case($status['recusado'])
                                                        <div class="row justify-content-center" style="padding-top: 1rem;">
                                                            @if($requerimento_documento->where('documento_id', $documento->id)->first()->comentario_anexo != null)
                                                                <div class="card card-doc-recusado">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <strong>Motivo: </strong>{{$requerimento_documento->where('documento_id', $documento->id)->first()->comentario_anexo}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="row justify-content-center" style="padding-top: 1rem;">
                                                            <div class="card card-enviar-doc text-center">
                                                                <div class="card-body">
                                                                    <img style="width: 30px; display: inline-block;" src="{{asset('img/fa-solid_file-upload.svg')}}"  alt="Icone de enviar documento" title="Enviar documento">
                                                                    <div class="row" style="padding-top: 10px">
                                                                        <div class="col-md-12 @error('arquivos.'.$documento->id) is-invalid @enderror">
                                                                            <label class="label-input-novo btn btn-success btn-enviar-doc" for="enviar_arquivo_{{$documento->id}}"><img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-up-20-regular.svg')}}" alt="Icone de envio do documento" title="Enviar documento" ></label>
                                                                            <br><label for="label-input-arquivo" for="enviar_arquivo_{{$documento->id}}"></label>
                                                                            <input id="enviar_arquivo_{{$documento->id}}" type="file" class="input-enviar-arquivo " accept=".pdf" wire:model="arquivos.{{$documento->id}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @break
                                                @endswitch
                                            </div>
                                            {{-- @if ($requerimento_documento->where('documento_id', $documento->id)->first()->status != \App\Models\RequerimentoDocumento::STATUS_ENUM['aceito'])
                                                <div class="form-group">
                                                            <div class="row justify-content-center" style="padding-top: 1rem;">
                                                                <div class="card card-enviar-doc text-center">
                                                                    <div class="card-body">
                                                                        <img style="width: 30px; display: inline-block;" src="{{asset('img/fa-solid_file-upload.svg')}}"  alt="Icone de enviar documento" title="Enviar documento">
                                                                        <div class="row" style="padding-top: 10px">
                                                                            <div class="col-md-12 @error('arquivos.'.$documento->id) is-invalid @enderror">
                                                                                <label class="label-input btn btn-success btn-enviar-doc" for="{{$documento->id}}"><img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-up-20-regular.svg')}}" alt="Icone de envio do documento" title="Enviar documento" ></label>
                                                                                <br><label for="label-input-arquivo" for="{{$documento->id}}"></label>
                                                                                <input name="documentos[{{$documento->id}}]" id="{{$documento->id}}" type="file" class="input-enviar-arquivo" accept=".pdf" onchange="showAttachmentSuccess(this)">
                                                                                <small>Enviar arquivo com extensão .pdf e tamanho máximo de 2mb</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                </div>
                                            @endif --}}
                                        </div>
                                    </div>
                                @endforeach
                                @foreach ($requerimento_documento as $outro_documento)
                                    @if($outro_documento->nome_outro_documento != null)
                                        <div class="col-md-12" style="background-color: black; border: 1px solid black;"></div>
                                        <div class="card">
                                            <div class="card-body bg-white">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <label class="titulo-documento">{{$outro_documento->nome_outro_documento}}<span style="color: red">*</span></label>
                                                        </div>
                                                        <div class="col-md-4" style="text-align: left;">
                                                            @switch($outro_documento->status)
                                                                    @case($status['aceito'])
                                                                        <img class="icon-licenciamento" width="20px;" src="{{asset('img/concluido.svg')}}"  alt="Icone de documento deferido" title="Documento deferido"> (documento deferido)
                                                                        @break
                                                                    @case($status['nao_enviado'])
                                                                        <img class="icon-licenciamento" width="20px;" src="{{asset('img/pendente.svg')}}"  alt="Icone de documento pendente" title="Documento pendente"> (documento pendente)
                                                                        @break
                                                                    @case($status['enviado'])
                                                                        <img class="icon-licenciamento" width="20px;" src="{{asset('img/carbon_document-tasks.svg')}}"  alt="Icone de documento anexado" title="documento anexado"> (documento anexado)
                                                                        @break
                                                                    @case($status['analisado'])
                                                                        <img class="icon-licenciamento" width="20px;" src="{{asset('img/ep_warning-filled.svg')}}"  alt="Icone de documento indeferido" title="Documento indeferido"> (documento indeferido)
                                                                        @break
                                                                    @case($status['recusado'])
                                                                        <img class="icon-licenciamento" width="20px;" src="{{asset('img/ep_warning-filled.svg')}}"  alt="Icone de documento indeferido" title="Documento indeferido"> (documento indeferido)
                                                                        @break
                                                            @endswitch
                                                        </div>
                                                    </div>
                                                    @switch($outro_documento->status)
                                                        @case($status['aceito'])
                                                            <div class="row justify-content-center" style="padding-top: 1rem;">
                                                                @if($outro_documento->comentario_outro_documento != null)
                                                                    <div class="card card-doc-aceito mb-3">
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <strong>Comentário: </strong>{{$outro_documento->comentario_outro_documento}}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                <div class="card card-enviar-doc text-center">
                                                                    <div class="card-body">
                                                                        <img style="width: 30px; display: inline-block;" src="{{asset('img/fa-solid_file-download.svg')}}"  alt="Icone de baixar documento" title="Baixar documento">
                                                                        <div class="row" style="padding-top: 10px">
                                                                            <div class="col-md-12">
                                                                                <a class="btn btn-success btn-enviar-doc" href="{{route('requerimento.exigencia.outro.documento.download', ['requerimento_id' => $requerimento->id])}}">
                                                                                    <img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-down-20-regular.svg')}}" alt="Icone de download do documento" title="Download documento" >
                                                                                    Baixar arquivo @if($outro_documento->status == \App\Models\RequerimentoDocumento::STATUS_ENUM['aceito'])anexado @else enviado @endif
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @break
                                                        @case($status['nao_enviado'])
                                                            <div class="row justify-content-center" style="padding-top: 1rem;">
                                                                <div class="card card-enviar-doc text-center">
                                                                    <div class="card-body">
                                                                        <img style="width: 30px; display: inline-block;" src="{{asset('img/fa-solid_file-upload.svg')}}"  alt="Icone de enviar documento" title="Enviar documento">
                                                                        <div class="row" style="padding-top: 10px">
                                                                            <div class="col-md-12">
                                                                                <label class="label-input btn btn-success btn-enviar-doc" for="outros_documentos_{{$outro_documento->id}}"><img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-up-20-regular.svg')}}" alt="Icone de envio do documento" title="Enviar documento" ></label>
                                                                                <br><label for="label-input-arquivo" for="outros_documentos_{{$outro_documento->id}}"></label>
                                                                                <input name="outros_documentos[{{$outro_documento->id}}]" id="outros_documentos_{{$outro_documento->id}}" type="file" class="input-enviar-arquivo " accept=".pdf" onchange="showAttachmentSuccess(this)" required">
                                                                                <small>Enviar arquivo com extensão .pdf e tamanho máximo de 2mb</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @break
                                                        @case($status['enviado'])
                                                            <div class="row justify-content-center" style="padding-top: 1rem;">
                                                                <div class="card card-enviar-doc text-center">
                                                                    <div class="card-body">
                                                                        <img style="width: 30px; display: inline-block;" src="{{asset('img/fa-solid_file-download.svg')}}"  alt="Icone de baixar documento" title="Baixar documento">
                                                                        @if ($outro_documento->status == \App\Models\RequerimentoDocumento::STATUS_ENUM['enviado'])
                                                                        <img style="width: 30px; display: inline-block;" src="{{asset('img/fa-solid_file-upload.svg')}}"  alt="Icone de enviar documento" title="Enviar documento">
                                                                        @endif
                                                                        <div class="row" style="padding-top: 10px">
                                                                            <div class="col-md-12  @error('arquivos.'.$documento->id) is-invalid @enderror">
                                                                                <a class="btn btn-success btn-enviar-doc" href="{{route('requerimento.exigencia.outro.documento.download', ['requerimento_id' => $requerimento->id, 'documento_id' => $documento->id])}}">
                                                                                    <img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-down-20-regular.svg')}}" alt="Icone de download do documento" title="Download documento" >
                                                                                    @if($outro_documento->status == \App\Models\RequerimentoDocumento::STATUS_ENUM['enviado'])
                                                                                        Baixar arquivo enviado
                                                                                    @else
                                                                                        Baixe o arquivo @if($outro_documento->status == \App\Models\RequerimentoDocumento::STATUS_ENUM['aceito'])anexado @else enviado @endif
                                                                                    @endif
                                                                                </a>
                                                                                @if ($outro_documento->status == \App\Models\RequerimentoDocumento::STATUS_ENUM['aceito'])
                                                                                <p class="font-weight-bold text-white" style="margin-bottom: 0px">ou</p>
                                                                                <label class="label-input-novo btn btn-success btn-enviar-doc" for="outros_documentos_{{$documento->id}}"><img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-up-20-regular.svg')}}" alt="Icone de envio do documento" title="Enviar documento" ></label>
                                                                                <br><label for="label-input-arquivo" for="outros_documentos_{{$documento->id}}"></label>
                                                                                <input name="outros_documentos[{{$outro_documento->id}}]" id="outros_documentos_{{$documento->id}}" type="file" class="input-enviar-arquivo @error('{{$documento->id}}') is-invalid @enderror" accept=".pdf" onchange="showAttachmentSuccess(this)" required>
                                                                                <small>Enviar arquivo com extensão .pdf e tamanho máximo de 2mb</small>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @break
                                                        @case($status['recusado'])
                                                            <div class="row justify-content-center" style="padding-top: 1rem;">
                                                                @if($outro_documento->comentario_outro_documento != null)
                                                                    <div class="card card-doc-recusado">
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <strong>Motivo: </strong>{{$outro_documento->comentario_outro_documento}}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="row justify-content-center" style="padding-top: 1rem;">
                                                                <div class="card card-enviar-doc text-center">
                                                                    <div class="card-body">
                                                                        <img style="width: 30px; display: inline-block;" src="{{asset('img/fa-solid_file-upload.svg')}}"  alt="Icone de enviar documento" title="Enviar documento">
                                                                        <div class="row" style="padding-top: 10px">
                                                                            <div class="col-md-12">
                                                                                <label class="label-input-novo btn btn-success btn-enviar-doc" for="outros_documentos_{{$outro_documento->id}}"><img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-up-20-regular.svg')}}" alt="Icone de envio do documento" title="Enviar documento" ></label>
                                                                                <br><label for="label-input-arquivo" for="outros_documentos_{{$outro_documento->id}}"></label>
                                                                                <input name="outros_documentos[{{$outro_documento->id}}]" id="outros_documentos_{{$outro_documento->id}}" type="file" class="input-enviar-arquivo " accept=".pdf" onchange="showAttachmentSuccess(this)" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @break
                                                    @endswitch
                                                        {{-- <div class="row justify-content-center" style="padding-top: 1rem;">
                                                            <div class="card card-enviar-doc text-center">
                                                                <div class="card-body">
                                                                    <img style="width: 30px; display: inline-block;" src="{{asset('img/fa-solid_file-upload.svg')}}"  alt="Icone de enviar documento" title="Enviar documento">
                                                                    <div class="row" style="padding-top: 10px">
                                                                        <div class="col-md-12">
                                                                            <label class="label-input btn btn-success btn-enviar-doc" for="{{$outro_documento->id}}"><img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-up-20-regular.svg')}}" alt="Icone de envio do documento" title="Enviar documento" ></label>
                                                                            <br><label for="label-input-arquivo" for="{{$outro_documento->id}}"></label>
                                                                            <input name="outros_documentos[{{$outro_documento->id}}]" id="{{$outro_documento->id}}" type="file" class="input-enviar-arquivo" accept=".pdf" onchange="showAttachmentSuccess(this)" required>
                                                                            <small>Enviar arquivo com extensão .pdf e tamanho máximo de 2mb</small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                        @break
                                    @endif
                                @endforeach
                            @else
                                    <div class="col-md-12" style="background-color: black; border: 1px solid black;"></div>
                                    <div class="card">
                                        <div class="card-body bg-white">
                                            <div class="form-row">
                                                <div class="col-md-8">
                                                            <label class="titulo-documento" for="outro_documento_{{$requerimento_documento_outro->id}}">{{$requerimento_documento_outro->nome_outro_documento}}<span style="color: red">*</span></label>
                                                </div>
                                                <div class="col-md-4" style="text-align: left;">
                                                    @switch($requerimento_documento_outro->status)
                                                            @case($status['aceito'])
                                                                <img class="icon-licenciamento" width="20px;" src="{{asset('img/concluido.svg')}}"  alt="Icone de documento deferido" title="Documento deferido"> (documento deferido)
                                                                @break
                                                            @case($status['nao_enviado'])
                                                                <img class="icon-licenciamento" width="20px;" src="{{asset('img/pendente.svg')}}"  alt="Icone de documento pendente" title="Documento pendente"> (documento pendente)
                                                                @break
                                                            @case($status['enviado'])
                                                                <img class="icon-licenciamento" width="20px;" src="{{asset('img/carbon_document-tasks.svg')}}"  alt="Icone de documento anexado" title="documento anexado"> (documento anexado)
                                                                @break
                                                            @case($status['analisado'])
                                                                <img class="icon-licenciamento" width="20px;" src="{{asset('img/ep_warning-filled.svg')}}"  alt="Icone de documento indeferido" title="Documento indeferido"> (documento indeferido)
                                                                @break
                                                            @case($status['recusado'])
                                                                <img class="icon-licenciamento" width="20px;" src="{{asset('img/ep_warning-filled.svg')}}"  alt="Icone de documento indeferido" title="Documento indeferido"> (documento indeferido)
                                                                @break
                                                    @endswitch
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                @switch($requerimento_documento_outro->status)
                                                    @case($status['aceito'])
                                                        <div class="row justify-content-center" style="padding-top: 1rem;">
                                                            @if($requerimento_documento_outro->comentario_outro_documento != null)
                                                                <div class="card card-doc-aceito mb-3">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <strong>Comentário: </strong>{{$requerimento_documento_outro->comentario_outro_documento}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="card card-enviar-doc text-center">
                                                                <div class="card-body">
                                                                    <img style="width: 30px; display: inline-block;" src="{{asset('img/fa-solid_file-download.svg')}}"  alt="Icone de baixar documento" title="Baixar documento">
                                                                    <div class="row" style="padding-top: 10px">
                                                                        <div class="col-md-12">
                                                                            <a class="btn btn-success btn-enviar-doc" href="{{route('requerimento.exigencia.outro.documento.download', ['requerimento_id' => $requerimento->id])}}">
                                                                                <img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-down-20-regular.svg')}}" alt="Icone de download do documento" title="Download documento" >
                                                                                Baixar arquivo @if($requerimento_documento_outro->status == \App\Models\RequerimentoDocumento::STATUS_ENUM['aceito'])anexado @else enviado @endif
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @break
                                                    @case($status['nao_enviado'])
                                                        <div class="row justify-content-center" style="padding-top: 1rem;">
                                                            <div class="card card-enviar-doc text-center">
                                                                <div class="card-body">
                                                                    <img style="width: 30px; display: inline-block;" src="{{asset('img/fa-solid_file-upload.svg')}}"  alt="Icone de enviar documento" title="Enviar documento">
                                                                    <div class="row" style="padding-top: 10px">
                                                                        <div class="col-md-12">
                                                                            <label class="label-input btn btn-success btn-enviar-doc" for="outros_documentos_{{$requerimento_documento_outro->id}}"><img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-up-20-regular.svg')}}" alt="Icone de envio do documento" title="Enviar documento" ></label>
                                                                            <br><label for="label-input-arquivo" for="outros_documentos_{{$requerimento_documento_outro->id}}"></label>
                                                                            <input name="outros_documentos[{{$requerimento_documento_outro->id}}]" id="outros_documentos_{{$requerimento_documento_outro->id}}" type="file" class="input-enviar-arquivo " accept=".pdf" onchange="showAttachmentSuccess(this)" required">
                                                                            <small>Enviar arquivo com extensão .pdf e tamanho máximo de 2mb</small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @break
                                                    @case($status['enviado'])
                                                        <div class="row justify-content-center" style="padding-top: 1rem;">
                                                            <div class="card card-enviar-doc text-center">
                                                                <div class="card-body">
                                                                    <img style="width: 30px; display: inline-block;" src="{{asset('img/fa-solid_file-download.svg')}}"  alt="Icone de baixar documento" title="Baixar documento">
                                                                    @if ($requerimento_documento_outro->status == \App\Models\RequerimentoDocumento::STATUS_ENUM['enviado'])
                                                                    <img style="width: 30px; display: inline-block;" src="{{asset('img/fa-solid_file-upload.svg')}}"  alt="Icone de enviar documento" title="Enviar documento">
                                                                    @endif
                                                                    <div class="row" style="padding-top: 10px">
                                                                        <div class="col-md-12  @error('arquivos.'.$documento->id) is-invalid @enderror">
                                                                            <a class="btn btn-success btn-enviar-doc" href="{{route('requerimento.exigencia.outro.documento.download', ['requerimento_id' => $requerimento->id, 'documento_id' => $documento->id])}}">
                                                                                <img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-down-20-regular.svg')}}" alt="Icone de download do documento" title="Download documento" >
                                                                                @if($requerimento_documento_outro->status == \App\Models\RequerimentoDocumento::STATUS_ENUM['enviado'])
                                                                                    Baixar arquivo enviado
                                                                                @else
                                                                                    Baixe o arquivo @if($requerimento_documento_outro->status == \App\Models\RequerimentoDocumento::STATUS_ENUM['aceito'])anexado @else enviado @endif
                                                                                @endif
                                                                            </a>
                                                                            @if ($requerimento_documento_outro->status == \App\Models\RequerimentoDocumento::STATUS_ENUM['aceito'])
                                                                            <p class="font-weight-bold text-white" style="margin-bottom: 0px">ou</p>
                                                                            <label class="label-input-novo btn btn-success btn-enviar-doc" for="outros_documentos_{{$documento->id}}"><img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-up-20-regular.svg')}}" alt="Icone de envio do documento" title="Enviar documento" ></label>
                                                                            <br><label for="label-input-arquivo" for="outros_documentos_{{$documento->id}}"></label>
                                                                            <input name="outros_documentos[{{$requerimento_documento_outro->id}}]" id="outros_documentos_{{$documento->id}}" type="file" class="input-enviar-arquivo @error('{{$documento->id}}') is-invalid @enderror" accept=".pdf" onchange="showAttachmentSuccess(this)" required>
                                                                            <small>Enviar arquivo com extensão .pdf e tamanho máximo de 2mb</small>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @break
                                                    @case($status['recusado'])
                                                        <div class="row justify-content-center" style="padding-top: 1rem;">
                                                            @if($requerimento_documento_outro->comentario_outro_documento != null)
                                                                <div class="card card-doc-recusado">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <strong>Motivo: </strong>{{$requerimento_documento_outro->comentario_outro_documento}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="row justify-content-center" style="padding-top: 1rem;">
                                                            <div class="card card-enviar-doc text-center">
                                                                <div class="card-body">
                                                                    <img style="width: 30px; display: inline-block;" src="{{asset('img/fa-solid_file-upload.svg')}}"  alt="Icone de enviar documento" title="Enviar documento">
                                                                    <div class="row" style="padding-top: 10px">
                                                                        <div class="col-md-12">
                                                                            <label class="label-input-novo btn btn-success btn-enviar-doc" for="outros_documentos_{{$requerimento_documento_outro->id}}"><img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-up-20-regular.svg')}}" alt="Icone de envio do documento" title="Enviar documento" ></label>
                                                                            <br><label for="label-input-arquivo" for="outros_documentos_{{$requerimento_documento_outro->id}}"></label>
                                                                            <input name="outros_documentos[{{$requerimento_documento_outro->id}}]" id="outros_documentos_{{$requerimento_documento_outro->id}}" type="file" class="input-enviar-arquivo " accept=".pdf" onchange="showAttachmentSuccess(this)" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @break
                                                @endswitch
                                            </div>
                                        </div>
                                    </div>
                            @endif
                        </form>
                    </div>
                    @if (!empty($documentos))
                        @foreach ($requerimento_documento as $pivot)
                            @if ($pivot->status != \App\Models\RequerimentoDocumento::STATUS_ENUM['aceito'])
                                <div class="card-footer">
                                    <div class="form-row justify-content-center">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6" style="text-align: right">
                                            <button onclick="checar_arquivos()" class="btn btn-success btn-color-dafault" style="width: 100%">Concluir envio dos documentos</button>
                                        </div>
                                    </div>
                                </div>
                                @break
                            @endif
                        @endforeach
                    @else
                        @if ($requerimento_documento_outro->status != \App\Models\RequerimentoDocumento::STATUS_ENUM['aceito'])
                            <div class="card-footer">
                                <div class="form-row justify-content-center">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6" style="text-align: right">
                                        <button onclick="checar_arquivos()" class="btn btn-success btn-color-dafault" style="width: 100%">Concluir envio dos documentos</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal confirmar envio -->
    <div wire:ignore.self class="modal fade" id="modalStaticConfirmarEnvio" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                    <button type="submit" class="btn btn-warning submeterFormBotao" form="envia-documentos-exigencias">Concluir</button>
                </div>
            </div>
        </div>
    </div>

</div>

    @push ('scripts')
        <script>
            function editar_caminho(string) {
                return string.split("\\")[string.split("\\").length - 1];
            }
            function checar_arquivos() {
                $("#modalStaticConfirmarEnvio").modal('show');
            }
            function showAttachmentSuccess(input) {
                const fileName = input.files[0].name;
                const message = `O arquivo ${fileName} foi anexado com sucesso.`;
                Swal.fire({
                    position: 'bottom-end',
                    icon: 'success',
                    title: message,
                    showConfirmButton: false,
                    timerProgressBar: true,
                    timer: 3000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                });
            }
        </script>
    @endpush
    @endsection
</x-app-layout>
