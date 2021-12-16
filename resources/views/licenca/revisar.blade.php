<x-app-layout>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        @can('isSecretario', auth()->user())
                            <h4 class="card-title">Editar licença</h4>
                            <h6 class="card-subtitle mb-2 text-muted">Programação > Editar licença</h6>
                        @elsecan ('isAnalista', auth()->user())
                            <h4 class="card-title">Revisar licença</h4>
                            <h6 class="card-subtitle mb-2 text-muted">Programação > Revisar licença</h6>
                        @endcan
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
                        @can('isSecretario', auth()->user()) <form method="POST" action="{{route('licenca.update', ['licenca' => $licenca])}}" enctype="multipart/form-data"> @endif
                            @csrf
                            @if ($licenca->status == \App\Models\Licenca::STATUS_ENUM['aprovada'])
                                <div class="alert alert-success" role="alert">
                                    <h4 class="alert-heading">Licença aprovada</h4>
                                    @can('isSecretario', auth()->user())
                                        <hr>
                                        <p class="mb-0">Essa licença já foi aprovado, logo edições estão desativadas.</p>
                                    @endcan
                                </div>
                            @elseif($licenca->status == \App\Models\Licenca::STATUS_ENUM['revisar'])
                                <div class="alert alert-warning" role="alert">
                                    <h4 class="alert-heading">Necessária revisão</h4>
                                    <hr>
                                    <p class="mb-0">{{$licenca->comentario_revisao}}</p>
                                </div>
                            @endif
                            <input type="hidden" name="_method" id="method" value="PUT">
                            <div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="licenca">{{__('Tipo de licença')}}</label>
                                        <select name="tipo_de_licença" id="tipo_de_licença" class="form-control @error('tipo_de_licença') is-invalid @enderror" @can('isAnalista', auth()->user()) disabled @else required @endif>
                                            <option @if(old('tipo_de_licença', $licenca->tipo) == \App\Models\Licenca::TIPO_ENUM['simplificada']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['simplificada']}}">Simplificada</option>
                                            <option @if(old('tipo_de_licença', $licenca->tipo) == \App\Models\Licenca::TIPO_ENUM['previa']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['previa']}}">Prêvia</option>
                                            <option @if(old('tipo_de_licença', $licenca->tipo) == \App\Models\Licenca::TIPO_ENUM['instalacao']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['instalacao']}}">Instalação</option>
                                            <option @if(old('tipo_de_licença', $licenca->tipo) == \App\Models\Licenca::TIPO_ENUM['operacao']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['operacao']}}">Operação</option>
                                            <option @if(old('tipo_de_licença', $licenca->tipo) == \App\Models\Licenca::TIPO_ENUM['regularizacao']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['regularizacao']}}">Regularização</option>
                                            <option @if(old('tipo_de_licença', $licenca->tipo) == \App\Models\Licenca::TIPO_ENUM['autorizacao_ambiental']) selected @endif value="{{\App\Models\Licenca::TIPO_ENUM['autorizacao_ambiental']}}">Autorização</option>
                                        </select>
    
                                        @error('tipo_de_licença')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="data_de_validade">{{__('Data de validade')}}</label>
                                        <input type="date" class="form-control @error('data_de_validade') is-invalid @enderror" name="data_de_validade" id="data_de_validade" value="{{old('data_de_validade', $licenca->validade)}}" @can('isAnalista', auth()->user()) disabled @else required @endif>
    
                                        @error('data_de_validade')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <iframe src="{{asset('storage/'.$licenca->caminho)}}" frameborder="0" width="100%" height="500px"></iframe>
                                    </div>
                                    @can('isSecretario', auth()->user())
                                        <div class="col-md-12 form-group">
                                            <label for="licenca">{{__('Licença')}}</label>
                                            <input type="file" name="licença" id="licença" class="form-control" accept=".pdf">
                                            
                                            @error('licença')
                                                <div id="validationServer03Feedback" class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                            <small>Escolha outro arquivo para substituir o atual</small>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        @can('isSecretario', auth()->user()) <form action=""> @endif
                    </div>
                    <div class="card-footer">
                        @can('isSecretario', auth()->user())
                            <div class="form-row">
                                <div class="col-md-6">
                                   
                                </div>
                                <div class="col-md-6" style="text-align: right">
                                    <button type="submit" id="submeterFormBotao" class="btn btn-success" style="width: 100%" @if ($licenca->status == \App\Models\Licenca::STATUS_ENUM['aprovada']) dissabled @endif>Atualizar</button>
                                </div>
                            </div>
                        @else 
                            <div class="form-row">
                                <div class="col-md-6">
                                    <button type="button" id="submeterFormBotao" class="btn btn-warning" data-toggle="modal" data-target="#staticBackdrop-revisar-licenca" style="width: 100%">Revisar</button>
                                </div>
                                <div class="col-md-6" style="text-align: right">
                                    <button type="button" id="submeterFormBotao" class="btn btn-success" data-toggle="modal" data-target="#staticBackdrop-aprovar-licenca" style="width: 100%">Aprovar</button>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
    @can('isAnalista', auth()->user())
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop-revisar-licenca" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #e0a800;">
                        <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Revisar licença</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-licenca-revisar" method="POST" action="{{route('licenca.salvar.revisao', ['licenca' => $licenca, 'visita' => $visita])}}">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="status" value="0">
                            <div class="form-row">
                                <div class="col-md-12">
                                    Tem certeza que deseja mandar essa licença para revisão?
                                </div>
                            </div>
                            <br>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <label for="motivo">Motivo da revisão</label>
                                    <textarea class="form-control" name="motivo" id="motivo" cols="30" rows="5" placeholder="Digite aqui..."></textarea>

                                    @error('motivo')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="submeterFormBotao" class="btn btn-warning" form="form-licenca-revisar">Revisar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop-aprovar-licenca" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #28a745;">
                        <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Aprovar relátorio</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-licenca-aprovar" method="POST" action="{{route('licenca.salvar.revisao', ['licenca' => $licenca, 'visita' => $visita])}}">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="status" value="1">
                            Tem certeza que deseja aprovar essa licença?
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="submeterFormBotao" class="btn btn-success" form="form-licenca-aprovar">Aprovar</button>
                    </div>
                </div>
            </div>
        </div>
    @endcan
</x-app-layout>
