<x-app-layout>

    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8" style="padding-top: 15px;">
                        <h4 class="card-title">Avaliar solicitação de muda {{$solicitacao->protocolo}}</h4>
                        <h6 class="card-subtitle mb-2 text-muted">Mudas > Avaliar solicitação de muda {{$solicitacao->protocolo}}</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        <a class="btn my-2" href="{{route('mudas.index')}}" style="cursor: pointer;"><img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}"  alt="Voltar" title="Voltar"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <label for="nome">Nome<span style="color: red; font-weight: bold;">
                                        *</span></label>
                                <input id="nome" class="form-control" type="text" name="nome"
                                    value="{{ $solicitacao->nome }}" autocomplete="nome" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="cpf">{{ __('CPF') }}<span style="color: red; font-weight: bold;">
                                        *</span></label>
                                <input id="cpf" class="form-control simple-field-data-mask" type="text" name="cpf"
                                    value="{{ $solicitacao->cpf }}" autofocus autocomplete="cpf"
                                    data-mask="000.000.000-00" disabled>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="area">Área em m²<span style="color: red; font-weight: bold;">
                                        *</span></label>
                                <input id="area" class="form-control" type="number" step="0.01" name="area"
                                    value="{{ $solicitacao->area }}" autocomplete="area" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <label for="endereco">Endereço<span style="color: red; font-weight: bold;">
                                        *</span></label>
                                <input id="endereco" class="form-control" type="text" name="endereco"
                                    value="{{ $solicitacao->endereco }}" autocomplete="endereco" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6" >
                                <button type="button" class="btn btn-secondary" style="width: 100%" data-toggle="modal" data-target="#modalIndeferir">Indeferir</button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-success btn-color-dafault" style="width: 100%" data-toggle="modal" data-target="#modalDeferir">Deferir</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalDeferir" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #278b45;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Tem certeza que deseja deferir a solicitação de muda?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="deferir-solicitacao" method="POST" action="{{ route('mudas.avaliar', $solicitacao) }}">
                        @method('PUT')
                        @csrf
                        <input id="status" type="hidden" name="status" value="{{ \App\Models\SolicitacaoMuda::STATUS_ENUM['deferido'] }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" form="deferir-solicitacao">Continuar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalIndeferir" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #278b45;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Tem certeza que deseja indeferir a solicitação da muda?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="status-solicitacao" method="POST" action="{{ route('mudas.avaliar', $solicitacao) }}">
                        @method('PUT')
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <input id="status" type="hidden" name="status" value="{{ \App\Models\SolicitacaoMuda::STATUS_ENUM['indeferido'] }}">
                                <label for="motivo_indeferimento">Motivo</label>
                                <textarea id="motivo_indeferimento" class="form-control @error('motivo_indeferimento') is-invalid @enderror"
                                    name="motivo_indeferimento"
                                    autocomplete="motivo_indeferimento">{{old('motivo_indeferimento')}}</textarea>

                                @error('motivo_indeferimento')
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
                    <button type="submit" class="btn btn-success" form="status-solicitacao">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    @if(count($errors) > 0)
        <script>
            $(function() {
                jQuery.noConflict();
                $('#modalIndeferir').modal('show');
            });
        </script>
    @endif
</x-app-layout>
