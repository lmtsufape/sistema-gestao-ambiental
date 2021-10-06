<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Criar cnae') }}
        </h2>
    </x-slot>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">Cadastrar um novo cnae</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Tipologia > Cnae > Criar cnae</h6>
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
                        <form method="POST" id="criar-cnae" action="{{route('cnaes.store')}}">
                            @csrf
                            <input type="hidden" name="setor" value="{{$setor->id}}">
                            <div class="form-row">
                                <div class="col-md-4 form-group">
                                    <label for="nome">{{ __('Nome') }}</label>
                                    <input id="nome" class="form-control @error('nome') is-invalid @enderror" type="text" name="nome" value="{{old('nome')}}" required autofocus autocomplete="nome">

                                    @error('nome')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="codigo">{{ __('Código') }}</label>
                                    <input id="codigo" class="form-control @error('codigo') is-invalid @enderror" type="text" name="codigo" value="{{old('codigo')}}" required autofocus autocomplete="codigo">

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
                                        <option value="baixo">Baixo</option>
                                        <option value="medio">Médio</option>
                                        <option value="alto">Alto</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">

                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6" style="text-align: right">
                                <button type="submit" class="btn btn-success" form="criar-cnae" style="width: 100%">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
