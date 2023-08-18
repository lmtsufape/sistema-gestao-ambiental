<x-app-layout>
    @section('content')
        <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
            <div class="form-row justify-content-center">
                <div class="col-md-12">
                    <div class="form-row">
                        <div class="col-md-12">
                            <h4 class="card-title">Editar Motorista</h4>
                        </div>
                        <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                            {{-- <a title="Voltar" href="{{route('usuarios.index')}}">
                                <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="">
                            </a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-borda-esquerda" style="width: 100%;">
                        <div class="card-body">
                            <form id="form-edit-motorista" method="POST" action="{{route('pipeiros.update', $pipeiro->id)}}">
                                @csrf
                                @method('PUT')
                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <label for="motorista">{{ __('Motorista') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="motorista" class="form-control apenas_letras @error('motorista') is-invalid @enderror" type="text" name="motorista" value="{{ $pipeiro->motorista }}" required autofocus autocomplete="motorista" placeholder="Digite seu nome aqui...">
                                        @error('motorista')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="nome_apelido">{{ __('Nome (Apelido)') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="nome_apelido" class="form-control @error('nome_apelido') is-invalid @enderror" type="string" name="nome_apelido" value="{{ $pipeiro->nome_apelido }}" required autofocus autocomplete="nome_apelido" placeholder="Digite seu apelido aqui...">
                                        @error('nome_apelido')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="capacidade_tanque">{{ __('Capacidade do Tanque') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="capacidade_tanque" class="form-control @error('capacidade_tanque') is-invalid @enderror" type="string" name="capacidade_tanque" value="{{ $pipeiro->capacidade_tanque }}" required autofocus autocomplete="capacidade_tanque" placeholder="Digite a capacidade do tanque...">
                                        @error('capacidade_tanque')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6" style="text-align: right">
                                <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" form="form-edit-motorista" style="width: 100%">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
</x-guest-layout>
