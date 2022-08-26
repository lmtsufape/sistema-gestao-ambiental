<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-12">
                        <h4 class="card-title">Editando um usuário</h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('usuarios.index')}}">Usuários</a> > Editar usuário</h6>
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
                        <form method="POST" id="editar-usuario" action="{{route('usuarios.editar', $usuario)}}">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="name">{{ __('Name') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="name" class="form-control apenas_letras @error('name') is-invalid @enderror" type="text" name="name" value="{{old('name', $usuario->name)}}" required autofocus autocomplete="name" placeholder="Digite o nome do usuário...">

                                    @error('name')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="email">{{ __('E-mail') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{old('email', $usuario->email)}}" required autofocus autocomplete="email" placeholder="Digite o e-mail do usuário...">

                                    @error('email')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            @if($usuario->role == \App\Models\User::ROLE_ENUM['analista'])
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="tipo">{{__('Selecione o(s) cargo(s) do analista')}}<span style="color: red; font-weight: bold;">*</span></label>
                                        <input type="hidden" class="checkbox_tipo @error('tipos_analista') is-invalid @enderror">
                                        @foreach ($tipos as $tipo)
                                            <div class="form-check">
                                                <input class="checkbox_tipo checkbox-licenciamento" type="checkbox" name="tipos_analista[]" value="{{$tipo->id}}" id="tipo_{{$tipo->id}}"
                                                @if($tipo->tipo == \App\Models\TipoAnalista::TIPO_ENUM['protocolista'] &&
                                                    $usuario->tipoAnalista()->where('tipo', \App\Models\TipoAnalista::TIPO_ENUM['protocolista'])->get()->count() > 0) checked
                                                @elseif($tipo->tipo == \App\Models\TipoAnalista::TIPO_ENUM['processo'] &&
                                                    $usuario->tipoAnalista()->where('tipo', \App\Models\TipoAnalista::TIPO_ENUM['processo'])->get()->count() > 0) checked
                                                @elseif($tipo->tipo == \App\Models\TipoAnalista::TIPO_ENUM['poda'] &&
                                                    $usuario->tipoAnalista()->where('tipo', \App\Models\TipoAnalista::TIPO_ENUM['poda'])->get()->count() > 0) checked
                                                @endif>
                                                <label class="form-check-label" for="tipo_{{$tipo->id}}">
                                                    @if($tipo->tipo == \App\Models\TipoAnalista::TIPO_ENUM['protocolista'])
                                                        Protocolista
                                                    @elseif($tipo->tipo == \App\Models\TipoAnalista::TIPO_ENUM['processo'])
                                                        Processo
                                                    @elseif($tipo->tipo == \App\Models\TipoAnalista::TIPO_ENUM['poda'])
                                                        Mudas e poda
                                                    @endif
                                                </label>
                                            </div>
                                        @endforeach
                                        @error('tipos_analista')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6" style="text-align: right">
                                <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao" form="editar-usuario" style="width: 100%">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push ('scripts')
        <script>
            function checkForm(nome_classe)
            {
                let checkboxes = document.getElementsByClassName(nome_classe);
                let form = document.getElementById('editar-usuario');
                let selecionado = false;
                for(let i = 0; i < checkboxes.length; i++){
                    if(checkboxes[i].checked){
                        selecionado = true;
                        break
                    }
                }
                if (!selecionado){
                    alert('Selecione um cargo para o analista!');
                }
            }

        </script>
    @endpush
    @endsection
</x-app-layout>


