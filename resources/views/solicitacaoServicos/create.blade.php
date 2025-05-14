<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-12">
                        <h4 class="card-title">Adicionar solicitação</h4>
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
                                    <label for="beneficiario_id">{{ __('Beneficiário') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select name="beneficiario_id" id="beneficiario_id" class="form-control selectpicker @error('beneficiario_id') is-invalid @enderror"  data-live-search="true" required>
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

                                <div class="col-md-6 form-group">
                                    <label for="codigo_solicitante">{{ __('Código do Solicitante') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input name="codigo_solicitante" id="codigo_solicitante" class="form-control @error('codigo_solicitante') is-invalid @enderror"  data-live-search="true" required/>
                                    {{-- @error('codigo_solicitante')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror --}}
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
