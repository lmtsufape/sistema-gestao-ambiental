<div>
    <div class="container" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Enviar documentação do requerimento de
                            @if($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['primeira_licenca'])
                                {{__('primeira Licença')}}
                            @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['renovacao'])
                                {{__('renovação')}}
                            @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['autorizacao'])
                                {{__('autorização')}}
                            @endif
                        </h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('requerimentos.index', 'atuais')}}">Requerimentos</a> > Enviar documentação - {{$requerimento->empresa->nome}}</h6>
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
                        <div class="row">
                            <div class="col-md-9">
                                @if($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['documentos_requeridos'])
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Atenção!</strong> Todos os documentos devem estar autenticados!
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-3" style="margin-top: 10px; text-align: right;">
                                <h6 class="card-subtitle mb-2 text-muted"><span style="color: red; font-weight: bold;">*</span> Campo obrigatório</h6>
                            </div>
                        </div>

                        <form class="form-envia-documentos" id="enviar-documentos" wire:submit.prevent="submit">
                            @foreach ($documentos as $documento)
                                <div class="col-md-12" style="background-color: black; border: 1px solid black;"></div>
                                <div class="card">
                                    <div class="card-body bg-white">
                                        <div class="form-row">
                                            <div class="col-md-8">
                                                <label class="titulo-documento" for="documento_{{$documento->id}}">{{$documento->nome}}<span style="color: red">*</span></label>
                                            </div>
                                            <div class="col-md-4" style="text-align: left;">
                                                @switch($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->status)
                                                    @case($status['aceito'])
                                                        <img class="icon-licenciamento" width="20px;" src="{{asset('img/concluido.svg')}}"  alt="Icone de documento deferido" title="Documento deferido"> (documento deferido)
                                                        @break
                                                    @case($status['nao_enviado'])
                                                        <img class="icon-licenciamento" width="20px;" src="{{asset('img/pendente.svg')}}"  alt="Icone de documento pendente" title="Documento pendente"> (documento pendente)
                                                        @break
                                                    @case($status['enviado'])
                                                        <img class="icon-licenciamento" width="20px;" src="{{asset('img/carbon_document-tasks.svg')}}"  alt="Icone de documento anexado" title="documento anexado"> (documento @if($requerimento->status == $requerimentoStatus['documentos_requeridos'])anexado) @else enviado) @endif
                                                        @break
                                                    @case($status['recusado'])
                                                        <img class="icon-licenciamento" width="20px;" src="{{asset('img/ep_warning-filled.svg')}}"  alt="Icone de documento indeferido" title="Documento indeferido"> (documento indeferido)
                                                        @break
                                                @endswitch
                                            </div>
                                        </div>
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
                                        <div class="form-group">
                                            @switch($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->status)
                                                @case($status['aceito'])
                                                    <div class="row justify-content-center" style="padding-top: 1rem;">
                                                        @if($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->comentario != null)
                                                            <div class="card card-doc-aceito mb-3">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <strong>Comentário: </strong>{{$requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->comentario}}
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
                                                                        <a class="btn btn-success btn-enviar-doc" href="{{route('requerimento.documento', ['requerimento_id' => $requerimento->id, 'documento_id' => $documento->id])}}">
                                                                            <img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-down-20-regular.svg')}}" alt="Icone de download do documento" title="Download documento" >
                                                                            Baixar arquivo @if($requerimento->status == $requerimentoStatus['documentos_requeridos'])anexado @else enviado @endif
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
                                                                        <input id="enviar_arquivo_{{$documento->id}}" type="file" class="input-enviar-arquivo " accept=".pdf" wire:model="arquivos.{{$documento->id}}">
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
                                                                @if ($requerimento->status == $requerimentoStatus['documentos_requeridos'])
                                                                <img style="width: 30px; display: inline-block;" src="{{asset('img/fa-solid_file-upload.svg')}}"  alt="Icone de enviar documento" title="Enviar documento">
                                                                @endif
                                                                <div class="row" style="padding-top: 10px">
                                                                    <div class="col-md-12  @error('arquivos.'.$documento->id) is-invalid @enderror">
                                                                        <a class="btn btn-success btn-enviar-doc" href="{{route('requerimento.documento', ['requerimento_id' => $requerimento->id, 'documento_id' => $documento->id])}}">
                                                                            <img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-down-20-regular.svg')}}" alt="Icone de download do documento" title="Download documento" >
                                                                            @if($requerimento->status == $requerimentoStatus['documentos_enviados'])
                                                                                Baixar arquivo enviado
                                                                            @else
                                                                                Baixe o arquivo @if($requerimento->status == $requerimentoStatus['documentos_requeridos'])anexado @else enviado @endif
                                                                            @endif
                                                                        </a>
                                                                        @if ($requerimento->status == $requerimentoStatus['documentos_requeridos'])
                                                                        <p class="font-weight-bold text-white" style="margin-bottom: 0px">ou</p>
                                                                        <label class="label-input-novo btn btn-success btn-enviar-doc" for="enviar_arquivo_{{$documento->id}}"><img class="icon-licenciamento" width="20px;" src="{{asset('img/fluent_document-arrow-up-20-regular.svg')}}" alt="Icone de envio do documento" title="Enviar documento" ></label>
                                                                        <br><label for="label-input-arquivo" for="enviar_arquivo_{{$documento->id}}"></label>
                                                                        <input id="enviar_arquivo_{{$documento->id}}" type="file" class="input-enviar-arquivo @error('{{$documento->id}}') is-invalid @enderror" accept=".pdf" wire:model="arquivos.{{$documento->id}}">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @break
                                                @case($status['recusado'])
                                                    <div class="row justify-content-center" style="padding-top: 1rem;">
                                                        @if($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->comentario != null)
                                                            <div class="card card-doc-recusado">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <strong>Motivo: </strong>{{$requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->comentario}}
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
                                    </div>
                                </div>
                            @endforeach
                        </form>

                    </div>
                    @if ($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['documentos_requeridos'] && $requerimento->canceladoSecretario() == false)
                        <div class="card-footer">
                            <div class="form-row justify-content-center">
                                <div class="col-md-6"></div>
                                <div class="col-md-6" style="text-align: right">
                                    <button onclick="checar_arquivos()" class="btn btn-success btn-color-dafault" style="width: 100%">Concluir envio dos documentos</button>
                                </div>
                            </div>
                        </div>
                    @endif
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
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja enviar estes documentos? A modificação de algum documento só poderá ser feita caso o mesmo seja recusado pelo analista.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning submeterFormBotao" form="enviar-documentos" data-bs-dismiss="modal">Concluir</button>
                </div>
            </div>
        </div>
    </div>

</div>
