<x-app-layout>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Realizar solicitação de mudas</h4>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        <a title="Voltar" href="{{route('mudas.requerente.index')}}">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a>
                        <a class="btn btn-success btn-color-dafault" data-toggle="modal"
                            data-target="#modalAcompanharSolicitacao">Acompanhar solicitação</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
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
                            @if (session('success'))
                                <script>
                                    $(function() {
                                        jQuery.noConflict();
                                        $('#modalProtocolo').modal('show');
                                    });
                                </script>
                            @endif
                        </div>
                        <form method="POST" id="cria-solicitacao" action="{{ route('mudas.store') }}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="especie">{{ __('Espécie') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select required class="form-control @error('setor') is-invalid @enderror" name="especie">
                                        <option value="" disabled selected>-- Selecionar a espécie--</option>
                                        @foreach ($especies as $especie)
                                            <option value={{$especie->id}}>{{$especie->nome}}</option>
                                        @endforeach
                                    </select>
                                    @error('especie')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="qtd_mudas">Quantidade de mudas<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="qtd_mudas" class="form-control @error('qtd_mudas') is-invalid @enderror"
                                        type="number" name="qtd_mudas" value="{{ old('qtd_mudas') }}"
                                        autocomplete="qtd_mudas">
                                    @error('qtd_mudas')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="comentario">Comentário <span style="font-weight: normal; color: rgb(88, 88, 88)">(Favor mencionar o local onde será plantada)</span></label>
                                    <textarea id="comentario" class="form-control @error('comentario') is-invalid @enderror"
                                        name="comentario" value="{{ old('comentario') }}"
                                        autocomplete="comentario">{{old('comentario')}}</textarea>
                                    @error('comentario')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group"></div>
                                <div class="col-md-6 form-group">
                                    <button type="submit" class="btn btn-success btn-color-dafault" style="width: 100%;">Confirmar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalProtocolo" role="dialog" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #dcd935;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: rgb(66, 66, 66);">Protocolo da
                        solicitação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="word-break: break-all">
                    Anote o seguinte protocolo para acompanhar o status da solicitação
                    <br>
                    Protocolo:
                    <strong>{{ session('protocolo') }}</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal acompanhar solicitacao -->
    <div class="modal fade" id="modalAcompanharSolicitacao" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #278b45;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Acompanhe o status da sua
                        solicitação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="status-solicitacao" method="GET" action="{{ route('mudas.status') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <label for="protocolo">{{ __('Protocolo') }}<span style="color: red; font-weight: bold;">*</span></label>
                                <input id="protocolo" class="form-control @error('protocolo') is-invalid @enderror"
                                    type="text" name="protocolo" value="{{ old('protocolo') }}" required autofocus
                                    autocomplete="protocolo">
                                @error('protocolo')
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
                    <button type="submit" class="btn btn-success" form="status-solicitacao">Ir</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
