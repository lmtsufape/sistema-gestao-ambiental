<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <h4 class="card-title">Editar endereço da empresa</h4>
                <h6 class="card-subtitle mb-2 text-muted">
                    <a class="text-muted" href="{{route('empresas.listar')}}">Empresas</a> > {{$empresa->nome}}
                </h6>
            </div>
            <div class="col-md-12">
                <div class="card card-borda-esquerda" style="width: 100%;">
                    <div class="card-body">
                        <form id="form-editar-endereco-empresa" method="POST" action="{{route('empresas.endereco.update', $empresa)}}">
                            @csrf
                            @method('PUT')
                            <h5 class="subtitle-form">ENDEREÇO DA EMPRESA</h5>
                            <div class="form-row">
                                <div class="col-md-4 form-group">
                                    <label for="cep_da_empresa">CEP<span class="text-danger">*</span></label>
                                    <input id="cep_da_empresa" name="cep_da_empresa" type="text" class="form-control cep @error('cep_da_empresa') is-invalid @enderror" value="{{old('cep_da_empresa', $empresa->endereco->cep)}}" required>
                                    @error('cep_da_empresa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="rua_da_empresa">Rua<span class="text-danger">*</span></label>
                                    <input id="rua_da_empresa" name="rua_da_empresa" type="text" class="form-control @error('rua_da_empresa') is-invalid @enderror" value="{{old('rua_da_empresa', $empresa->endereco->rua)}}" required>
                                    @error('rua_da_empresa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 form-group">
                                    <label for="numero_da_empresa">Número<span class="text-danger">*</span></label>
                                    <input id="numero_da_empresa" name="numero_da_empresa" type="text" class="form-control @error('numero_da_empresa') is-invalid @enderror" value="{{old('numero_da_empresa', $empresa->endereco->numero)}}" required>
                                    @error('numero_da_empresa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="bairro_da_empresa">Bairro<span class="text-danger">*</span></label>
                                    <input id="bairro_da_empresa" name="bairro_da_empresa" type="text" class="form-control @error('bairro_da_empresa') is-invalid @enderror" value="{{old('bairro_da_empresa', $empresa->endereco->bairro)}}" required>
                                    @error('bairro_da_empresa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="cidade_da_empresa">Cidade<span class="text-danger">*</span></label>
                                    <input id="cidade_da_empresa" name="cidade_da_empresa" type="text" class="form-control @error('cidade_da_empresa') is-invalid @enderror" value="{{old('cidade_da_empresa', $empresa->endereco->cidade)}}" required>
                                    @error('cidade_da_empresa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="estado_da_empresa">Estado (UF)<span class="text-danger">*</span></label>
                                    <select id="estado_da_empresa" name="estado_da_empresa" class="form-control @error('estado_da_empresa') is-invalid @enderror" required>
                                        <option value="" disabled>-- Selecione o UF --</option>
                                        @foreach (['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'] as $uf)
                                            <option value="{{$uf}}" @if(old('estado_da_empresa', $empresa->endereco->estado) == $uf) selected @endif>{{$uf}}</option>
                                        @endforeach
                                    </select>
                                    @error('estado_da_empresa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="complemento_da_empresa">Complemento</label>
                                    <textarea id="complemento_da_empresa" name="complemento_da_empresa" class="form-control @error('complemento_da_empresa') is-invalid @enderror">{{old('complemento_da_empresa', $empresa->endereco->complemento)}}</textarea>
                                    @error('complemento_da_empresa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" form="form-editar-endereco-empresa" style="width: 100%">Salvar endereço</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
