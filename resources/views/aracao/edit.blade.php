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
                            <form id="editar-aracao" method="POST" action="{{ route('aracao.update', $aracao->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cultura">{{ __('Cultura') }}<span
                                                style="color: red; font-weight: bold;">*</span></label>
                                        <input id="cultura" class="form-control" type="string" name="cultura"
                                            value="{{ $aracao->cultura }}" required autofocus autocomplete="cultura">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="ponto_localizacao">{{ __('Ponto de Localização') }}<span
                                                style="color: red; font-weight: bold;">*</span></label>
                                        <input id="ponto_localizacao" class="form-control" type="string"
                                            name="ponto_localizacao" value="{{ $aracao->ponto_localizacao }}" required
                                            autofocus autocomplete="ponto_localizacao"
                                            placeholder="Digite o ponto de localização...">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="quantidade_horas">{{ __('Quantidade de Horas') }}<span
                                                style="color: red; font-weight: bold;">*</span></label>
                                        <input id="quantidade_horas" class="form-control" type="string"
                                            name="quantidade_horas" value="{{ $aracao->quantidade_horas }}" required
                                            autofocus autocomplete="quantidade_horas"
                                            placeholder="Digite a quantidade de Horas...">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="quantidade_ha">{{ __('Quantidade de Ha') }}<span
                                                style="color: red; font-weight: bold;">*</span></label>
                                        <input id="quantidade_ha" class="form-control" type="string" name="quantidade_ha"
                                            value="{{ $aracao->quantidade_ha }}" required autofocus
                                            autocomplete="quantidade_ha" placeholder="Digite a quantidade de Ha...">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="beneficiario_id">{{ __('Beneficiário') }}<span
                                                style="color: red; font-weight: bold;">*</span></label>
                                        <select name="beneficiario_id" id="beneficiario_id"
                                            class="form-control selectpicker @error('beneficiario_id') is-invalid @enderror"
                                            data-live-search="true" required>
                                            <option value="" disabled>-- {{ __('Selecione o Beneficiário') }} --
                                            </option>
                                            @foreach ($beneficiarios as $beneficiario)
                                                <option @if (old('beneficiario_id', $aracao->beneficiario_id) == $beneficiario->id) selected @endif
                                                    value="{{ $beneficiario->id }}">{{ $beneficiario->nome }}</option>
                                            @endforeach
                                        </select>
                                        @error('beneficiario_id')
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
                                    <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao"
                                        form="editar-aracao" style="width: 100%">Editar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- @push('scripts')
        <script>
            
        </script>
    @endpush --}}
    @endsection
    </x-guest-layout>
