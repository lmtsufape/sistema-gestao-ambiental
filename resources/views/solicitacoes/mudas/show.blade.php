<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Solicitações de mudas') }}
        </h2>
    </x-slot>

    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">Solicitação de mudas</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 form-group">
                                <label for="nome">Nome<span style="color: red; font-weight: bold;">
                                        *</span></label>
                                <input id="nome" class="form-control" type="text" name="nome"
                                    value="{{ $solicitacao->nome }}" autocomplete="nome" disabled>
                            </div>
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
                            <div class="col-md-12 form-group">
                                <label for="endereco">Endereço<span style="color: red; font-weight: bold;">
                                        *</span></label>
                                <input id="endereco" class="form-control" type="text" name="endereco"
                                    value="{{ $solicitacao->endereco }}" autocomplete="endereco" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-row">
                    <div class="col-md-12" style="margin-bottom:20px">
                        <div class="card shadow bg-white" style="border-radius:12px; border-width:0px;">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-12" style="margin-bottom: 0.5rem">
                                        <h5 class="card-title mb-0"
                                            style="font-family:Arial, Helvetica, sans-serif; color:#08a02e; font-weight:bold">
                                            Status da solicitação</h5>
                                    </div>
                                    <div class="col-md-12">
                                        @switch($solicitacao->status)
                                            @case(\App\Models\SolicitacaoMuda::STATUS_ENUM['registrada'])
                                                <h5>Solicitação em análise.</h5>
                                            @break
                                            @case(\App\Models\SolicitacaoMuda::STATUS_ENUM['deferido'])
                                                <h5>Solicitação deferida</h5>
                                            @break
                                            @case(\App\Models\SolicitacaoMuda::STATUS_ENUM['indeferido'])
                                                <h5>Solicitação indeferida</h5>
                                                <p>Motivo: {{$solicitacao->motivo_indeferimento}}</p>
                                            @break
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
