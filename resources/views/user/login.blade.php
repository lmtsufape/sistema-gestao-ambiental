<x-app-layout>
    <div class="container container-profile" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="container">
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div class="row">
                    <div class="col-md-2 form-group justify-content-center">
                        <img id="photo"src="{{auth()->user()->profile_photo_path != null ? asset('storage/'.auth()->user()->profile_photo_path) : asset('img/user_img_perfil.png')}}" alt="Imagem de perfil">
                    </div>
                    <div class="col-md-10">
                        <div class="row" style="margin-top: 10px;">
                            <label class="title-profile">{{auth()->user()->name}}</label>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <label class="subtitle-profile">Usuário</label>
                        </div>
                    </div>
                </div>
            @endif
            <br>
            <div class="row">
                <div class="col-md-12">
                    <form id="form-alterar-email-senha" method="POST" action="{{route('usuarios.update', ['usuario' => auth()->user()->id])}}">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col-md-11">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <h4 class="subtitle-form">INFORMAÇÕES DE LOGIN</h4>
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <label for="e-mail">E-mail</label>
                                        <input type="text" id="e-mail" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email', auth()->user()->email)}}">
            
                                        @error('email')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <label for="password_atual">Senha atual</label>
                                        <input type="password" id="password_atual" name="password_atual" class="form-control @error('password_atual') is-invalid @enderror" value="">
            
                                        @error('password_atual')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <label for="password">Nova senha</label>
                                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" value="">
            
                                        @error('password')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 form-group">
                                        <label for="password_confirmation">Confirmar senha</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" value="">
            
                                        @error('password_confirmation')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 form-group" style="text-align: right;">
                                        <button class="btn btn-success btn-color-dafault" style="width: 50%;">Salvar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>