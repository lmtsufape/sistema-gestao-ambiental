<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">

            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-10" style="padding-top: 15px;">
                        <h4 class="card-title">Ficha de Análise de Risco em árvore</h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="card-subtitle mb-2 text-muted" href="{{route('podas.show', ['solicitacao' => $ficha->solicitacaoPoda])}}">Podas</a> > <a class="card-subtitle mb-2 text-muted"  href="{{route('podas.edit', ['solicitacao' => $ficha->solicitacaoPoda])}}">Avaliar solicitação de poda/supressão {{$ficha->solicitacaoPoda->protocolo}}</a> > Ficha de Análise de Risco em árvore</h6>
                    </div>
                    <div class="col-md-2" style="text-align: right; padding-top: 15px;">
                        <a class="btn my-2" href="{{route('podas.edit', ['solicitacao' => $ficha->solicitacaoPoda])}}" style="cursor: pointer;"><img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}"  alt="Voltar" title="Voltar"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">Ficha de Análise de Risco em árvore</h5>
                            </div>
                        </div>
                        <div div class="form-row">
                            @if (session('success'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-success" role="alert">
                                        <p>{{ session('success') }}</p>
                                    </div>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-danger" role="alert">
                                        <p>{{ session('error') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <label for="condicoes">Condições da árvore<span style="color: red; font-weight: bold;">
                                       *</span></label>
                                <input id="condicoes" class="form-control" disabled
                                    type="text" name="condicoes" value="{{ $ficha->condicoes }}" autocomplete="condicoes">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="localizacao">Localização<span style="color: red; font-weight: bold;">
                                       *</span></label>
                                <input id="localizacao"
                                    class="form-control simple-field-data-mask" disabled
                                    type="text" name="localizacao" value="{{ $ficha->localizacao }}">
                            </div>
                        </div>
                        <div>
                            <a class="icon-licenciamento" title="Mídia da ficha" data-toggle="modal" data-target="#modal-imagens" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img width="20px;" src="{{asset('img/Visualizar mídia.svg')}}"  alt="Mídia"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="modal-imagens" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelC" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Mídias da Ficha de Análise de Risco em árvore
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" style="font-family: 'Roboto', sans-serif;">Imagens anexadas junto a Ficha de Análise de Risco em árvore:</div>
                    </div>
                    <br>
                    <div class="row">
                        @foreach ($ficha->fotos as $foto)
                            <div class="col-md-6">
                                <div class="card" style="width: 100%;">
                                    <img src="{{asset('storage/' . $foto->caminho)}}" class="card-img-top" alt="...">
                                    @if ($foto->comentario != null)
                                        <div class="card-body">
                                            <p class="card-text">{{$foto->comentario}}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
