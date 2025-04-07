<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-12">
                        <h4 class="card-title">Editar serviço</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-borda-esquerda" style="width: 100%;">
                    <div class="card-body">
                        <form id="editar-solicitacao_servico" method="POST" action="{{route('solicitacao_servicos.update', $solicitacao_servico->id)}}">
                            @csrf
                            @method('PUT')
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="data_solicitacao">{{ __('Data da Solicitação') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="data_solicitacao" class="form-control" type="date" name="data_solicitacao" value="{{ $solicitacao_servico->data_solicitacao }}" required autofocus autocomplete="data_solicitacao">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="data_saida">{{ __('Data da saída') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="data_saida" class="form-control" type="date" name="data_saida" value="{{ $solicitacao_servico->data_saida }}">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="beneficiario_id">{{ __('Beneficiário') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <select name="beneficiario_id" id="beneficiario_id" class="form-control selectpicker @error('beneficiario_id') is-invalid @enderror" data-live-search="true"  required>
                                            <option value="" disabled>-- {{__('Selecione o Beneficiário')}} --</option>
                                            @foreach ($beneficiarios as $beneficiario)
                                                <option @if(old('beneficiario_id', $solicitacao_servico->beneficiario_id) == $beneficiario->id) selected @endif value="{{$beneficiario->id}}">{{$beneficiario->nome}}</option>
                                            @endforeach
                                        </select>
                                        @error('beneficiario_id')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="codigo_solicitante">{{ __('Código do Solicitante') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="data_entrega" class="form-control" type="text" name="codigo_solicitante" value="{{ $solicitacao_servico->codigo_solicitante }}" >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="data_entrega">{{ __('Data de entrega') }}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input id="data_entrega" class="form-control" type="date" name="data_entrega" value="{{ $solicitacao_servico->data_entrega }}" >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <label for="observacao">{{ __('Observação') }}</label>
                                        <input id="observacao" class="form-control" type="string" name="observacao" value="{{ $solicitacao_servico->observacao }}"  placeholder="Digite alguma Observação">
                                    </div>
                                </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6" style="text-align: right">
                                <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" form="editar-solicitacao_servico" style="width: 100%">Editar</button>
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
