<x-guest-layout>
    @component('layouts.nav_bar')@endcomponent

    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">Realizar solicitação de mudas</h5>
                            </div>
                            <div class="col-md-4" style="text-align: right">
                                <a class="btn btn-success btn-color-dafault" data-toggle="modal"
                                    data-target="#modalAcompanharSolicitacao">Acompanhar solicitação</a>
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
                                <div class="col-md-12 form-group">
                                    <label for="nome">Nome<span style="color: red; font-weight: bold;">
                                            *</span></label>
                                    <input id="nome" class="form-control @error('nome') is-invalid @enderror"
                                        type="text" name="nome" value="{{ old('nome') }}"
                                        autocomplete="nome">
                                    @error('nome')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="cpf">{{ __('CPF') }}<span style="color: red; font-weight: bold;">
                                            *</span></label>
                                    <input id="cpf"
                                        class="form-control simple-field-data-mask @error('cpf') is-invalid @enderror"
                                        type="text" name="cpf" value="{{ old('cpf') }}" autofocus autocomplete="cpf"
                                        data-mask="000.000.000-00">
                                    @error('cpf')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="area">Área em m²<span style="color: red; font-weight: bold;">
                                            *</span></label>
                                    <input id="area" class="form-control @error('area') is-invalid @enderror"
                                        type="number" step="0.01" name="area" value="{{ old('area') }}"
                                        autocomplete="area">
                                    @error('area')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="endereco">Endereço<span style="color: red; font-weight: bold;">
                                            *</span></label>
                                    <input id="endereco" class="form-control @error('endereco') is-invalid @enderror"
                                        type="text" name="endereco" value="{{ old('endereco') }}"
                                        autocomplete="endereco">
                                    @error('endereco')
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

    @component('layouts.footer')@endcomponent

    <script>
        $(document).ready(function($) {
                    $('#cpf').mask('000.000.000-00');
                }
    </script>

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
                                <label for="protocolo">{{ __('Protocolo') }}</label>
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

</x-guest-layout>
