<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-12">
                        <h4 class="card-title">Solicitar um Serviço</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-borda-esquerda" style="width: 100%;">
                    <div class="card-body">
                    <form id="create-form-servico" method="POST" action="{{route('solicitacao_servicos.store')}}">
                            @csrf
                            <input type="hidden" name="data_solicitacao" value="{{ now()->format('Y-m-d') }}">
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="motorista">{{ __('Motorista') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="motorista" class="form-control @error('motorista') is-invalid @enderror" type="string" name="motorista" value="{{old('motorista')}}" required autofocus autocomplete="motorista" placeholder="Digite o nome do motorista...">
                                    @error('motorista')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="capacidade_tanque">{{ __('Capacidade do Tanque') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="capacidade_tanque" class="form-control @error('capacidade_tanque') is-invalid @enderror" type="string" name="capacidade_tanque" value="{{old('capacidade_tanque')}}" required autofocus autocomplete="capacidade_tanque" placeholder="Digite a capacidade do tanque...">
                                    @error('capacidade_tanque')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="nome_apelido">{{ __('Nome (Apelido)') }}</label>
                                    <input id="nome_apelido" class="form-control @error('nome_apelido') is-invalid @enderror" type="string" name="nome_apelido" value="{{old('nome_apelido')}}" required autofocus autocomplete="nome_apelido" placeholder="Digite o nome/apelido...">
                                    @error('nome_apelido')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="beneficiario_id">{{ __('Beneficiário') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select name="beneficiario_id" id="beneficiario_id" class="form-control @error('beneficiario_id') is-invalid @enderror" required>
                                        <option value="" selected disabled>-- {{__('Selecione o Beneficiário')}} --</option>
                                        @foreach ($beneficiarios as $beneficiario)
                                            <option @if(old('beneficiario_id') == $beneficiario->id) selected @endif value="{{$beneficiario->id}}">{{$beneficiario->nome}}</option>
                                        @endforeach
                                    </select>
                                    @error('beneficiario_id')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="observacao">{{ __('Observação') }}</label>
                                    <textarea class="form-control @error('observacao') is-invalid @enderror" type="text" name="observacao" id="observacao" cols="30" rows="5" placeholder="Digite alguma Observação">{{old('observacao')}}</textarea>
                                    @error('observacao')
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
                                <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" form="create-form-servico" style="width: 100%">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @push ('scripts')
        <script>
            
        </script>
    @endpush --}}
@endsection
</x-guest-layout>
