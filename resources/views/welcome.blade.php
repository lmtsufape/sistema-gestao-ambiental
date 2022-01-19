<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name', 'Laravel')}}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    {{-- <link rel="stylesheet" href="{{asset('css/app.css')}}"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="icon" type="imagem/png" href="{{asset('img/icon-page.png')}}" />

    @livewireStyles

    <!-- Scripts -->
    <script src="{{asset('js/app.js')}}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.4.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" defer></script>
    <script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>

    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
    @component('layouts.nav_bar')@endcomponent
    <div class="container conteudo">
        <div class="row">
            <div class="col-md-12">
                <h6>Principais serviços</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="card card-home">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4 alinhar-direita">
                                <img src="{{asset('img/Icon ionic-ios-document.png')}}" alt="Emissão de licenças" width="30px;">
                            </div>
                        </div>
                        <div class="row espaco">
                            <div class="col-md-12">Emissão de <br>Licenças</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-home">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4 alinhar-direita">
                                <img src="{{asset('img/Icon ionic-ios-document.png')}}" alt="Emissão de licenças" width="30px;">
                            </div>
                        </div>
                        <div class="row espaco">
                            <div class="col-md-12">Renovação de <br>Licenças</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <a href="{{route('denuncias.create')}}">
                    <div class="card card-home">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4 alinhar-direita">
                                    <img src="{{asset('img/Group 67.png')}}" alt="Contato" width="49px;">
                                </div>
                            </div>
                            <div class="row espaco">
                                <div class="col-md-12">Registro de <br>Denúncias</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="#">
                    <div class="card card-home">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4 alinhar-direita">
                                    <img src="{{asset('img/Group 116.png')}}" alt="Contato" width="37px;">
                                </div>
                            </div>
                            <div class="row espaco">
                                <div class="col-md-12">Consulta de <br>Licenças ambientais</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="#">
                    <div class="card card-home">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4 alinhar-direita">
                                    <img src="{{asset('img/Group 115.png')}}" alt="Contato" width="33px;">
                                </div>
                            </div>
                            <div class="row espaco">
                                <div class="col-md-12">Acompanhamento <br>de solicitações</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{route('mudas.create')}}">
                    <div class="card card-home">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4 alinhar-direita">
                                    <img src="{{asset('img/Icon awesome-tree.png')}}" alt="Denúnciar" width="30px;">
                                </div>
                            </div>
                            <div class="row espaco">
                                <div class="col-md-12">Solicitações de poda<br>ou supressão de árvores</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="#">
                    <div class="card card-home">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4 alinhar-direita">
                                    <img src="{{asset('img/Group 116.png')}}" alt="Denúnciar" width="37px;">
                                </div>
                            </div>
                            <div class="row espaco">
                                <div class="col-md-12">Pagamentos de multas <br>ou taxas administrativas</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <div class="row" style="margin-top: 20px;">
            <div class="form-group col-md-12">
                <h6>Endereço e horário de funcionamento</h6>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12" style="margin-top: -8px;">
                <div class="" style="width:100%; height:100%;">
                    <div class="form-row">
                        <div class="cardMapa">
                            <div class="d-flex">
                                <div class="mr-auto p-2">
                                    <div class="btn-group">
                                        <div style="margin-top:2.4px;margin-left:10px;font-size:15px; font-family:'arial'; font-weight:bold; color:#707070">Secretaria de desenvolvimento rural e meio ambiente de Garanhuns - PE</div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div style="margin-right:10px; cursor:pointer;" onclick="mostrarContato('mostrar1','texto1','img1')"><span id="texto1">Fechar</span></div>
                                </div>
                            </div>
                            <div id="mostrar1" style="display:block; font-size:14px; font-family:'arial';">
                                <div class="container" style="margin-left:3px; color:#707070">Centro Administrativo II Avenida Irga, s/n - Novo Heliópolis, Garanhuns - PE, 55297-256</div>
                                <div class="container" style="margin-left:3px; color:#4a7836da; margin-bottom:10px;">Segunda a Sexta das 8h às 14h</div>
                                {{-- <div class="container" style="margin-left:3px; color:#707070; margin-bottom:10px;">(87) 3761-0697</div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @component('layouts.footer')@endcomponent
    <script>
        function mostrarContato(tipo, texto, img){
            if(tipo == "mostrar1"){
                if(document.getElementById("mostrar1").style.display == "block"){
                    document.getElementById("mostrar1").style.display = "none";
                    document.getElementById("mostrar2").style.display = "block";
                    document.getElementById("texto1").innerHTML="Mostrar";
                    document.getElementById("texto2").innerHTML="Fechar";
                    document.getElementById("img1").style.display = "none";
                    document.getElementById("img2").style.display = "block";
                }else if(document.getElementById("mostrar1").style.display == "none"){
                    document.getElementById("mostrar1").style.display = "block";
                    document.getElementById("mostrar2").style.display = "none";
                    document.getElementById("texto1").innerHTML="Fechar";
                    document.getElementById("texto2").innerHTML="Mostrar";
                    document.getElementById("img1").style.display = "block";
                    document.getElementById("img2").style.display = "none";
                }
            }else if(tipo == "mostrar2"){
                if(document.getElementById("mostrar2").style.display == "block"){
                    document.getElementById("mostrar2").style.display = "none";
                    document.getElementById("mostrar1").style.display = "block";
                    document.getElementById("texto2").innerHTML="Mostrar";
                    document.getElementById("texto1").innerHTML="Fechar";
                    document.getElementById("img2").style.display = "none";
                    document.getElementById("img1").style.display = "block";
                }else if(document.getElementById("mostrar2").style.display == "none"){
                    document.getElementById("mostrar2").style.display = "block";
                    document.getElementById("mostrar1").style.display = "none";
                    document.getElementById("texto2").innerHTML="Fechar";
                    document.getElementById("texto1").innerHTML="Mostrar";
                    document.getElementById("img2").style.display = "block";
                    document.getElementById("img1").style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
