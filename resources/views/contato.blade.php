<x-guest-layout>
    @component('layouts.nav_bar')@endcomponent
    <div class="container" style="margin-top: 50px; margin-bottom: 50px;">
        <div class="form-row">
            <div class="col-md-6 form-group">
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
                            <label for="nome_completo" style="margin-right: 5px;">Nome completo</label><span style="color: red; font-weight: bold;">*</span>Campo obrigatório
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
                            <label for="email" style="margin-right: 5px;">E-mail</label><span style="color: red; font-weight: bold;">*</span>Campo obrigatório
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
                            <label for="mensagem" style="margin-right: 5px;">Mensagem</label><span style="color: red; font-weight: bold;">*</span>Campo obrigatório
                            <textarea class="form-control @error('mensagem') is-invalid @enderror" name="mensagem" placeholder="Escreva sua mensagem aqui..." cols="30" rows="10" required></textarea>
                            @error('mensagem')
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row justify-content-center" style="">
                        <div class="col-md-4 form-group">
                            <button type="submit" class="btn btn-success btn-color-dafault submeterFormBotao">Enviar mensagem</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3 color-default form-group" style="position: relative; transform: translate(15%, 18%); text-align: left;">
                <div class="form-row">
                    <div class="col-md-12" style="margin-bottom: 20px;">
                        Alternativas de contato
                    </div>
                </div>
                <div class="form-row" style="margin-top: 15px; margin-bottom: 15px;">
                    <div class="col-md-12">
                        <img src="{{asset('img/Icon-zocial-email.png')}}" alt="E-mail alternativo" style="display: inline;">
                        &nbsp;exemplo@gov.com.br
                    </div>
                </div>
                <div class="form-row" style="margin-top: 15px; margin-bottom: 15px;">
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
                </div>
            </div>
            <div class="col-md-3 color-default form-group" style="position: relative; transform: translateY(25%); margin-bottom: 18%;">
                <div class="form-row">
                    <div class="col-md-12" style="margin-bottom: 5px;">
                        Localização
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12">
                        <div id="img1" style="display:block">
                            <a href="https://www.google.com.br/maps/place/Centro+Administrativo+II+-+Garanhuns%2FPE./@-8.8750303,-36.4646566,17z/data=!4m5!3m4!1s0x7070d3170819ef3:0x3aeb60b2c13599b7!8m2!3d-8.8743494!4d-36.4638736" target="_blanck">
                                <img class="styleMapa" src="{{asset('img/mapa_ssg.png')}}" alt="Imagem com mapa do local da secretária de meio ambiente" style="width:100%; height:100%;"/>
                            </a>
                        </div>
                        <div id="img2" style="display:none">
                            <a href="">
                                <img  class="styleMapa" src="{{asset('img/mapa_sms.png')}}" alt="Imagem com mapa do local da secretária de meio ambiente" style="width:100%; height:100%;"/>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @component('layouts.footer')@endcomponent
</x-guest-layout>
