<x-app-layout>
    @section('content')
    <div class="container" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Cadastrar um novo cnae</h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('setores.index')}}">Grupos</a> > Cnaes do grupo {{$setor->nome}} > Criar cnae</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        {{-- <a title="Voltar" href="{{route('setores.show', ['setore' => $setor->id])}}"><img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar"></a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card card-borda-esquerda" style="width: 100%;">
                    <div class="card-body">
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
                                    <label for="nome">{{ __('Nome') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="nome" class="form-control @error('nome') is-invalid @enderror" type="text" name="nome" value="{{old('nome')}}" required autofocus autocomplete="nome" placeholder="Digite o nome do cnae...">

                                    @error('nome')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="codigo">{{ __('Código') }}</label>
                                    <input id="codigo" class="form-control @error('codigo') is-invalid @enderror" type="text" name="codigo" value="{{old('codigo')}}" autofocus autocomplete="codigo" placeholder="Digite o código do cnae">

                                    @error('codigo')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="potencial_poluidor">{{ __('Potencial Poluidor') }}</label><br>
                                    <select class="form-select form-select-sm form-control" name="potencial_poluidor" aria-label=".form-select-sm example">
                                        <option value="">-- Selecionar potencial poluidor --</option>
                                        <option value="baixo">Baixo</option>
                                        <option value="medio">Médio</option>
                                        <option value="alto">Alto</option>
                                        <option value="a_definir">A definir</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6" style="text-align: right">
                                <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" form="criar-cnae" style="width: 100%">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
