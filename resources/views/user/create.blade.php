<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Criar analista') }}
        </h2>
    </x-slot>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">Cadastrar um novo analista</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Usuários > Criar analista</h6>
                            </div>
                        </div>
                        <form method="POST" id="cria-analista" action="{{route('usuarios.store')}}">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input id="name" class="form-control apenas_letras @error('name') is-invalid @enderror" type="text" name="name" value="{{old('name')}}" required autofocus autocomplete="name">

                                    @error('name')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="email">{{ __('Email') }}</label>
                                    <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{old('email')}}" required autofocus autocomplete="email">

                                    @error('email')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="password">{{ __('Password') }}</label>
                                    <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autofocus autocomplete="new-password">

                                    @error('password')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                    <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="tipo">{{__('Selecione o(s) cargo(s) do analista')}}</label>
                                    <input type="hidden" class="checkbox_tipo @error('tipos_analista') is-invalid @enderror">
                                    @foreach ($tipos as $tipo)
                                        <div class="form-check">
                                            <input class="checkbox_tipo" type="checkbox" name="tipos_analista[]" value="{{$tipo->id}}" id="tipo_{{$tipo->id}}">
                                            <label class="form-check-label" for="tipo_{{$tipo->id}}">
                                                @if($tipo->tipo == \App\Models\TipoAnalista::TIPO_ENUM['protocolista'])
                                                    Protocolista
                                                @elseif($tipo->tipo == \App\Models\TipoAnalista::TIPO_ENUM['processo'])
                                                    Processo
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
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6" style="text-align: right">
                                <button type="submit" id="submeterFormBotao" class="btn btn-success" form="cria-analista" style="width: 100%">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>

    function checkForm(nome_classe)
    {
        let checkboxes = document.getElementsByClassName(nome_classe);
        let form = document.getElementById('cria-analista');
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
