<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minha conta') }}
        </h2>
    </x-slot> --}}

    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <form method="POST" action="{{route('usuarios.update', ['usuario' => auth()->user()->id])}}">
            @csrf
            <div class="form-row">
                <div class="col-md-8">
                    <h2 class="card-title">{{ __('Minha conta') }}</h2>
                </div>
            </div>
            <input type="hidden" name="_method" value="PUT">
            <div div class="form-row">
                @if(session('success'))
                    <div class="col-md-12" style="margin-top: 5px;">
                        <div class="alert alert-success" role="alert">
                            <p>{{session('success')}}</p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="form-row justify-content-center" style="margin-bottom: 100px;">
                <div class="col-md-5" style="margin-bottom: 20px;">
                    <h4 class="card-title">
                        {{ __('Informações de Perfil') }}
                    </h4>
                
                    <div>
                        {{ __('Atualize as informações de perfil e endereço de e-mail de sua conta.') }}
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card card-borda-esquerda" style="width: 100%; padding: 20px;">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input id="name" class="form-control apenas_letras @error('name') is-invalid @enderror" type="text" name="name" value="{{old('name', auth()->user()->name)}}" autofocus autocomplete="name">
                                
                                    @error('name')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="email">{{ __('Email') }}</label>
                                    <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{old('email', auth()->user()->email)}}" autofocus autocomplete="email">
                                
                                    @error('email')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-9"></div>
                                <div class="col-md-3 form-group" style="text-align: right;">
                                    <button class="btn btn-success btn-color-dafault">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row justify-content-center">
                <div class="col-md-5" style="margin-bottom: 20px;">
                    <h4 class="card-title">
                        {{ __('Atualizar senha') }}
                    </h4>
                
                    <div>
                        {{ __('Certifique-se de que sua conta esteja usando uma senha longa e aleatória para permanecer segura.') }}
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card card-borda-esquerda" style="width: 100%; padding: 20px;">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="password">{{ __('Senha atual') }}</label>
                                    <input id="password" class="form-control @error('password_atual') is-invalid @enderror" type="password" name="password_atual" autofocus autocomplete="new-password">
                                
                                    @error('password_atual')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="password">{{ __('Nova senha') }}</label>
                                    <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" autofocus autocomplete="new-password">
                                
                                    @error('password')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                    <input id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" autocomplete="new-password">
                                
                                    @error('password_confirmation')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-9"></div>
                                <div class="col-md-3 form-group" style="text-align: right;">
                                    <button class="btn btn-success btn-color-dafault">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>