<x-app-layout>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
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
                        <h6 class="card-subtitle mb-2 text-muted">Requerimentos > Enviar documentação - {{$requerimento->empresa->nome}}</h6>
                    </div>
                    @can('isSecretarioOrAnalista', \App\Models\User::class)
                        <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                            <a class="btn my-2" href="{{route('requerimentos.show', ['requerimento' => $requerimento])}}" style="cursor: pointer;"><img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}"  alt="Voltar" title="Voltar"></a>
                        </div>
                    @endcan
                    @can('isRequerente', \App\Models\User::class)
                        <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                            <a class="btn my-2" href="{{route('requerimentos.index')}}" style="cursor: pointer;"><img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}"  alt="Voltar" title="Voltar"></a>
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
                        <form class="form-envia-documentos" method="POST" id="enviar-documentos" action="{{route('requerimento.enviar.documentos', $requerimento->id)}}" enctype="multipart/form-data">
                            <input type="hidden" name="requerimento_id" value="{{$requerimento->id}}">
                            @csrf
                            @foreach ($documentos as $documento)
                                <div class="form-row">
                                    <div class="col-sm-12">
                                        <hr style="background-color: black; border: 1px solid black;">
                                    </div>
                                    <div class="form-group col-md-12">
                                        @if($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->status == \App\Models\Checklist::STATUS_ENUM['nao_enviado'])
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                Aguardando envio do documento
                                            </div>
                                        @elseif($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->status == \App\Models\Checklist::STATUS_ENUM['recusado'])
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    Documento recusado
                                                @if($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->comentario != null)
                                                    <div class="card-body">
                                                        <span style="color: rgb(197, 0, 0)"><strong>Motivo: </strong>{{$requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->comentario}}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @elseif($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->status == \App\Models\Checklist::STATUS_ENUM['enviado'])
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                Documento enviado
                                            </div>
                                        @elseif($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->status == \App\Models\Checklist::STATUS_ENUM['aceito'])
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    Documento aceito
                                                @if($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->comentario != null)
                                                    <div class="card-body">
                                                        <span style="color: green"><strong>Motivo: </strong>{{$requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->comentario}}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-10">
                                        <label class="titulo-documento" for="documento_{{$documento->id}}"><span style="color: red; font-weight: bold;">*</span>{{$documento->nome}}</label>
                                    </div>
                                    <div class="col-md-2">
                                        @if($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->caminho != null) <a href="{{route('requerimento.documento', ['requerimento_id' => $requerimento->id, 'documento_id' => $documento->id])}}" target="_blank"><img src="{{asset('img/file-pdf-solid.svg')}}" alt="arquivo atual" title="Documento enviado" style="width: 16px;"></a> @endif
                                    </div>
                                    <div class="col-sm-12">
                                        @if($requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->status == \App\Models\Checklist::STATUS_ENUM['nao_enviado'] || $requerimento->documentos()->where('documento_id', $documento->id)->first()->pivot->status == \App\Models\Checklist::STATUS_ENUM['recusado'])
                                            <label class="label-input" for="enviar_arquivo_{{$documento->id}}"></label>
                                            <label for="label-input-arquivo" for="enviar_arquivo_{{$documento->id}}">Nenhum arquivo selecionado</label>
                                            <input id="enviar_arquivo_{{$documento->id}}" type="file" class="input-enviar-arquivo @error('documento_{{$documento->id}}') is-invalid @enderror" accept=".pdf" name="documentos[]" value="{{$documento->id}}" required autofocus autocomplete="documento_{{$documento->id}}">
                                            <input type="hidden" name="documentos_id[]" value="{{$documento->id}}">
                                        @endif

                                        @error('documento_{{$documento->id}}')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </form>
                    </div>
                    @if ($requerimento->status == \App\Models\Requerimento::STATUS_ENUM['documentos_requeridos'])
                        <div class="card-footer">
                            <div class="form-row justify-content-center">
                                <div class="col-md-6"></div>
                                <div class="col-md-6" style="text-align: right">
                                    <button data-toggle="modal" data-target="#modalStaticConfirmarEnvio" class="btn btn-success btn-color-dafault" style="width: 100%">Enviar</button>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja enviar estes documentos? A modificação de algum documento só poderá ser feita caso o mesmo seja recusado pelo analista.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning submeterFormBotao" form="enviar-documentos">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".input-enviar-arquivo").change(function(){
                var label = this.parentElement.children[1];
                label.textContent = editar_caminho($(this).val());
            });
        });

        function editar_caminho(string) {
            return string.split("\\")[string.split("\\").length - 1];
        }
    </script>
</x-app-layout>
