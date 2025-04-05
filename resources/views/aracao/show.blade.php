<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-12">
                        <h4 class="card-title">Informações da aração</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-borda-esquerda" style="width: 100%;">
                    <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="cultura">{{ __('Cultura') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="cultura" class="form-control" type="string" name="cultura" value="{{ $aracao->cultura }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="ponto_localizacao">{{ __('Ponto de Referência') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="ponto_localizacao" class="form-control" type="string" name="ponto_localizacao" value="{{ $aracao->ponto_localizacao }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="quantidade_horas">{{ __('Quantidade de Horas') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="quantidade_horas" class="form-control" type="string" name="quantidade_horas" value="{{ $aracao->quantidade_horas }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="quantidade_horas">{{ __('Quantidade de Ha') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="quantidade_horas" class="form-control" type="string" name="quantidade_horas" value="{{ $aracao->quantidade_horas }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="beneficiario">{{ __('Beneficiário') }}</label>
                                    <input id="beneficiario" class="form-control" type="string" name="beneficiario" value="{{ $aracao->beneficiario->nome }}" readonly>
                                </div>
                            </div>

                            <hr class="divisor">
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="distrito">{{ __('Distrito') }}</label>
                                        <input id="distrito" class="form-control" type="string" name="distrito" value="{{ $aracao->beneficiario->endereco->distrito }}" readonly>
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="comunidade">{{ __('Comunidade') }}</label>
                                        <input id="comunidade" class="form-control" type="string" name="comunidade" value="{{ $aracao->beneficiario->endereco->comunidade }}" readonly>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="numero">{{ __('Número') }}</label>
                                        <input id="numero" class="form-control" type="string" name="numero" value="{{ $aracao->beneficiario->endereco->numero }}" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="cidade">{{ __('Cidade') }}</label>
                                        <input id="cidade" class="form-control" type="string" name="cidade" value="{{ $aracao->beneficiario->endereco->cidade }}" readonly>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="uf">{{ __('Estado') }}</label>
                                        <input id="uf" class="form-control" type="string" name="uf" value="{{ $aracao->beneficiario->endereco->estado }}" readonly>
                                    </div>
                                </div>
                            <hr class="divisor">
                        @if ($aracao->fotos->isNotEmpty())
                            <div class="form-row">
                                <div class="col-md-12">
                                    <h5>Galeria</h5>
                                </div>
                            </div>
                            <div class="form-row">
                                @foreach ($aracao->fotos as $index => $foto)
                                    <div class="col-md-6 text-center mb-4">
                                        <h5 class="text-muted">
                                            {{ $index === 0 ? 'Antes' : 'Depois' }}
                                        </h5>
                                        <div class="card shadow-sm p-2 d-flex align-items-center justify-content-center mx-auto"
                                             style="max-width: 100%; border-radius: 10px;">
                                            <img src="{{ url("aracao/$aracao->id/imagem/" . basename($foto->caminho)) }}"
                                                 class="img-fluid rounded"
                                                 style="max-width: 300px; height: auto;">
                                        </div>
                                        @if ($foto->comentario)
                                            <p class="mt-2 text-muted" style="font-size: 18px; max-width: 300px; margin-left: auto; margin-right: auto;">
                                                <strong>Comentário:</strong> {{ $foto->comentario }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
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
</x-app-layout>
