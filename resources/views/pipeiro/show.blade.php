<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-12">
                        <h4 class="card-title">Informações do Motorista</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-borda-esquerda" style="width: 100%;">
                    <div class="card-body">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="motorista">{{ __('Motorista') }}</label>
                                    <input id="motorista" class="form-control" type="text" name="motorista" value="{{ $pipeiro->motorista }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="nome_apelido">{{ __('Nome (Apelido)') }}</label>
                                    <input id="nome_apelido" class="form-control" type="string" name="nome_apelido" value="{{ $pipeiro->nome_apelido }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="capacidade_tanque">{{ __('Capacidade do Tanque') }}</label>
                                    <input id="capacidade_tanque" class="form-control" type="number" name="capacidade_tanque" value="{{ $pipeiro->capacidade_tanque }}" readonly>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>