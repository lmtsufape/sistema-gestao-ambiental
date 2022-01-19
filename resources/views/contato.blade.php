<x-guest-layout>
    @component('layouts.nav_bar')@endcomponent
    <div class="container" style="margin-top: 50px; margin-bottom: 50px;">
        <div class="form-row justify-content-center">
            <div class="col-md-5 form-group">
                <form method="POST" action="{{route('enviar.mensagem')}}">
                    @csrf
                    <div div class="form-row">
                        @if(session('success'))
                            <div class="col-md-12" style="margin-top: 5px;">
                                <div class="alert alert-success" role="alert">
                                    <p>{{session('success')}}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 form-group">
                            <label for="nome_completo" style="margin-right: 5px;">Nome completo</label><span style="color: red; font-weight: bold;">*</span>
                            <input type="text" class="form-control @error('nome_completo') is-invalid @enderror" name="nome_completo" placeholder="Fulano de tal" required>
                            @error('nome_completo')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 form-group">
                            <label for="email" style="margin-right: 5px;">E-mail</label><span style="color: red; font-weight: bold;">*</span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="exemplo@gmail.com" required>
                            @error('email')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 form-group">
                            <label for="mensagem" style="margin-right: 5px;">Mensagem</label><span style="color: red; font-weight: bold;">*</span>
                            <textarea class="form-control @error('mensagem') is-invalid @enderror" name="mensagem" placeholder="Escreva sua mensagem aqui..." cols="30" rows="10" required></textarea>
                            @error('mensagem')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 form-group">
                            <small><span style="color: red; font-weight: bold;">* Campo obrigatório</span></small>
                        </div>
                    </div>
                    <div class="form-row justify-content-center" style="">
                        <div class="col-md-4 form-group">
                            <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao">Enviar mensagem</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4 color-default form-group" style="position: relative; transform: translate(15%, 18%); text-align: left;">
                <div class="form-row">
                    <div class="col-md-12" style="margin-bottom: 20px;">
                        Alternativas de contato
                    </div>
                </div>
                <div class="form-row" style="margin-top: 15px; margin-bottom: 15px;">
                    <div class="col-md-12">
                        <img src="{{asset('img/Icon-zocial-email.png')}}" alt="E-mail alternativo" style="display: inline;">
                        &nbsp;<a href="mailto:meioambientegaranhuns@gmail.com" style="text-decoration: none; color:black;">meioambientegaranhuns@gmail.com</a>
                    </div>
                </div>
                {{-- <div class="form-row" style="margin-top: 15px; margin-bottom: 15px;">
                    <div class="col-md-12">
                        <img src="{{asset('img/Group57.png')}}" alt="E-mail alternativo" style="display: inline;">
                        (12) 3456-7890
                    </div>
                </div>
                <div class="form-row" style="margin-top: 15px; margin-bottom: 15px;">
                    <div class="col-md-12">
                        <img src="{{asset('img/Group58.png')}}" alt="E-mail alternativo" style="display: inline;">
                        (12) 0987-6543
                    </div>
                </div> --}}
            </div>
            <div class="col-md-3 color-default form-group" style="position: relative; transform: translateY(25%); margin-bottom: 18%;">
                <div class="form-row">
                    <div class="col-md-12" style="margin-bottom: 5px;">
                        Localização
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12">
                        <iframe class="styleMapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3942.0563497105136!2d-36.4660620859275!3d-8.87434659362824!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x7070d3170819ef3%3A0x3aeb60b2c13599b7!2sCentro%20Administrativo%20II%20-%20Garanhuns%2FPE.!5e0!3m2!1spt-BR!2sbr!4v1642601634006!5m2!1spt-BR!2sbr" width="300" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @component('layouts.footer')@endcomponent
</x-guest-layout>
