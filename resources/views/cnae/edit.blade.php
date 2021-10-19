<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar cnae') }}
        </h2>
    </x-slot>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">Editar o cnae {{$cnae->nome}}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Tipologia > Cnae > Editar cnae</h6>
                            </div>
                        </div>
                        <div div class="form-row">
                            <div class="col-sm-12">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <form method="POST" id="editar-cnae" action="{{route('cnaes.update', $cnae->id)}}">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-row">
                                <div class="col-md-4 form-group">
                                    <label for="nome">{{ __('Nome') }}</label>
                                    <input id="nome" class="form-control @error('nome') is-invalid @enderror" type="text" name="nome" value="{{old('nome')!=null ? old('nome') : $cnae->nome}}" required autofocus autocomplete="nome">

                                    @error('nome')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="codigo">{{ __('Código') }}</label>
                                    <input id="codigo" class="form-control @error('codigo') is-invalid @enderror" type="text" name="codigo"  value="{{old('codigo')!=null ? old('codigo') : $cnae->codigo}}" required autofocus autocomplete="codigo">

                                    @error('codigo')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="potencial_poluidor">{{ __('Potencial Poluidor') }}</label><br>
                                    <select class="form-select form-select-sm" name="potencial_poluidor" aria-label=".form-select-sm example">
                                        <option value="">-- Selecionar potencial poluidor --</option>
                                        @if(old('potencial_poluidor') != null)
                                            <option @if(old('potencial_poluidor') == "baixo") selected @endif value="baixo">Baixo</option>
                                            <option @if(old('potencial_poluidor') == "medio") selected @endif value="medio">Médio</option>
                                            <option @if(old('potencial_poluidor') == "alto") selected @endif value="alto">Alto</option>
                                        @else
                                            <option @if($cnae->potencial_poluidor == 1) selected @endif value="baixo">Baixo</option>
                                            <option @if($cnae->potencial_poluidor == 2) selected @endif value="medio">Médio</option>
                                            <option @if($cnae->potencial_poluidor == 3) selected @endif value="alto">Alto</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6" style="text-align: right">
                                <button type="submit" id="submeterFormBotao" class="btn btn-success" form="editar-cnae" style="width: 100%">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
